<?php
/**
 * OAuth Module Uninstallation
 */
if (!isset($gCms)) exit;

$db = $this->GetDb();
$prefix = CMS_DB_PREFIX;

// Drop tables
$tables = [
    'module_oauth_sessions',
    'module_oauth_links',
    'module_oauth_users',
];

foreach ($tables as $table) {
    $db->Execute("DROP TABLE IF EXISTS {$prefix}{$table}");
}

// Remove permissions
$this->RemovePermission('Manage OAuth');

// Remove preferences
$providers = ['github', 'google', 'facebook', 'twitter', 'generic'];
foreach ($providers as $provider) {
    $this->RemovePreference('provider_' . $provider . '_enabled');
    $this->RemovePreference('provider_' . $provider . '_client_id');
    $this->RemovePreference('provider_' . $provider . '_client_secret');
    $this->RemovePreference('provider_' . $provider . '_scopes');
}

$this->RemovePreference('require_https');
$this->RemovePreference('default_redirect');
$this->RemovePreference('session_duration');

// Generic provider specific preferences
$this->RemovePreference('provider_generic_authorize_url');
$this->RemovePreference('provider_generic_token_url');
$this->RemovePreference('provider_generic_userinfo_url');

// Remove events
$this->RemoveEvent('OAuthUserLogin');
$this->RemoveEvent('OAuthUserLogout');
$this->RemoveEvent('OAuthUserCreated');
$this->RemoveEvent('OAuthProviderLinked');

// Remove template types
try {
    $types = ['login', 'profile'];
    foreach ($types as $type) {
        try {
            $type_obj = CmsLayoutTemplateType::load($this->GetName() . '::' . $type);
            if ($type_obj) {
                // Delete templates of this type
                $templates = CmsLayoutTemplate::template_query(['type' => $type_obj->get_id()]);
                foreach ($templates as $tpl) {
                    $tpl->delete();
                }
                $type_obj->delete();
            }
        } catch (Exception $e) {
            // Ignore errors
        }
    }
} catch (Exception $e) {
    audit('', $this->GetName(), 'Error removing template types: '.$e->getMessage());
}
