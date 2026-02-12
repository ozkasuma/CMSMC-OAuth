<?php
/**
 * OAuth Module - English Language File
 */

// Module info
$lang['friendlyname'] = 'OAuth Authentication';
$lang['admindescription'] = 'Manage OAuth authentication providers and user accounts';
$lang['help'] = '<h3>OAuth Authentication Module</h3>
<p>This module enables visitor authentication via OAuth providers (GitHub, Google, Facebook, Twitter, etc.).</p>
<h4>Frontend Usage</h4>
<pre>
{OAuth}                              - Show login buttons or profile
{OAuth action="login"}               - Show login buttons for all providers
{OAuth action="login" provider="github"} - Login with specific provider
{OAuth action="profile"}             - Show user profile
{OAuth action="logout"}              - Logout user
</pre>
<h4>PHP API</h4>
<pre>
$oauth = cms_utils::get_module(\'OAuth\');
$user = $oauth->GetCurrentUser();
if ($user) {
    echo $user[\'name\'];
    echo $user[\'email\'];
}
</pre>';

// Providers
$lang['provider_github'] = 'GitHub';
$lang['provider_google'] = 'Google';
$lang['provider_facebook'] = 'Facebook';
$lang['provider_twitter'] = 'Twitter / X';
$lang['provider_generic'] = 'Generic OAuth';

// Admin
$lang['admin_title'] = 'OAuth Settings';
$lang['general_settings'] = 'General Settings';
$lang['provider_settings'] = 'Provider Configuration';
$lang['require_https'] = 'Require HTTPS for callbacks';
$lang['require_https_hint'] = 'Recommended for security. OAuth callbacks should always use HTTPS in production.';
$lang['default_redirect'] = 'Default redirect URL';
$lang['default_redirect_hint'] = 'Where to redirect users after login if no return URL is specified.';
$lang['enable_provider'] = 'Enable this provider';
$lang['client_id'] = 'Client ID';
$lang['client_secret'] = 'Client Secret';
$lang['scopes'] = 'Scopes';
$lang['callback_url'] = 'Callback URL';
$lang['callback_url_hint'] = 'Add this URL to your OAuth app\'s authorized redirect URIs.';
$lang['authorize_url'] = 'Authorization URL';
$lang['token_url'] = 'Token URL';
$lang['userinfo_url'] = 'User Info URL';
$lang['generic_oauth'] = 'Generic OAuth 2.0';
$lang['enabled'] = 'Enabled';
$lang['disabled'] = 'Disabled';
$lang['save_settings'] = 'Save Settings';
$lang['settings_saved'] = 'Settings saved successfully';

// Statistics
$lang['total_users'] = 'Total Users';
$lang['active_sessions'] = 'Active Sessions';
$lang['users'] = 'users';
$lang['recent_logins'] = 'Recent Logins';
$lang['user'] = 'User';
$lang['email'] = 'Email';
$lang['provider'] = 'Provider';
$lang['last_login'] = 'Last Login';

// Frontend - Login
$lang['login_title'] = 'Sign In';
$lang['login_description'] = 'Choose a provider to sign in with your account.';
$lang['login_with'] = 'Continue with %s';
$lang['already_logged_in'] = 'You are already signed in as';
$lang['login_success'] = 'Successfully signed in with %s';

// Frontend - Profile
$lang['connected_accounts'] = 'Connected Accounts';
$lang['account_info'] = 'Account Information';
$lang['member_since'] = 'Member since';
$lang['logout'] = 'Sign Out';
$lang['logout_success'] = 'You have been signed out';
$lang['not_logged_in'] = 'Not Signed In';
$lang['not_logged_in_desc'] = 'Sign in to access your account.';

// Errors
$lang['error_permission_denied'] = 'You do not have permission to access this area.';
$lang['error_no_providers'] = 'No OAuth providers are currently configured.';
$lang['error_provider_not_configured'] = 'The provider "%s" is not configured or enabled.';
$lang['error_https_required'] = 'HTTPS is required for OAuth authentication.';
$lang['error_invalid_callback'] = 'Invalid OAuth callback request.';
$lang['error_invalid_state'] = 'Invalid or expired state token. Please try again.';
$lang['error_authentication_failed'] = 'Authentication failed';
$lang['error_oauth_access_denied'] = 'Access was denied by the provider.';
$lang['error_oauth_invalid_request'] = 'Invalid request to the OAuth provider.';
$lang['error_oauth_invalid_scope'] = 'Invalid scope requested.';
$lang['error_oauth_server_error'] = 'The OAuth provider encountered an error.';
$lang['error_oauth_temporarily_unavailable'] = 'The OAuth provider is temporarily unavailable.';

// Parameter help
$lang['help_provider'] = 'OAuth provider to use (github, google, facebook, twitter, generic)';
$lang['help_action'] = 'Action to perform (login, logout, profile)';

// Template types
$lang['tpltype_login'] = 'OAuth Login Template';
$lang['tpltype_profile'] = 'OAuth Profile Template';
$lang['tpltype_register'] = 'Registration Template';
$lang['tpltype_password_login'] = 'Password Login Template';

// Registration
$lang['register_title'] = 'Create Account';
$lang['field_name'] = 'Name';
$lang['field_email'] = 'Email';
$lang['field_password'] = 'Password';
$lang['field_password_confirm'] = 'Confirm Password';
$lang['btn_register'] = 'Create Account';
$lang['btn_login'] = 'Sign In';
$lang['already_have_account'] = 'Already have an account?';
$lang['no_account'] = "Don't have an account?";

// Registration errors
$lang['error_email_required'] = 'Email address is required.';
$lang['error_email_invalid'] = 'Please enter a valid email address.';
$lang['error_email_exists'] = 'An account with this email already exists.';
$lang['error_password_required'] = 'Password is required.';
$lang['error_password_too_short'] = 'Password must be at least 8 characters.';
$lang['error_passwords_dont_match'] = 'Passwords do not match.';
$lang['error_invalid_credentials'] = 'Invalid email or password.';
