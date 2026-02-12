<?php
/**
 * Email validation tests - pure function tests
 */

namespace OAuth\Tests\Unit;

use PHPUnit\Framework\TestCase;

class EmailValidationTest extends TestCase
{
    public function testValidEmails(): void
    {
        $validEmails = [
            'test@example.com',
            'user.name@domain.org',
            'first+last@subdomain.example.co.uk',
            'user123@test-domain.com',
        ];
        
        foreach ($validEmails as $email) {
            $this->assertTrue(
                $this->isValidEmail($email),
                "Should accept valid email: $email"
            );
        }
    }
    
    public function testInvalidEmails(): void
    {
        $invalidEmails = [
            '',
            'notanemail',
            '@nodomain.com',
            'no@domain',
            'spaces in@email.com',
            'missing@.com',
        ];
        
        foreach ($invalidEmails as $email) {
            $this->assertFalse(
                $this->isValidEmail($email),
                "Should reject invalid email: $email"
            );
        }
    }
    
    public function testEmailNormalization(): void
    {
        // Emails should be lowercased
        $this->assertEquals(
            'test@example.com',
            $this->normalizeEmail('TEST@EXAMPLE.COM')
        );
        
        // Whitespace should be trimmed
        $this->assertEquals(
            'test@example.com',
            $this->normalizeEmail('  test@example.com  ')
        );
    }
    
    public function testMagicLinkTokenGeneration(): void
    {
        $token = $this->generateSecureToken();
        
        // Token should be sufficiently random and long
        $this->assertIsString($token);
        $this->assertGreaterThanOrEqual(32, strlen($token));
    }
    
    public function testMagicLinkTokensAreUnique(): void
    {
        $tokens = [];
        for ($i = 0; $i < 100; $i++) {
            $tokens[] = $this->generateSecureToken();
        }
        
        // All tokens should be unique
        $this->assertCount(100, array_unique($tokens));
    }
    
    /**
     * Validate email format
     */
    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Normalize email to lowercase and trimmed
     */
    private function normalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }
    
    /**
     * Generate a secure random token for magic links
     */
    private function generateSecureToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }
}
