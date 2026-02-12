<?php
/**
 * OAuth Default Action
 * 
 * Default frontend action - shows login buttons if not logged in,
 * or user profile if logged in.
 */
if (!isset($gCms)) exit;

$smarty->assign('mod', $this);

// Get current user
$user = $this->GetCurrentUser();

if ($user) {
    // Show profile
    include __DIR__ . '/action.profile.php';
} else {
    // Show login
    include __DIR__ . '/action.login.php';
}
