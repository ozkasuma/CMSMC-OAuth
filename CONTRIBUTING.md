# Contributing to OAuth

Thanks for your interest in contributing! This guide will help you set up your development environment.

## Development Environment

### Option 1: DDEV (Recommended for local development)

[DDEV](https://ddev.com) provides a containerized PHP environment — no need to install PHP locally.

```bash
# Install DDEV (macOS)
brew install ddev/ddev/ddev

# Install DDEV (Linux)
curl -fsSL https://ddev.com/install.sh | bash

# Clone and start
git clone https://github.com/cmsms-hub/oauth.git
cd oauth
ddev start
ddev composer install

# Run tests
ddev exec vendor/bin/phpunit --testsuite Unit
```

### Option 2: Local PHP

If you have PHP 8.0+ installed locally:

```bash
git clone https://github.com/cmsms-hub/oauth.git
cd oauth
composer install
vendor/bin/phpunit --testsuite Unit
```

### Option 3: GitHub Codespaces

Click the "Code" button on GitHub and select "Open with Codespaces" for a cloud dev environment.

## Make Commands

```bash
make help          # Show all available commands
make start         # Start DDEV environment
make stop          # Stop DDEV environment
make install       # Install composer dependencies
make test          # Run PHPUnit tests
make test-coverage # Run tests with coverage report
make build         # Build distribution package (.xml.gz)
make clean         # Remove build artifacts
make lint          # Check PHP syntax
```

## Project Structure

```
oauth/
├── OAuth.module.php       # Main module class
├── action.*.php           # Frontend/admin actions
│   ├── action.callback.php    # OAuth callback handler
│   ├── action.login.php       # Login action
│   ├── action.logout.php      # Logout action
│   ├── action.register.php    # Registration action
│   └── action.defaultadmin.php
├── method.install.php     # Installation logic
├── method.uninstall.php   # Uninstallation logic
├── templates/             # Smarty templates
│   ├── login.tpl
│   ├── register.tpl
│   ├── admin_settings.tpl
│   └── admin_users.tpl
├── lang/                  # Language files
│   └── en_US.php
├── lib/                   # Provider classes
│   ├── class.OAuthProvider.php    # Base class
│   ├── class.GitHubProvider.php
│   ├── class.GoogleProvider.php
│   ├── class.FacebookProvider.php
│   ├── class.TwitterProvider.php
│   └── class.GenericProvider.php
├── tests/                 # PHPUnit tests
│   ├── Unit/
│   ├── Integration/
│   ├── Mocks/
│   └── bootstrap.php
├── build.sh               # Build script
├── dist/                  # Built packages (gitignored)
└── .github/workflows/     # CI/CD pipelines
```

## Testing

### Running Tests

```bash
# Run all unit tests
make test

# Run specific test file
ddev exec vendor/bin/phpunit tests/Unit/PasswordTest.php

# Run with verbose output
ddev exec vendor/bin/phpunit --testdox
```

### Test Categories

- **OAuthModuleTest** - Module structure and configuration
- **PasswordTest** - Password hashing and validation
- **EmailValidationTest** - Email format and normalization

### Writing Tests

```php
<?php
namespace OAuth\Tests\Unit;

use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }
}
```

## Building Packages

```bash
# Build creates dist/OAuth-x.x.x.xml.gz
make build

# Or directly
./build.sh
```

The version is extracted from `GetVersion()` in `OAuth.module.php`.

## Releasing

Releases are automated via GitHub Actions:

1. Update version in `OAuth.module.php`:
   ```php
   public function GetVersion() { return '1.1.0'; }
   ```

2. Commit the change:
   ```bash
   git add OAuth.module.php
   git commit -m "Bump version to 1.1.0"
   ```

3. Create and push a tag:
   ```bash
   git tag v1.1.0
   git push origin main --tags
   ```

4. GitHub Actions will:
   - Run tests on PHP 8.0, 8.1, 8.2, 8.3
   - Build the package
   - Create a GitHub Release with the `.xml.gz` artifact

## Adding a New OAuth Provider

1. Create `lib/class.NewProvider.php`:
   ```php
   <?php
   class NewProvider extends OAuthProvider
   {
       protected function getAuthorizationUrl(): string { }
       protected function getTokenUrl(): string { }
       protected function getUserInfoUrl(): string { }
       protected function parseUserInfo(array $data): array { }
   }
   ```

2. Register in `OAuth.module.php`

3. Add language strings in `lang/en_US.php`

4. Write tests in `tests/Unit/`

## Security Considerations

- Never commit OAuth credentials
- Use `password_hash()` with `PASSWORD_DEFAULT`
- Validate all user input
- Use prepared statements for database queries
- Implement CSRF protection

## Pull Request Process

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/my-feature`)
3. Write tests for new functionality
4. Ensure all tests pass (`make test`)
5. Commit with clear messages
6. Push and create a Pull Request

## Questions?

Open an issue on GitHub or reach out to the maintainers.
