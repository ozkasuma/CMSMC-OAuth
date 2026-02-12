<?php
/**
 * Unit tests for OAuth module structure and configuration
 */

namespace OAuth\Tests\Unit;

use PHPUnit\Framework\TestCase;

class OAuthModuleTest extends TestCase
{
    private string $moduleDir;
    private string $moduleFile;
    
    protected function setUp(): void
    {
        $this->moduleDir = dirname(__DIR__, 2);
        $this->moduleFile = $this->moduleDir . '/OAuth.module.php';
    }
    
    public function testModuleFileExists(): void
    {
        $this->assertFileExists($this->moduleFile);
    }
    
    public function testModuleFileContainsClassDefinition(): void
    {
        $content = file_get_contents($this->moduleFile);
        $this->assertStringContainsString('class OAuth extends CMSModule', $content);
    }
    
    public function testModuleVersionIsDefined(): void
    {
        $content = file_get_contents($this->moduleFile);
        preg_match("/GetVersion\(\)\s*{\s*return\s*'([^']+)'/", $content, $matches);
        
        $this->assertNotEmpty($matches, 'GetVersion() should be defined');
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+$/', $matches[1]);
    }
    
    public function testModuleNameIsDefined(): void
    {
        $content = file_get_contents($this->moduleFile);
        preg_match("/GetName\(\)\s*{\s*return\s*'([^']+)'/", $content, $matches);
        
        $this->assertNotEmpty($matches, 'GetName() should be defined');
        $this->assertEquals('OAuth', $matches[1]);
    }
    
    public function testProviderConstantsAreDefined(): void
    {
        $content = file_get_contents($this->moduleFile);
        
        $this->assertStringContainsString("PROVIDER_GITHUB", $content);
        $this->assertStringContainsString("PROVIDER_GOOGLE", $content);
        $this->assertStringContainsString("PROVIDER_FACEBOOK", $content);
        $this->assertStringContainsString("PROVIDER_TWITTER", $content);
    }
    
    public function testHasAdmin(): void
    {
        $content = file_get_contents($this->moduleFile);
        $this->assertStringContainsString('HasAdmin()', $content);
    }
    
    public function testLangFileExists(): void
    {
        $this->assertFileExists($this->moduleDir . '/lang/en_US.php');
    }
    
    public function testLangFileHasRequiredKeys(): void
    {
        $lang = [];
        include $this->moduleDir . '/lang/en_US.php';
        
        $requiredKeys = ['friendlyname', 'admindescription'];
        foreach ($requiredKeys as $key) {
            $this->assertArrayHasKey($key, $lang, "Lang file missing key: $key");
        }
    }
    
    public function testRequiredTemplatesExist(): void
    {
        $templates = ['login.tpl', 'register.tpl', 'admin_settings.tpl'];
        
        foreach ($templates as $tpl) {
            $this->assertFileExists(
                $this->moduleDir . '/templates/' . $tpl,
                "Missing template: $tpl"
            );
        }
    }
    
    public function testInstallMethodExists(): void
    {
        $this->assertFileExists($this->moduleDir . '/method.install.php');
    }
    
    public function testUninstallMethodExists(): void
    {
        $this->assertFileExists($this->moduleDir . '/method.uninstall.php');
    }
    
    public function testActionFilesExist(): void
    {
        $actions = ['callback', 'login', 'logout', 'register'];
        
        foreach ($actions as $action) {
            $this->assertFileExists(
                $this->moduleDir . '/action.' . $action . '.php',
                "Missing action file: action.$action.php"
            );
        }
    }
    
    public function testProviderClassesExist(): void
    {
        $providers = ['GitHub', 'Google', 'Facebook', 'Twitter', 'Generic'];
        
        foreach ($providers as $provider) {
            $this->assertFileExists(
                $this->moduleDir . '/lib/class.' . $provider . 'Provider.php',
                "Missing provider class: $provider"
            );
        }
    }
}
