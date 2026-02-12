<?php
/**
 * Generic OAuth 2.0 Provider
 * 
 * Configurable OAuth 2.0 provider for custom authentication endpoints.
 */

class GenericProvider extends OAuthProvider
{
    protected $config;
    
    /**
     * Constructor
     * 
     * @param string $clientId     OAuth Client ID
     * @param string $clientSecret OAuth Client Secret
     * @param array  $config       Provider configuration:
     *                             - authorize_url: Authorization endpoint
     *                             - token_url: Token endpoint
     *                             - userinfo_url: User info endpoint
     *                             - name: Provider display name (optional)
     *                             - scopes: Default scopes (optional)
     */
    public function __construct($clientId, $clientSecret, array $config = [])
    {
        parent::__construct($clientId, $clientSecret);
        
        $this->config = array_merge([
            'authorize_url' => '',
            'token_url' => '',
            'userinfo_url' => '',
            'name' => 'OAuth Provider',
            'scopes' => ['openid', 'email', 'profile'],
            'scope_separator' => ' ',
            'id_field' => 'sub',
            'email_field' => 'email',
            'name_field' => 'name',
            'avatar_field' => 'picture',
        ], $config);
    }
    
    public function getName()
    {
        return 'generic';
    }
    
    public function getDisplayName()
    {
        return $this->config['name'];
    }
    
    public function getAuthorizeUrl()
    {
        return $this->config['authorize_url'];
    }
    
    public function getTokenUrl()
    {
        return $this->config['token_url'];
    }
    
    public function getUserInfoUrl()
    {
        return $this->config['userinfo_url'];
    }
    
    public function getDefaultScopes()
    {
        $scopes = $this->config['scopes'];
        if (is_string($scopes)) {
            $scopes = explode(',', $scopes);
        }
        return array_map('trim', $scopes);
    }
    
    public function getScopeSeparator()
    {
        return $this->config['scope_separator'];
    }
    
    /**
     * Get a value from nested array using dot notation
     */
    protected function getNestedValue($data, $key)
    {
        $keys = explode('.', $key);
        $value = $data;
        
        foreach ($keys as $k) {
            if (!is_array($value) || !isset($value[$k])) {
                return null;
            }
            $value = $value[$k];
        }
        
        return $value;
    }
    
    public function parseUserInfo($data)
    {
        return [
            'id' => (string)($this->getNestedValue($data, $this->config['id_field']) ?? 
                   $data['id'] ?? 
                   $data['sub'] ?? 
                   uniqid('generic_')),
            'email' => $this->getNestedValue($data, $this->config['email_field']) ?? 
                      $data['email'] ?? null,
            'name' => $this->getNestedValue($data, $this->config['name_field']) ?? 
                     $data['name'] ?? 
                     $data['preferred_username'] ?? 
                     'User',
            'avatar_url' => $this->getNestedValue($data, $this->config['avatar_field']) ?? 
                           $data['picture'] ?? 
                           $data['avatar'] ?? null,
            'raw_data' => $data, // Store full response for custom processing
        ];
    }
    
    public function getIcon()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>';
    }
    
    public function getButtonColor()
    {
        return '#6366f1';
    }
}
