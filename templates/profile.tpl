{* OAuth Profile Template *}

<style>
.oauth-profile {
    max-width: 500px;
    margin: 0 auto;
    padding: 2rem;
}

.oauth-profile-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.oauth-profile-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    padding: 2rem;
    text-align: center;
    color: #ffffff;
}

.oauth-avatar {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.3);
    margin: 0 auto 1rem;
    object-fit: cover;
    background: rgba(255,255,255,0.2);
}

.oauth-avatar-placeholder {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,0.3);
    margin: 0 auto 1rem;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-weight: 600;
}

.oauth-profile-name {
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
}

.oauth-profile-email {
    opacity: 0.9;
    margin: 0;
}

.oauth-profile-body {
    padding: 1.5rem;
}

.oauth-profile-section {
    margin-bottom: 1.5rem;
}

.oauth-profile-section:last-child {
    margin-bottom: 0;
}

.oauth-profile-section-title {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    margin: 0 0 0.75rem 0;
}

.oauth-connected-providers {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.oauth-provider-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    background: #f3f4f6;
    border-radius: 9999px;
    font-size: 0.875rem;
    color: #374151;
}

.oauth-provider-badge svg {
    width: 16px;
    height: 16px;
}

.oauth-profile-info {
    display: grid;
    gap: 0.75rem;
}

.oauth-profile-info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9375rem;
    color: #374151;
}

.oauth-profile-info-item svg {
    width: 18px;
    height: 18px;
    color: #9ca3af;
}

.oauth-logout-btn {
    display: block;
    width: 100%;
    padding: 0.75rem 1rem;
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.9375rem;
    font-weight: 500;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s;
}

.oauth-logout-btn:hover {
    background: #fecaca;
    color: #dc2626;
}

.oauth-message {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.9375rem;
}

.oauth-message-success {
    background: #dcfce7;
    color: #166534;
}

.oauth-message-error {
    background: #fee2e2;
    color: #dc2626;
}

/* Not logged in state */
.oauth-not-logged-in {
    text-align: center;
    padding: 2rem;
}

.oauth-not-logged-in-icon {
    width: 64px;
    height: 64px;
    color: #9ca3af;
    margin: 0 auto 1rem;
}

.oauth-not-logged-in h3 {
    font-size: 1.25rem;
    color: #374151;
    margin: 0 0 0.5rem 0;
}

.oauth-not-logged-in p {
    color: #6b7280;
    margin: 0 0 1.5rem 0;
}
</style>

<div class="oauth-profile">
    {if isset($success_message)}
        <div class="oauth-message oauth-message-success">{$success_message|escape}</div>
    {/if}
    {if isset($error_message)}
        <div class="oauth-message oauth-message-error">{$error_message|escape}</div>
    {/if}

    {if $is_logged_in}
        <div class="oauth-profile-card">
            <div class="oauth-profile-header">
                {if $user.avatar_url}
                    <img src="{$user.avatar_url|escape}" alt="" class="oauth-avatar">
                {else}
                    <div class="oauth-avatar-placeholder">
                        {$user.name|truncate:1:'':true|upper}
                    </div>
                {/if}
                <h2 class="oauth-profile-name">{$user.name|escape}</h2>
                {if $user.email}
                    <p class="oauth-profile-email">{$user.email|escape}</p>
                {/if}
            </div>
            
            <div class="oauth-profile-body">
                {if $linked_providers|@count > 0}
                    <div class="oauth-profile-section">
                        <h3 class="oauth-profile-section-title">{$mod->Lang('connected_accounts')}</h3>
                        <div class="oauth-connected-providers">
                            {foreach $linked_providers as $provider}
                                <span class="oauth-provider-badge" style="color: {$provider.color}">
                                    {$provider.icon}
                                    {$provider.name}
                                </span>
                            {/foreach}
                        </div>
                    </div>
                {/if}
                
                <div class="oauth-profile-section">
                    <h3 class="oauth-profile-section-title">{$mod->Lang('account_info')}</h3>
                    <div class="oauth-profile-info">
                        <div class="oauth-profile-info-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{$mod->Lang('member_since')}: {$user.created_at|date_format:"%B %d, %Y"}</span>
                        </div>
                        <div class="oauth-profile-info-item">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{$mod->Lang('last_login')}: {$user.last_login|date_format:"%B %d, %Y %H:%M"}</span>
                        </div>
                    </div>
                </div>
                
                <div class="oauth-profile-section">
                    <a href="{$logout_url}" class="oauth-logout-btn">
                        {$mod->Lang('logout')}
                    </a>
                </div>
            </div>
        </div>
    {else}
        <div class="oauth-profile-card">
            <div class="oauth-not-logged-in">
                <svg class="oauth-not-logged-in-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3>{$mod->Lang('not_logged_in')}</h3>
                <p>{$mod->Lang('not_logged_in_desc')}</p>
                
                {if $providers|@count > 0}
                    <div class="oauth-providers" style="max-width: 280px; margin: 0 auto;">
                        {foreach $providers as $provider}
                            <a href="{$provider.login_url}" class="oauth-btn oauth-btn-{$provider.key}">
                                <span class="oauth-btn-icon">{$provider.icon}</span>
                                <span>{$mod->Lang('login_with', $provider.display_name)}</span>
                            </a>
                        {/foreach}
                    </div>
                {/if}
            </div>
        </div>
    {/if}
</div>
