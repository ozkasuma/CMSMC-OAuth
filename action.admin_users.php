<?php
/**
 * OAuth Admin - Users Management
 */
if (!isset($gCms)) exit;

if (!$this->CheckPermission('Manage OAuth')) {
    echo $this->ShowErrors($this->Lang('error_permission_denied'));
    return;
}

$db = $this->GetDb();
$prefix = CMS_DB_PREFIX;

// Pagination
$page = (int)($params['page'] ?? 1);
$perPage = 25;
$offset = ($page - 1) * $perPage;

// Search
$search = trim($params['search'] ?? '');
$whereClause = '';
$whereParams = [];
if ($search) {
    $whereClause = "WHERE u.name LIKE ? OR u.email LIKE ?";
    $whereParams = ["%$search%", "%$search%"];
}

// Get total count
$totalUsers = $db->GetOne(
    "SELECT COUNT(*) FROM {$prefix}module_oauth_users u $whereClause",
    $whereParams
);
$totalPages = ceil($totalUsers / $perPage);

// Get users
$users = $db->GetArray(
    "SELECT u.*, 
            GROUP_CONCAT(l.provider) as providers
     FROM {$prefix}module_oauth_users u
     LEFT JOIN {$prefix}module_oauth_links l ON u.user_id = l.user_id
     $whereClause
     GROUP BY u.user_id
     ORDER BY u.created_at DESC
     LIMIT $perPage OFFSET $offset",
    $whereParams
);

// Handle delete
if (isset($params['delete_user'])) {
    $userId = (int)$params['delete_user'];
    $db->Execute("DELETE FROM {$prefix}module_oauth_sessions WHERE user_id = ?", [$userId]);
    $db->Execute("DELETE FROM {$prefix}module_oauth_links WHERE user_id = ?", [$userId]);
    $db->Execute("DELETE FROM {$prefix}module_oauth_users WHERE user_id = ?", [$userId]);
    $this->SetMessage('User deleted');
    $this->RedirectToAdminTab();
    return;
}

$smarty->assign('mod', $this);
$smarty->assign('users', $users);
$smarty->assign('totalUsers', $totalUsers);
$smarty->assign('currentPage', $page);
$smarty->assign('totalPages', $totalPages);
$smarty->assign('search', $search);
$smarty->assign('actionid', $id);

echo $this->ProcessTemplate('admin_users.tpl');
