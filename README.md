# OAuth — Social Authentication for CMSMS

Add social login to CMS Made Simple. Works great with [Forge](https://github.com/cmsms/cmsms-forge).

## Providers

- 🐙 **GitHub** — OAuth 2.0
- 🔵 **Google** — OAuth 2.0  
- 📘 **Facebook** — OAuth 2.0
- 🐦 **Twitter/X** — OAuth 2.0 with PKCE
- ⚙️ **Generic** — Any OAuth 2.0 provider

## Features

- 🔗 **Account Linking** — Connect multiple providers
- 🍪 **Secure Sessions** — Cookie-based auth
- 🛡️ **CSRF Protection** — State parameter validation
- 📊 **Admin Panel** — Manage providers & view users
- 🔌 **Developer API** — Easy integration with other modules

## Requirements

- CMS Made Simple 2.2+
- PHP 8.0+
- HTTPS recommended

## Installation

### Via ModuleManager
1. Download `OAuth-x.x.x.xml.gz` from [Releases](../../releases)
2. Extensions → Module Manager → Upload Module
3. Install

### Manual
1. Extract to `modules/OAuth/`
2. Extensions → Module Manager → Install

## Configuration

1. Create OAuth apps at each provider (GitHub, Google, etc.)
2. Extensions → OAuth → Settings
3. Enter Client ID & Secret for each provider
4. Set callback URL: `https://yoursite.com/index.php?mact=OAuth,cntnt01,callback,0`

## Usage

### Smarty Tags
```smarty
{OAuth action="login"}                    {* All login buttons *}
{OAuth action="login" provider="github"}  {* GitHub only *}
{OAuth action="profile"}                  {* User profile *}
{OAuth action="logout"}                   {* Logout link *}
```

### PHP API
```php
$oauth = cms_utils::get_module('OAuth');
$user = $oauth->GetCurrentUser();
if ($user) {
    echo "Hello, " . $user['name'];
}
```

## License

GPL-3.0
