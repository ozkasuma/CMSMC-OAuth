<?php
/**
 * OAuth - Password Login Action
 * Handle email + password login
 */
if (!isset($gCms)) exit;

$db = $this->GetDb();
$prefix = CMS_DB_PREFIX;
$errors = [];

// Handle form submission
if (isset($params['submit_login'])) {
    $email = trim($params['email'] ?? '');
    $password = $params['password'] ?? '';
    
    // Validation
    if (empty($email)) {
        $errors[] = $this->Lang('error_email_required');
    }
    
    if (empty($password)) {
        $errors[] = $this->Lang('error_password_required');
    }
    
    // Verify credentials
    if (empty($errors)) {
        $user = $db->GetRow(
            "SELECT user_id, email, password_hash, name, avatar_url FROM {$prefix}module_oauth_users WHERE email = ?",
            [$email]
        );
        
        if (!$user || empty($user['password_hash'])) {
            $errors[] = $this->Lang('error_invalid_credentials');
        } elseif (!password_verify($password, $user['password_hash'])) {
            $errors[] = $this->Lang('error_invalid_credentials');
        } else {
            // Update last login
            $db->Execute(
                "UPDATE {$prefix}module_oauth_users SET last_login = ? WHERE user_id = ?",
                [date('Y-m-d H:i:s'), $user['user_id']]
            );
            
            // Set session
            $this->SetSession('oauth_user_id', $user['user_id']);
            $this->SetSession('oauth_user_email', $user['email']);
            $this->SetSession('oauth_user_name', $user['name']);
            $this->SetSession('oauth_user_avatar', $user['avatar_url']);
            
            // Send event
            $this->SendOAuthEvent('OAuthUserLogin', [
                'user_id' => $user['user_id'],
                'email' => $user['email'],
                'provider' => 'password'
            ]);
            
            // Redirect
            $return_url = $params['return_url'] ?? $this->GetPreference('default_redirect', '/');
            redirect($return_url);
            return;
        }
    }
}

// Form
$smarty->assign('errors', $errors);
$smarty->assign('email', $params['email'] ?? '');
$smarty->assign('return_url', $params['return_url'] ?? '');
$smarty->assign('actionid', $id);
$smarty->assign('returnid', $returnid);

// Form start/end
$smarty->assign('formstart', $this->CreateFormStart($id, 'password_login', $returnid));
$smarty->assign('formend', $this->CreateFormEnd());

// Register URL
$smarty->assign('register_url', $this->create_url($id, 'register', $returnid));

echo $this->ProcessOAuthTemplate('password_login');
