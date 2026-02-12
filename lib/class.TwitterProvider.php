<?php
/**
 * Twitter/X OAuth Provider
 * 
 * OAuth 2.0 implementation for Twitter/X authentication.
 * https://developer.twitter.com/en/docs/authentication/oauth-2-0/authorization-code
 */

class TwitterProvider extends OAuthProvider
{
    protected $codeVerifier;
    
    public function getName()
    {
        return 'twitter';
    }
    
    public function getDisplayName()
    {
        return 'Twitter / X';
    }
    
    public function getAuthorizeUrl()
    {
        return 'https://twitter.com/i/oauth2/authorize';
    }
    
    public function getTokenUrl()
    {
        return 'https://api.twitter.com/2/oauth2/token';
    }
    
    public function getUserInfoUrl()
    {
        return 'https://api.twitter.com/2/users/me?user.fields=id,name,username,profile_image_url,description';
    }
    
    public function getDefaultScopes()
    {
        return ['tweet.read', 'users.read', 'offline.access'];
    }
    
    public function getScopeSeparator()
    {
        return ' ';
    }
    
    /**
     * Generate code verifier for PKCE
     */
    protected function generateCodeVerifier()
    {
        $this->codeVerifier = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        return $this->codeVerifier;
    }
    
    /**
     * Generate code challenge from verifier
     */
    protected function generateCodeChallenge($verifier)
    {
        return rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');
    }
    
    protected function getAdditionalAuthParams()
    {
        // Twitter requires PKCE
        $verifier = $this->generateCodeVerifier();
        $_SESSION['twitter_code_verifier'] = $verifier;
        
        return [
            'code_challenge' => $this->generateCodeChallenge($verifier),
            'code_challenge_method' => 'S256',
        ];
    }
    
    /**
     * Exchange code for token with PKCE
     */
    public function exchangeCodeForToken($code)
    {
        $codeVerifier = $_SESSION['twitter_code_verifier'] ?? null;
        unset($_SESSION['twitter_code_verifier']);
        
        if (!$codeVerifier) {
            throw new Exception('Missing code verifier for PKCE');
        }
        
        $params = [
            'client_id' => $this->clientId,
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
            'code_verifier' => $codeVerifier,
        ];
        
        // Twitter requires Basic auth for token exchange
        $ch = curl_init($this->getTokenUrl());
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
                'User-Agent: CMSMS-OAuth/1.0',
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception('HTTP request failed: ' . $error);
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response');
        }
        
        if (isset($data['error'])) {
            throw new Exception($data['error_description'] ?? $data['error']);
        }
        
        return $data;
    }
    
    public function parseUserInfo($data)
    {
        $userData = $data['data'] ?? $data;
        
        return [
            'id' => (string)$userData['id'],
            'username' => $userData['username'] ?? null,
            'name' => $userData['name'] ?? $userData['username'] ?? 'Twitter User',
            'avatar_url' => $userData['profile_image_url'] ?? null,
            'description' => $userData['description'] ?? null,
            // Twitter doesn't provide email through API v2 without special permissions
            'email' => null,
        ];
    }
    
    public function getIcon()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>';
    }
    
    public function getButtonColor()
    {
        return '#000000';
    }
}
