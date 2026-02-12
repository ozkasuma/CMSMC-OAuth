<?php
/**
 * OAuth Login Action
 * 
 * Displays login buttons for enabled OAuth providers.
 * If a specific provider is requested, initiates the OAuth flow.
 */
if (!isset($gCms)) exit;

$smarty->assign('mod', $this);

// Get the provider parameter
$provider = $params['provider'] ?? null;
$returnUrl = $params['return_url'] ?? $params['redirect'] ?? null;

// If no return URL specified, try to get current page
if (!$returnUrl) {
    $returnUrl = $_SERVER['REQUEST_URI'] ?? '/';
}

// If a specific provider is requested, initiate OAuth flow
if ($provider) {
    $providerObj = $this->GetProvider($provider);
    
    if (!$providerObj) {
        $smarty->assign('error', $this->Lang('error_provider_not_configured', $provider));
        echo $this->ProcessOAuthTemplate('login', $params['logintemplate'] ?? null);
        return;
    }
    
    // Check HTTPS requirement
    if ($this->RequireHttps() && empty($_SERVER['HTTPS'])) {
        $smarty->assign('error', $this->Lang('error_https_required'));
        echo $this->ProcessOAuthTemplate('login', $params['logintemplate'] ?? null);
        return;
    }
    
    // Generate state token for CSRF protection
    $state = $this->GenerateState($returnUrl);
    
    // Set redirect URI
    $callbackUrl = $this->GetCallbackUrl($provider);
    $providerObj->setRedirectUri($callbackUrl);
    
    // Build authorization URL and redirect
    $authUrl = $providerObj->buildAuthorizationUrl($state);
    
    // Redirect to provider
    header('Location: ' . $authUrl);
    exit;
}

// Display login buttons for all enabled providers
$enabledProviders = $this->GetEnabledProviders();

if (empty($enabledProviders)) {
    $smarty->assign('error', $this->Lang('error_no_providers'));
    echo $this->ProcessOAuthTemplate('login', $params['logintemplate'] ?? null);
    return;
}

// Check if user is already logged in
$currentUser = $this->GetCurrentUser();
if ($currentUser) {
    $smarty->assign('user', $currentUser);
    $smarty->assign('is_logged_in', true);
}

// Build provider data with icons and URLs
$providers = [];
foreach ($enabledProviders as $key => $label) {
    $providerObj = $this->GetProvider($key);
    if ($providerObj) {
        $providers[$key] = [
            'key' => $key,
            'name' => $label,
            'display_name' => $providerObj->getDisplayName(),
            'icon' => $providerObj->getIcon(),
            'color' => $providerObj->getButtonColor(),
            'login_url' => $this->CreateLink($id, 'login', $returnid, '', 
                ['provider' => $key, 'return_url' => $returnUrl], '', true),
        ];
    }
}

$smarty->assign('providers', $providers);
$smarty->assign('return_url', $returnUrl);
$smarty->assign('returnid', $returnid);
$smarty->assign('actionid', $id);

echo $this->ProcessOAuthTemplate('login', $params['logintemplate'] ?? null);
