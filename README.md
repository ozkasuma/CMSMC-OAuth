# OAuth for CMS Made Simple

**Modern social authentication for CMSMS websites.**

Add GitHub, Google, Facebook, and Twitter login to your CMS Made Simple site with a few clicks. No complex configuration — just paste your OAuth credentials and go.

## Features

- 🔐 **Social Login** — GitHub, Google, Facebook, Twitter/X
- 📧 **Email + Password** — Traditional registration as fallback
- ✨ **Magic Links** — Passwordless email sign-in
- 🔗 **Account Linking** — Connect multiple providers to one account
- 👥 **User Management** — Admin panel with search, pagination, delete
- 🛡️ **Secure** — CSRF protection, password hashing, HTTPS support
- 🧩 **Developer API** — Easy integration with other modules

## Installation

### Via ModuleManager
1. Download `OAuth-x.x.x.xml.gz` from [Releases](../../releases)
2. Extensions → Module Manager → Upload Module
3. Install

### Manual
1. Extract to `modules/OAuth/`
2. Extensions → Module Manager → Install

## Configuration

1. Create OAuth apps at your providers:
   - [GitHub](https://github.com/settings/developers) → OAuth Apps → New
   - [Google](https://console.cloud.google.com/apis/credentials) → Create OAuth Client
   - [Facebook](https://developers.facebook.com/apps/) → Create App
   - [Twitter](https://developer.twitter.com/en/portal/projects) → Create Project

2. Go to **Users & Groups → OAuth** in CMSMS admin

3. Enter Client ID & Secret for each provider

4. Set the callback URL in your OAuth app:
   ```
   https://yoursite.com/index.php?mact=OAuth,m1_,callback,0&m1_provider=PROVIDER
   ```
   Replace `PROVIDER` with: `github`, `google`, `facebook`, or `twitter`

## Usage

### Smarty Tags

```smarty
{* Show login buttons for all enabled providers *}
{OAuth action="login"}

{* Login with specific provider *}
{OAuth action="login" provider="github"}

{* Show user profile (or login if not authenticated) *}
{OAuth action="profile"}

{* Logout link *}
{OAuth action="logout"}

{* Registration form *}
{OAuth action="register"}

{* Email + password login *}
{OAuth action="password_login"}
```

### PHP API

```php
// Get the module
$oauth = cms_utils::get_module('OAuth');

// Get current logged-in user
$user = $oauth->GetCurrentUser();
if ($user) {
    echo "Hello, " . $user['name'];
    echo "Email: " . $user['email'];
    
    // Check connected providers
    if (isset($user['github_id'])) {
        echo "GitHub connected!";
    }
}

// Verify password (for other modules)
$user = $oauth->VerifyPassword($email, $password);
if ($user) {
    // Valid credentials
}

// Check if provider is enabled
$enabled = $oauth->GetPreference('provider_github_enabled');
```

### Events

The module fires these events that other modules can listen to:

- `OAuthUserLogin` — User logged in
- `OAuthUserLogout` — User logged out
- `OAuthUserCreated` — New user registered
- `OAuthProviderLinked` — Provider linked to account

## Database Tables

- `cms_module_oauth_users` — User accounts
- `cms_module_oauth_links` — Provider connections
- `cms_module_oauth_sessions` — Active sessions

## Requirements

- CMS Made Simple 2.2+
- PHP 8.0+
- HTTPS recommended for production

## License

GPL-3.0 — Compatible with CMS Made Simple

## Credits

Built for [CMSMS Hub](https://github.com/ozkasuma) by the community.
