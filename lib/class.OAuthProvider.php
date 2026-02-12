<?php
/**
 * Base OAuth Provider Class
 * 
 * Abstract class that all OAuth providers must extend.
 */

abstract class OAuthProvider
{
    protected $clientId;
    protected $clientSecret;
    protected $scopes = [];
    protected $redirectUri;
    
    /**
     * Constructor
     * 
     * @param string $clientId     OAuth Client ID
     * @param string $clientSecret OAuth Client Secret
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }
    
    /**
     * Get the provider name
     * 
     * @return string
     */
    abstract public function getName();
    
    /**
     * Get the display name for the provider
     * 
     * @return string
     */
    abstract public function getDisplayName();
    
    /**
     * Get the authorization URL
     * 
     * @return string
     */
    abstract public function getAuthorizeUrl();
    
    /**
     * Get the token endpoint URL
     * 
     * @return string
     */
    abstract public function getTokenUrl();
    
    /**
     * Get the user info endpoint URL
     * 
     * @return string
     */
    abstract public function getUserInfoUrl();
    
    /**
     * Get default scopes for this provider
     * 
     * @return array
     */
    abstract public function getDefaultScopes();
    
    /**
     * Parse the user info response
     * 
     * @param array $data Raw user data from provider
     * @return array Normalized user data with 'id', 'email', 'name', 'avatar_url'
     */
    abstract public function parseUserInfo($data);
    
    /**
     * Set custom scopes
     * 
     * @param array $scopes
     * @return self
     */
    public function setScopes(array $scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }
    
    /**
     * Get scopes (custom or default)
     * 
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes ?: $this->getDefaultScopes();
    }
    
    /**
     * Set the redirect URI
     * 
     * @param string $uri
     * @return self
     */
    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
        return $this;
    }
    
    /**
     * Get the redirect URI
     * 
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }
    
    /**
     * Get the scope separator used by this provider
     * 
     * @return string
     */
    public function getScopeSeparator()
    {
        return ' ';
    }
    
    /**
     * Build the authorization URL with all parameters
     * 
     * @param string $state CSRF state token
     * @return string Full authorization URL
     */
    public function buildAuthorizationUrl($state)
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'response_type' => 'code',
            'scope' => implode($this->getScopeSeparator(), $this->getScopes()),
            'state' => $state,
        ];
        
        $params = array_merge($params, $this->getAdditionalAuthParams());
        
        return $this->getAuthorizeUrl() . '?' . http_build_query($params);
    }
    
    /**
     * Get additional authorization parameters
     * Override in subclass if needed
     * 
     * @return array
     */
    protected function getAdditionalAuthParams()
    {
        return [];
    }
    
    /**
     * Exchange authorization code for access token
     * 
     * @param string $code Authorization code from callback
     * @return array Token data including 'access_token', optionally 'refresh_token', 'expires_in'
     * @throws Exception on error
     */
    public function exchangeCodeForToken($code)
    {
        $params = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code',
        ];
        
        $response = $this->httpPost($this->getTokenUrl(), $params);
        
        if (isset($response['error'])) {
            throw new Exception($response['error_description'] ?? $response['error']);
        }
        
        if (!isset($response['access_token'])) {
            throw new Exception('No access token in response');
        }
        
        return $response;
    }
    
    /**
     * Fetch user info from the provider
     * 
     * @param string $accessToken
     * @return array Normalized user data
     * @throws Exception on error
     */
    public function fetchUserInfo($accessToken)
    {
        $data = $this->httpGet($this->getUserInfoUrl(), $accessToken);
        return $this->parseUserInfo($data);
    }
    
    /**
     * Make an HTTP GET request with Authorization header
     * 
     * @param string $url
     * @param string $accessToken
     * @return array Decoded JSON response
     * @throws Exception on error
     */
    protected function httpGet($url, $accessToken)
    {
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $accessToken,
                'Accept: application/json',
                'User-Agent: CMSMS-OAuth/1.0',
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception('HTTP request failed: ' . $error);
        }
        
        if ($httpCode >= 400) {
            throw new Exception('HTTP error ' . $httpCode . ': ' . $response);
        }
        
        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response');
        }
        
        return $data;
    }
    
    /**
     * Make an HTTP POST request
     * 
     * @param string $url
     * @param array $params POST parameters
     * @return array Decoded JSON response
     * @throws Exception on error
     */
    protected function httpPost($url, array $params)
    {
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded',
                'User-Agent: CMSMS-OAuth/1.0',
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception('HTTP request failed: ' . $error);
        }
        
        // Try JSON first
        $data = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }
        
        // Fallback to query string (some providers return this)
        parse_str($response, $data);
        if (!empty($data)) {
            return $data;
        }
        
        throw new Exception('Invalid response format');
    }
    
    /**
     * Get the icon/logo class for this provider
     * 
     * @return string CSS class or SVG icon
     */
    public function getIcon()
    {
        return 'oauth-icon-' . $this->getName();
    }
    
    /**
     * Get the button color for this provider
     * 
     * @return string Hex color code
     */
    public function getButtonColor()
    {
        return '#333333';
    }
}
