<?php
/**
 * OAuth Admin Dashboard
 * 
 * Main admin panel for configuring OAuth providers.
 */
if (!isset($gCms)) exit;

// Check permissions
if (!$this->CheckPermission('Manage OAuth')) {
    echo $this->ShowErrors($this->Lang('error_permission_denied'));
    return;
}

$db = $this->GetDb();
$prefix = CMS_DB_PREFIX;

// Handle form submission
if (isset($params['submit'])) {
    // Save general settings
    $this->SetPreference('require_https', isset($params['require_https']) ? 1 : 0);
    $this->SetPreference('default_redirect', $params['default_redirect'] ?? '/');
    
    // Save provider settings
    $providers = ['github', 'google', 'facebook', 'twitter', 'generic'];
    foreach ($providers as $provider) {
        $this->SetPreference('provider_' . $provider . '_enabled', 
            isset($params['provider_' . $provider . '_enabled']) ? 1 : 0);
        $this->SetPreference('provider_' . $provider . '_client_id', 
            trim($params['provider_' . $provider . '_client_id'] ?? ''));
        $this->SetPreference('provider_' . $provider . '_client_secret', 
            trim($params['provider_' . $provider . '_client_secret'] ?? ''));
        $this->SetPreference('provider_' . $provider . '_scopes', 
            trim($params['provider_' . $provider . '_scopes'] ?? ''));
    }
    
    // Generic provider extra settings
    $this->SetPreference('provider_generic_authorize_url', 
        trim($params['provider_generic_authorize_url'] ?? ''));
    $this->SetPreference('provider_generic_token_url', 
        trim($params['provider_generic_token_url'] ?? ''));
    $this->SetPreference('provider_generic_userinfo_url', 
        trim($params['provider_generic_userinfo_url'] ?? ''));
    
    $this->SetMessage($this->Lang('settings_saved'));
    $this->RedirectToAdminTab('', '', $id);
    return;
}

// Get statistics
$totalUsers = $db->GetOne("SELECT COUNT(*) FROM {$prefix}module_oauth_users");
$totalSessions = $db->GetOne("SELECT COUNT(*) FROM {$prefix}module_oauth_sessions WHERE expires_at > NOW()");
$recentLogins = $db->GetArray(
    "SELECT u.*, l.provider 
     FROM {$prefix}module_oauth_users u 
     LEFT JOIN {$prefix}module_oauth_links l ON u.user_id = l.user_id 
     ORDER BY u.last_login DESC 
     LIMIT 10"
);

// Provider stats
$providerStats = $db->GetArray(
    "SELECT provider, COUNT(*) as count 
     FROM {$prefix}module_oauth_links 
     GROUP BY provider"
);
$providerCounts = [];
foreach ($providerStats as $stat) {
    $providerCounts[$stat['provider']] = $stat['count'];
}

// Get current settings
$settings = [
    'require_https' => $this->GetPreference('require_https', 1),
    'default_redirect' => $this->GetPreference('default_redirect', '/'),
];

// Get provider configurations
$providerConfigs = [];
foreach (['github', 'google', 'facebook', 'twitter', 'generic'] as $provider) {
    $providerConfigs[$provider] = [
        'enabled' => $this->GetPreference('provider_' . $provider . '_enabled', 0),
        'client_id' => $this->GetPreference('provider_' . $provider . '_client_id', ''),
        'client_secret' => $this->GetPreference('provider_' . $provider . '_client_secret', ''),
        'scopes' => $this->GetPreference('provider_' . $provider . '_scopes', ''),
    ];
}
// Generic extra settings
$providerConfigs['generic']['authorize_url'] = $this->GetPreference('provider_generic_authorize_url', '');
$providerConfigs['generic']['token_url'] = $this->GetPreference('provider_generic_token_url', '');
$providerConfigs['generic']['userinfo_url'] = $this->GetPreference('provider_generic_userinfo_url', '');

// Get callback URLs for display
$callbackUrls = [];
foreach (['github', 'google', 'facebook', 'twitter', 'generic'] as $provider) {
    $callbackUrls[$provider] = $this->GetCallbackUrl($provider);
}

$smarty->assign('mod', $this);
$smarty->assign('settings', $settings);
$smarty->assign('providerConfigs', $providerConfigs);
$smarty->assign('callbackUrls', $callbackUrls);
$smarty->assign('totalUsers', $totalUsers);
$smarty->assign('totalSessions', $totalSessions);
$smarty->assign('recentLogins', $recentLogins);
$smarty->assign('providerCounts', $providerCounts);
$smarty->assign('providers', $this->GetProviders());

// Form
$smarty->assign('formstart', $this->CreateFormStart($id, 'defaultadmin', $returnid, 'post', '', false, '', [], 'class="oauth-admin-form"'));
$smarty->assign('formend', $this->CreateFormEnd());

echo $this->ProcessTemplate('admin_settings.tpl');
