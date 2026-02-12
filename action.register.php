<?php
/**
 * OAuth - Register Action
 * Handle email + password registration
 */
if (!isset($gCms)) exit;

$db = $this->GetDb();
$prefix = CMS_DB_PREFIX;
$errors = [];
$success = false;

// Handle form submission
if (isset($params['submit_register'])) {
    $email = trim($params['email'] ?? '');
    $password = $params['password'] ?? '';
    $password_confirm = $params['password_confirm'] ?? '';
    $name = trim($params['name'] ?? '');
    
    // Validation
    if (empty($email)) {
        $errors[] = $this->Lang('error_email_required');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = $this->Lang('error_email_invalid');
    }
    
    if (empty($password)) {
        $errors[] = $this->Lang('error_password_required');
    } elseif (strlen($password) < 8) {
        $errors[] = $this->Lang('error_password_too_short');
    }
    
    if ($password !== $password_confirm) {
        $errors[] = $this->Lang('error_passwords_dont_match');
    }
    
    // Check if email already exists
    if (empty($errors)) {
        $existing = $db->GetOne(
            "SELECT user_id FROM {$prefix}module_oauth_users WHERE email = ?",
            [$email]
        );
        if ($existing) {
            $errors[] = $this->Lang('error_email_exists');
        }
    }
    
    // Create user
    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $now = date('Y-m-d H:i:s');
        
        $db->Execute(
            "INSERT INTO {$prefix}module_oauth_users (email, password_hash, name, created_at) VALUES (?, ?, ?, ?)",
            [$email, $password_hash, $name ?: null, $now]
        );
        
        $user_id = $db->Insert_ID();
        
        // Log the user in
        $this->SetSession('oauth_user_id', $user_id);
        $this->SetSession('oauth_user_email', $email);
        $this->SetSession('oauth_user_name', $name);
        
        // Redirect to return URL or home
        $return_url = $params['return_url'] ?? $this->GetPreference('default_redirect', '/');
        redirect($return_url);
        return;
    }
}

// Form
$smarty->assign('errors', $errors);
$smarty->assign('email', $params['email'] ?? '');
$smarty->assign('name', $params['name'] ?? '');
$smarty->assign('return_url', $params['return_url'] ?? '');
$smarty->assign('actionid', $id);
$smarty->assign('returnid', $returnid);

// Form start/end
$smarty->assign('formstart', $this->CreateFormStart($id, 'register', $returnid));
$smarty->assign('formend', $this->CreateFormEnd());

// Login URL
$smarty->assign('login_url', $this->create_url($id, 'password_login', $returnid));

echo $this->ProcessOAuthTemplate('register');
