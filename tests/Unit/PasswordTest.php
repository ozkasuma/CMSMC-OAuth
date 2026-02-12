<?php
/**
 * Password validation and security tests - pure function tests
 */

namespace OAuth\Tests\Unit;

use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testPasswordHashingUsesBcrypt(): void
    {
        $password = 'MySecurePassword123!';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Should use bcrypt (starts with $2y$)
        $this->assertStringStartsWith('$2y$', $hash);
        $this->assertNotEquals($password, $hash);
        $this->assertTrue(strlen($hash) >= 60);
    }
    
    public function testPasswordVerification(): void
    {
        $password = 'TestPassword456!';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $this->assertTrue(password_verify($password, $hash));
        $this->assertFalse(password_verify('wrongpassword', $hash));
        $this->assertFalse(password_verify('', $hash));
    }
    
    public function testPasswordStrengthValidation(): void
    {
        // Too short (< 8 chars)
        $this->assertFalse($this->isStrongPassword('abc123'));
        
        // No numbers
        $this->assertFalse($this->isStrongPassword('abcdefgh'));
        
        // Valid passwords
        $this->assertTrue($this->isStrongPassword('SecurePass123'));
        $this->assertTrue($this->isStrongPassword('MyP@ssw0rd!'));
    }
    
    public function testEmptyPasswordNotAllowed(): void
    {
        $this->assertFalse($this->isStrongPassword(''));
        $this->assertFalse($this->isStrongPassword('   '));
    }
    
    public function testPasswordHashesAreDifferentWithSalt(): void
    {
        $password = 'SamePassword123';
        
        $hash1 = password_hash($password, PASSWORD_DEFAULT);
        $hash2 = password_hash($password, PASSWORD_DEFAULT);
        
        // Same password should produce different hashes (random salt)
        $this->assertNotEquals($hash1, $hash2);
        
        // But both should verify
        $this->assertTrue(password_verify($password, $hash1));
        $this->assertTrue(password_verify($password, $hash2));
    }
    
    /**
     * Simple password strength check
     */
    private function isStrongPassword(string $password): bool
    {
        $password = trim($password);
        if (strlen($password) < 8) return false;
        if (!preg_match('/[0-9]/', $password)) return false;
        if (!preg_match('/[a-zA-Z]/', $password)) return false;
        return true;
    }
}
