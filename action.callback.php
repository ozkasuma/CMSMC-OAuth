<?php
/**
 * OAuth Callback Action
 * 
 * Handles the OAuth callback from providers.
 * Exchanges code for token, fetches user info, creates/updates user, and establishes session.
 */
if (!isset($gCms)) exit;

// Provider comes from module params (m1_provider)
$provider = $params['provider'] ?? null;

// OAuth providers send code/state/error as raw query params (not prefixed)
// So we need to check both $params and $_GET
$code = $params['code'] ?? $_GET['code'] ?? null;
$state = $params['state'] ?? $_GET['state'] ?? null;
$error = $params['error'] ?? $_GET['error'] ?? null;
$errorDescription = $params['error_description'] ?? $_GET['error_description'] ?? '';

// Handle OAuth errors from provider
if ($error) {
    $this->ClearState();
    $errorMsg = $errorDescription ?: $this->Lang('error_oauth_' . $error, $error);
    audit('', $this->GetName(), 'OAuth error from provider: ' . $error . ' - ' . $errorDescription);
    
    // Redirect to home with error
    $redirectUrl = $this->GetDefaultRedirect();
    $_SESSION['oauth_error'] = $errorMsg;
    header('Location: ' . $redirectUrl);
    exit;
}

// Validate required parameters
if (!$provider || !$code || !$state) {
    audit('', $this->GetName(), 'OAuth callback missing required parameters');
    $redirectUrl = $this->GetDefaultRedirect();
    $_SESSION['oauth_error'] = $this->Lang('error_invalid_callback');
    header('Location: ' . $redirectUrl);
    exit;
}

// Validate state (CSRF protection)
$stateData = $this->ValidateState($state);
if (!$stateData) {
    audit('', $this->GetName(), 'OAuth callback state validation failed');
    $redirectUrl = $this->GetDefaultRedirect();
    $_SESSION['oauth_error'] = $this->Lang('error_invalid_state');
    header('Location: ' . $redirectUrl);
    exit;
}

// Clear state after validation
$this->ClearState();

// Get the return URL from state
$returnUrl = $stateData['return_url'] ?? $this->GetDefaultRedirect();

// Get the provider
$providerObj = $this->GetProvider($provider);
if (!$providerObj) {
    audit('', $this->GetName(), 'OAuth callback: provider not configured - ' . $provider);
    $_SESSION['oauth_error'] = $this->Lang('error_provider_not_configured', $provider);
    header('Location: ' . $returnUrl);
    exit;
}

// Set redirect URI (must match what was used in authorization)
$callbackUrl = $this->GetCallbackUrl($provider);
$providerObj->setRedirectUri($callbackUrl);

try {
    // Exchange code for access token
    $tokenData = $providerObj->exchangeCodeForToken($code);
    
    $accessToken = $tokenData['access_token'];
    $refreshToken = $tokenData['refresh_token'] ?? null;
    $expiresIn = $tokenData['expires_in'] ?? null;
    $expiresAt = $expiresIn ? date('Y-m-d H:i:s', time() + $expiresIn) : null;
    
    // Fetch user info from provider
    $userInfo = $providerObj->fetchUserInfo($accessToken);
    
    if (empty($userInfo['id'])) {
        throw new Exception('Provider did not return user ID');
    }
    
    // Create or update user in our database
    $userId = $this->CreateOrUpdateUser($provider, $userInfo['id'], $userInfo);
    
    // Store tokens
    $this->UpdateTokens($provider, $userInfo['id'], $accessToken, $refreshToken, $expiresAt);
    
    // Create session
    $this->CreateSession($userId);
    
    // Get the full user for the event
    $user = $this->GetCurrentUser();
    
    // Fire events
    $this->SendOAuthEvent('OAuthUserLogin', [
        'user' => $user,
        'provider' => $provider,
        'user_info' => $userInfo,
    ]);
    
    // Check if this is a new user (created in the last few seconds)
    if ($user && strtotime($user['created_at']) > time() - 5) {
        $this->SendOAuthEvent('OAuthUserCreated', [
            'user' => $user,
            'provider' => $provider,
        ]);
    }
    
    audit('', $this->GetName(), 'User logged in via ' . $provider . ': ' . ($userInfo['email'] ?? $userInfo['id']));
    
    // Set success message
    $_SESSION['oauth_success'] = $this->Lang('login_success', $providerObj->getDisplayName());
    
    // Redirect to return URL
    header('Location: ' . $returnUrl);
    exit;
    
} catch (Exception $e) {
    audit('', $this->GetName(), 'OAuth callback error: ' . $e->getMessage());
    $_SESSION['oauth_error'] = $this->Lang('error_authentication_failed') . ': ' . $e->getMessage();
    header('Location: ' . $returnUrl);
    exit;
}
