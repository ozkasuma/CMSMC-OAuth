<?php
/**
 * OAuth Logout Action
 * 
 * Logs out the current user by clearing their session.
 */
if (!isset($gCms)) exit;

$returnUrl = $params['return_url'] ?? $params['redirect'] ?? null;

// If no return URL specified, use default
if (!$returnUrl) {
    $returnUrl = $this->GetDefaultRedirect();
}

// Get current user before clearing session (for event)
$user = $this->GetCurrentUser();

if ($user) {
    // Clear the session
    $this->ClearSession();
    
    // Fire logout event
    $this->SendEvent('OAuthUserLogout', [
        'user' => $user,
    ]);
    
    audit('', $this->GetName(), 'User logged out: ' . ($user['email'] ?? $user['user_id']));
    
    // Set success message
    $_SESSION['oauth_success'] = $this->Lang('logout_success');
}

// Redirect
header('Location: ' . $returnUrl);
exit;
