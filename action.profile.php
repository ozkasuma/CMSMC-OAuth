<?php
/**
 * OAuth Profile Action
 * 
 * Displays the current user's profile or a login prompt if not authenticated.
 */
if (!isset($gCms)) exit;

$smarty->assign('mod', $this);

// Get current user
$user = $this->GetCurrentUser();

if (!$user) {
    // User is not logged in - show login prompt or buttons
    $smarty->assign('is_logged_in', false);
    $smarty->assign('user', null);
    
    // If show_login is true, display login buttons
    $showLogin = isset($params['show_login']) ? (bool)$params['show_login'] : true;
    
    if ($showLogin) {
        // Reuse login template logic
        $enabledProviders = $this->GetEnabledProviders();
        $returnUrl = $_SERVER['REQUEST_URI'] ?? '/';
        
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
    }
    
    echo $this->ProcessOAuthTemplate('profile', $params['profiletemplate'] ?? null);
    return;
}

// User is logged in
$smarty->assign('is_logged_in', true);
$smarty->assign('user', $user);

// Get linked providers
$linkedProviders = [];
if (!empty($user['providers'])) {
    foreach ($user['providers'] as $providerName => $providerData) {
        $providerObj = $this->GetProvider($providerName);
        if ($providerObj) {
            $linkedProviders[$providerName] = [
                'key' => $providerName,
                'name' => $providerObj->getDisplayName(),
                'icon' => $providerObj->getIcon(),
                'color' => $providerObj->getButtonColor(),
                'user_id' => $providerData['id'],
                'profile' => $providerData['profile'],
            ];
        }
    }
}
$smarty->assign('linked_providers', $linkedProviders);

// Generate logout URL
$logoutUrl = $this->CreateLink($id, 'logout', $returnid, '', 
    ['return_url' => $_SERVER['REQUEST_URI'] ?? '/'], '', true);
$smarty->assign('logout_url', $logoutUrl);

$smarty->assign('returnid', $returnid);
$smarty->assign('actionid', $id);

// Check for session messages
if (!empty($_SESSION['oauth_success'])) {
    $smarty->assign('success_message', $_SESSION['oauth_success']);
    unset($_SESSION['oauth_success']);
}
if (!empty($_SESSION['oauth_error'])) {
    $smarty->assign('error_message', $_SESSION['oauth_error']);
    unset($_SESSION['oauth_error']);
}

echo $this->ProcessOAuthTemplate('profile', $params['profiletemplate'] ?? null);
