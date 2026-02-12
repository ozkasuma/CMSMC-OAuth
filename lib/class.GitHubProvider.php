<?php
/**
 * GitHub OAuth Provider
 * 
 * OAuth 2.0 implementation for GitHub authentication.
 * https://docs.github.com/en/apps/oauth-apps/building-oauth-apps/authorizing-oauth-apps
 */

class GitHubProvider extends OAuthProvider
{
    public function getName()
    {
        return 'github';
    }
    
    public function getDisplayName()
    {
        return 'GitHub';
    }
    
    public function getAuthorizeUrl()
    {
        return 'https://github.com/login/oauth/authorize';
    }
    
    public function getTokenUrl()
    {
        return 'https://github.com/login/oauth/access_token';
    }
    
    public function getUserInfoUrl()
    {
        return 'https://api.github.com/user';
    }
    
    public function getDefaultScopes()
    {
        return ['read:user', 'user:email'];
    }
    
    public function getScopeSeparator()
    {
        return ' ';
    }
    
    public function parseUserInfo($data)
    {
        return [
            'id' => (string)$data['id'],
            'login' => $data['login'] ?? null,
            'email' => $data['email'] ?? null,
            'name' => $data['name'] ?? $data['login'] ?? 'GitHub User',
            'avatar_url' => $data['avatar_url'] ?? null,
            'profile_url' => $data['html_url'] ?? null,
            'company' => $data['company'] ?? null,
            'location' => $data['location'] ?? null,
            'bio' => $data['bio'] ?? null,
            'public_repos' => $data['public_repos'] ?? 0,
            'followers' => $data['followers'] ?? 0,
            'following' => $data['following'] ?? 0,
            'created_at' => $data['created_at'] ?? null,
        ];
    }
    
    /**
     * Fetch user info with additional email call if needed
     * 
     * @param string $accessToken
     * @return array Normalized user data
     * @throws Exception on error
     */
    public function fetchUserInfo($accessToken)
    {
        $data = $this->httpGet($this->getUserInfoUrl(), $accessToken);
        $userInfo = $this->parseUserInfo($data);
        
        // If email is not public, try to get it from emails endpoint
        if (empty($userInfo['email'])) {
            try {
                $emails = $this->httpGet('https://api.github.com/user/emails', $accessToken);
                foreach ($emails as $email) {
                    if ($email['primary'] && $email['verified']) {
                        $userInfo['email'] = $email['email'];
                        break;
                    }
                }
            } catch (Exception $e) {
                // Ignore email fetch errors
            }
        }
        
        return $userInfo;
    }
    
    public function getIcon()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>';
    }
    
    public function getButtonColor()
    {
        return '#24292e';
    }
}
