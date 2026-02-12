# OAuth Module Setup Guide

This guide explains how to configure OAuth providers for the CMSMS OAuth module.

## Table of Contents
1. [Installation](#installation)
2. [GitHub Setup](#github-setup)
3. [Google Setup](#google-setup)
4. [Facebook Setup](#facebook-setup)
5. [Twitter/X Setup](#twitterx-setup)
6. [Generic OAuth Setup](#generic-oauth-setup)
7. [Frontend Usage](#frontend-usage)
8. [Developer API](#developer-api)

## Installation

1. Install the OAuth module via Module Manager
2. Navigate to **Extensions → OAuth** in the admin panel
3. Configure your OAuth providers (see below)
4. Add OAuth login to your templates using Smarty tags

## GitHub Setup

GitHub OAuth is ideal for developer-focused sites.

### Create GitHub OAuth App

1. Go to [GitHub Developer Settings](https://github.com/settings/developers)
2. Click **New OAuth App**
3. Fill in the details:
   - **Application name**: Your site name
   - **Homepage URL**: Your website URL
   - **Authorization callback URL**: Copy from the OAuth admin panel
4. Click **Register application**
5. Copy the **Client ID**
6. Click **Generate a new client secret** and copy it

### Configure in CMSMS

1. Go to **Extensions → OAuth**
2. Enable GitHub provider
3. Paste your Client ID and Client Secret
4. Default scopes: `read:user,user:email`

## Google Setup

### Create Google OAuth Credentials

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create or select a project
3. Navigate to **APIs & Services → Credentials**
4. Click **Create Credentials → OAuth client ID**
5. Configure the consent screen if prompted
6. Select **Web application** as the application type
7. Add your callback URL to **Authorized redirect URIs**
8. Copy the Client ID and Client Secret

### Configure in CMSMS

1. Go to **Extensions → OAuth**
2. Enable Google provider
3. Paste your Client ID and Client Secret
4. Default scopes: `openid,email,profile`

## Facebook Setup

### Create Facebook App

1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Click **Create App**
3. Choose **Consumer** or **Business** type
4. Add **Facebook Login** product
5. Configure settings:
   - Add your callback URL to **Valid OAuth Redirect URIs**
6. Go to **Settings → Basic** for App ID and Secret

### Configure in CMSMS

1. Go to **Extensions → OAuth**
2. Enable Facebook provider
3. Enter App ID as Client ID
4. Enter App Secret as Client Secret
5. Default scopes: `email,public_profile`

## Twitter/X Setup

Twitter uses OAuth 2.0 with PKCE.

### Create Twitter App

1. Go to [Twitter Developer Portal](https://developer.twitter.com/en/portal/dashboard)
2. Create a project and app
3. Set up OAuth 2.0 settings:
   - **Type of App**: Web App
   - **Callback URLs**: Add your callback URL
4. Note the Client ID and Client Secret

### Configure in CMSMS

1. Go to **Extensions → OAuth**
2. Enable Twitter provider
3. Paste your Client ID and Client Secret
4. Default scopes: `tweet.read,users.read,offline.access`

> **Note**: Twitter API access may require approval and has rate limits.

## Generic OAuth Setup

For any OAuth 2.0 compatible provider.

### Required Information

You'll need these URLs from your provider:
- **Authorization URL**: Where users authorize your app
- **Token URL**: Where you exchange the code for tokens
- **User Info URL**: Where you fetch user profile data

### Configure in CMSMS

1. Go to **Extensions → OAuth**
2. Enable Generic OAuth provider
3. Enter your Client ID and Client Secret
4. Enter the three required URLs
5. Configure scopes as required by your provider

## Frontend Usage

### Smarty Tags

```smarty
{* Show login buttons for all enabled providers *}
{OAuth action="login"}

{* Login with a specific provider *}
{OAuth action="login" provider="github"}

{* Show user profile if logged in, login buttons if not *}
{OAuth action="profile"}

{* Logout the current user *}
{OAuth action="logout" return_url="/"}
```

### Template Customization

1. Go to **Design → Templates**
2. Look for templates of type **OAuth**
3. Customize the Login or Profile templates

## Developer API

### Check if User is Logged In

```php
$oauth = cms_utils::get_module('OAuth');
$user = $oauth->GetCurrentUser();

if ($user) {
    echo "Welcome, " . $user['name'];
    echo "Email: " . $user['email'];
    echo "Avatar: " . $user['avatar_url'];
    
    // Check specific provider
    if (isset($user['github_id'])) {
        echo "GitHub ID: " . $user['github_id'];
    }
} else {
    echo "Not logged in";
}
```

### User Data Structure

```php
$user = [
    'user_id' => 123,
    'email' => 'user@example.com',
    'name' => 'John Doe',
    'avatar_url' => 'https://...',
    'created_at' => '2024-01-15 10:30:00',
    'last_login' => '2024-02-01 14:22:00',
    'providers' => [
        'github' => [
            'id' => '12345',
            'profile' => [...], // Full provider profile data
        ],
    ],
    'github_id' => '12345', // Convenience accessor
];
```

### Events

The module fires these events:

- **OAuthUserLogin**: When a user logs in
- **OAuthUserLogout**: When a user logs out
- **OAuthUserCreated**: When a new user is created
- **OAuthProviderLinked**: When a new provider is linked to an existing user

### Event Handler Example

```php
// In a custom module
public function HandlerOAuthUserLogin($params) {
    $user = $params['user'];
    $provider = $params['provider'];
    
    // Do something with the login event
    audit('', 'MyModule', 'User logged in: ' . $user['email']);
}
```

## Security Considerations

1. **Always use HTTPS** in production
2. **Never commit credentials** to version control
3. **Rotate secrets periodically**
4. **Use minimal scopes** - only request what you need
5. **Validate callback URLs** - providers should only redirect to your site

## Troubleshooting

### "Invalid state" Error
- State tokens expire after 10 minutes
- Make sure session cookies are enabled
- Clear browser cookies and try again

### "Provider not configured" Error
- Check that the provider is enabled in admin
- Verify Client ID and Secret are correct
- Ensure callback URL matches exactly

### User Not Receiving Email
- Some providers don't share email by default
- Check that appropriate scopes are requested
- User may have privacy settings blocking email

## Support

For issues and feature requests, please visit:
- [CMSMS Forums](https://forum.cmsmadesimple.org/)
- [GitHub Issues](https://github.com/cmsmadesimple/cmsms-oauth)
