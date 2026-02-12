<style>
.oauth-users-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.oauth-users-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}
.oauth-users-count {
    color: #6b7280;
    font-weight: normal;
    font-size: 1rem;
}
.oauth-search-form {
    display: flex;
    gap: 0.5rem;
}
.oauth-search-input {
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.875rem;
    width: 250px;
}
.oauth-search-btn {
    padding: 0.5rem 1rem;
    background: #dd6d0a;
    color: #fff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.oauth-users-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    overflow: hidden;
}
.oauth-users-table th,
.oauth-users-table td {
    padding: 0.75rem 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}
.oauth-users-table th {
    background: #f9fafb;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    color: #6b7280;
}
.oauth-users-table tr:last-child td {
    border-bottom: none;
}
.oauth-users-table tr:hover {
    background: #f9fafb;
}
.oauth-user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 0.5rem;
}
.oauth-user-name {
    font-weight: 500;
}
.oauth-provider-badge {
    display: inline-block;
    padding: 0.125rem 0.5rem;
    background: #e5e7eb;
    border-radius: 9999px;
    font-size: 0.75rem;
    margin-right: 0.25rem;
}
.oauth-provider-badge.github { background: #24292e; color: #fff; }
.oauth-provider-badge.google { background: #4285f4; color: #fff; }
.oauth-provider-badge.password { background: #dd6d0a; color: #fff; }
.oauth-btn-delete {
    color: #dc2626;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
}
.oauth-btn-delete:hover {
    text-decoration: underline;
}
.oauth-pagination {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
}
.oauth-pagination a,
.oauth-pagination span {
    padding: 0.5rem 0.75rem;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    text-decoration: none;
    color: #374151;
}
.oauth-pagination a:hover {
    background: #f3f4f6;
}
.oauth-pagination .current {
    background: #dd6d0a;
    color: #fff;
    border-color: #dd6d0a;
}
.oauth-empty {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}
.oauth-back-link {
    margin-bottom: 1rem;
}
.oauth-back-link a {
    color: #dd6d0a;
    text-decoration: none;
}
</style>

<div class="oauth-back-link">
    <a href="{$mod->create_url($actionid, 'defaultadmin', '')}">&larr; Back to Settings</a>
</div>

<div class="oauth-users-header">
    <h1 class="oauth-users-title">
        Users <span class="oauth-users-count">({$totalUsers})</span>
    </h1>
    
    <form method="get" action="moduleinterface.php" class="oauth-search-form">
        <input type="hidden" name="mact" value="OAuth,{$actionid},admin_users,0">
        <input type="text" name="{$actionid}search" value="{$search|escape}" placeholder="Search users..." class="oauth-search-input">
        <button type="submit" class="oauth-search-btn">Search</button>
    </form>
</div>

{if $users|@count > 0}
<table class="oauth-users-table">
    <thead>
        <tr>
            <th>User</th>
            <th>Email</th>
            <th>Providers</th>
            <th>Created</th>
            <th>Last Login</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        {foreach $users as $user}
        <tr>
            <td>
                {if $user.avatar_url}
                    <img src="{$user.avatar_url|escape}" alt="" class="oauth-user-avatar">
                {/if}
                <span class="oauth-user-name">{$user.name|escape|default:'(no name)'}</span>
            </td>
            <td>{$user.email|escape|default:'-'}</td>
            <td>
                {if $user.password_hash}
                    <span class="oauth-provider-badge password">email</span>
                {/if}
                {if $user.providers}
                    {foreach explode(',', $user.providers) as $provider}
                        <span class="oauth-provider-badge {$provider}">{$provider}</span>
                    {/foreach}
                {/if}
            </td>
            <td>{$user.created_at|date_format:"%Y-%m-%d"}</td>
            <td>{$user.last_login|date_format:"%Y-%m-%d %H:%M"|default:'-'}</td>
            <td>
                <a href="{$mod->create_url($actionid, 'admin_users', '', ['delete_user' => $user.user_id])}" 
                   class="oauth-btn-delete"
                   onclick="return confirm('Delete this user?');">Delete</a>
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>

{if $totalPages > 1}
<div class="oauth-pagination">
    {if $currentPage > 1}
        <a href="{$mod->create_url($actionid, 'admin_users', '', ['page' => $currentPage - 1, 'search' => $search])}">&laquo; Prev</a>
    {/if}
    
    {for $p = 1 to $totalPages}
        {if $p == $currentPage}
            <span class="current">{$p}</span>
        {else}
            <a href="{$mod->create_url($actionid, 'admin_users', '', ['page' => $p, 'search' => $search])}">{$p}</a>
        {/if}
    {/for}
    
    {if $currentPage < $totalPages}
        <a href="{$mod->create_url($actionid, 'admin_users', '', ['page' => $currentPage + 1, 'search' => $search])}">Next &raquo;</a>
    {/if}
</div>
{/if}

{else}
<div class="oauth-empty">
    {if $search}
        No users found matching "{$search|escape}".
    {else}
        No users yet.
    {/if}
</div>
{/if}
