{* OAuth Admin Settings Template *}

<style>
.oauth-admin {
    max-width: 1200px;
}

.oauth-admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.oauth-admin-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.oauth-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.oauth-stat-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    padding: 1.25rem;
}

.oauth-stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
}

.oauth-stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.oauth-section {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
}

.oauth-section-header {
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f9fafb;
    border-radius: 0.5rem 0.5rem 0 0;
}

.oauth-section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.oauth-section-body {
    padding: 1.25rem;
}

.oauth-form-group {
    margin-bottom: 1.25rem;
}

.oauth-form-group:last-child {
    margin-bottom: 0;
}

.oauth-form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.375rem;
}

.oauth-form-input {
    display: block;
    width: 100%;
    padding: 0.5rem 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 0.9375rem;
    transition: border-color 0.15s;
    box-sizing: border-box;
}

.oauth-form-input:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.oauth-form-input[readonly] {
    background: #f3f4f6;
    color: #6b7280;
}

.oauth-form-hint {
    font-size: 0.8125rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.oauth-form-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.oauth-form-checkbox input[type="checkbox"] {
    width: 1rem;
    height: 1rem;
    accent-color: #6366f1;
}

.oauth-provider-card {
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
}

.oauth-provider-card:last-child {
    margin-bottom: 0;
}

.oauth-provider-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: #f9fafb;
    border-radius: 0.5rem 0.5rem 0 0;
    cursor: pointer;
}

.oauth-provider-header:hover {
    background: #f3f4f6;
}

.oauth-provider-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: #1f2937;
}

.oauth-provider-icon {
    width: 24px;
    height: 24px;
}

.oauth-provider-icon svg {
    width: 100%;
    height: 100%;
}

.oauth-provider-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.oauth-badge {
    padding: 0.25rem 0.625rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
}

.oauth-badge-enabled {
    background: #dcfce7;
    color: #166534;
}

.oauth-badge-disabled {
    background: #f3f4f6;
    color: #6b7280;
}

.oauth-user-count {
    font-size: 0.875rem;
    color: #6b7280;
}

.oauth-provider-body {
    padding: 1rem;
    border-top: 1px solid #e5e7eb;
}

.oauth-provider-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (max-width: 768px) {
    .oauth-provider-grid {
        grid-template-columns: 1fr;
    }
}

.oauth-callback-url {
    background: #f9fafb;
    padding: 0.75rem;
    border-radius: 0.375rem;
    font-family: monospace;
    font-size: 0.8125rem;
    word-break: break-all;
    color: #374151;
    border: 1px solid #e5e7eb;
}

.oauth-recent-logins {
    overflow-x: auto;
}

.oauth-recent-logins table {
    width: 100%;
    border-collapse: collapse;
}

.oauth-recent-logins th,
.oauth-recent-logins td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.oauth-recent-logins th {
    font-weight: 600;
    color: #374151;
    background: #f9fafb;
}

.oauth-recent-logins td {
    color: #6b7280;
}

.oauth-user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 0.5rem;
}

.oauth-submit-row {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.oauth-btn-submit {
    padding: 0.625rem 1.5rem;
    background: #6366f1;
    color: #ffffff;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.9375rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.15s;
}

.oauth-btn-submit:hover {
    background: #4f46e5;
}
</style>

<div class="oauth-admin">
    <div class="oauth-admin-header">
        <h1 class="oauth-admin-title">{$mod->Lang('admin_title')}</h1>
    </div>

    {* Statistics *}
    <div class="oauth-stats">
        <div class="oauth-stat-card">
            <div class="oauth-stat-value">{$totalUsers}</div>
            <div class="oauth-stat-label">{$mod->Lang('total_users')}</div>
        </div>
        <div class="oauth-stat-card">
            <div class="oauth-stat-value">{$totalSessions}</div>
            <div class="oauth-stat-label">{$mod->Lang('active_sessions')}</div>
        </div>
        {foreach $providers as $key => $label}
            <div class="oauth-stat-card">
                <div class="oauth-stat-value">{$providerCounts[$key]|default:0}</div>
                <div class="oauth-stat-label">{$label} {$mod->Lang('users')}</div>
            </div>
        {/foreach}
    </div>

    {$formstart}

    {* General Settings *}
    <div class="oauth-section">
        <div class="oauth-section-header">
            <h2 class="oauth-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                {$mod->Lang('general_settings')}
            </h2>
        </div>
        <div class="oauth-section-body">
            <div class="oauth-form-group">
                <label class="oauth-form-checkbox">
                    <input type="checkbox" name="{$actionid}require_https" value="1" {if $settings.require_https}checked{/if}>
                    <span class="oauth-form-label" style="margin: 0">{$mod->Lang('require_https')}</span>
                </label>
                <p class="oauth-form-hint">{$mod->Lang('require_https_hint')}</p>
            </div>
            
            <div class="oauth-form-group">
                <label class="oauth-form-label">{$mod->Lang('default_redirect')}</label>
                <input type="text" name="{$actionid}default_redirect" value="{$settings.default_redirect|escape}" class="oauth-form-input">
                <p class="oauth-form-hint">{$mod->Lang('default_redirect_hint')}</p>
            </div>
        </div>
    </div>

    {* Provider Settings *}
    <div class="oauth-section">
        <div class="oauth-section-header">
            <h2 class="oauth-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                {$mod->Lang('provider_settings')}
            </h2>
        </div>
        <div class="oauth-section-body">
            {* GitHub *}
            <div class="oauth-provider-card">
                <div class="oauth-provider-header">
                    <div class="oauth-provider-title">
                        <span class="oauth-provider-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                        </span>
                        GitHub
                    </div>
                    <div class="oauth-provider-status">
                        {if $providerConfigs.github.enabled}
                            <span class="oauth-badge oauth-badge-enabled">{$mod->Lang('enabled')}</span>
                        {else}
                            <span class="oauth-badge oauth-badge-disabled">{$mod->Lang('disabled')}</span>
                        {/if}
                        <span class="oauth-user-count">{$providerCounts.github|default:0} {$mod->Lang('users')}</span>
                    </div>
                </div>
                <div class="oauth-provider-body">
                    <div class="oauth-form-group">
                        <label class="oauth-form-checkbox">
                            <input type="checkbox" name="{$actionid}provider_github_enabled" value="1" {if $providerConfigs.github.enabled}checked{/if}>
                            <span>{$mod->Lang('enable_provider')}</span>
                        </label>
                    </div>
                    <div class="oauth-provider-grid">
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_id')}</label>
                            <input type="text" name="{$actionid}provider_github_client_id" value="{$providerConfigs.github.client_id|escape}" class="oauth-form-input">
                        </div>
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_secret')}</label>
                            <input type="password" name="{$actionid}provider_github_client_secret" value="{$providerConfigs.github.client_secret|escape}" class="oauth-form-input" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('scopes')}</label>
                        <input type="text" name="{$actionid}provider_github_scopes" value="{$providerConfigs.github.scopes|escape}" class="oauth-form-input" placeholder="read:user,user:email">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('callback_url')}</label>
                        <div class="oauth-callback-url">{$callbackUrls.github|escape}</div>
                        <p class="oauth-form-hint">{$mod->Lang('callback_url_hint')}</p>
                    </div>
                </div>
            </div>

            {* Google *}
            <div class="oauth-provider-card">
                <div class="oauth-provider-header">
                    <div class="oauth-provider-title">
                        <span class="oauth-provider-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                        </span>
                        Google
                    </div>
                    <div class="oauth-provider-status">
                        {if $providerConfigs.google.enabled}
                            <span class="oauth-badge oauth-badge-enabled">{$mod->Lang('enabled')}</span>
                        {else}
                            <span class="oauth-badge oauth-badge-disabled">{$mod->Lang('disabled')}</span>
                        {/if}
                        <span class="oauth-user-count">{$providerCounts.google|default:0} {$mod->Lang('users')}</span>
                    </div>
                </div>
                <div class="oauth-provider-body">
                    <div class="oauth-form-group">
                        <label class="oauth-form-checkbox">
                            <input type="checkbox" name="{$actionid}provider_google_enabled" value="1" {if $providerConfigs.google.enabled}checked{/if}>
                            <span>{$mod->Lang('enable_provider')}</span>
                        </label>
                    </div>
                    <div class="oauth-provider-grid">
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_id')}</label>
                            <input type="text" name="{$actionid}provider_google_client_id" value="{$providerConfigs.google.client_id|escape}" class="oauth-form-input">
                        </div>
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_secret')}</label>
                            <input type="password" name="{$actionid}provider_google_client_secret" value="{$providerConfigs.google.client_secret|escape}" class="oauth-form-input" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('scopes')}</label>
                        <input type="text" name="{$actionid}provider_google_scopes" value="{$providerConfigs.google.scopes|escape}" class="oauth-form-input" placeholder="openid,email,profile">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('callback_url')}</label>
                        <div class="oauth-callback-url">{$callbackUrls.google|escape}</div>
                    </div>
                </div>
            </div>

            {* Facebook *}
            <div class="oauth-provider-card">
                <div class="oauth-provider-header">
                    <div class="oauth-provider-title">
                        <span class="oauth-provider-icon" style="color: #1877F2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </span>
                        Facebook
                    </div>
                    <div class="oauth-provider-status">
                        {if $providerConfigs.facebook.enabled}
                            <span class="oauth-badge oauth-badge-enabled">{$mod->Lang('enabled')}</span>
                        {else}
                            <span class="oauth-badge oauth-badge-disabled">{$mod->Lang('disabled')}</span>
                        {/if}
                        <span class="oauth-user-count">{$providerCounts.facebook|default:0} {$mod->Lang('users')}</span>
                    </div>
                </div>
                <div class="oauth-provider-body">
                    <div class="oauth-form-group">
                        <label class="oauth-form-checkbox">
                            <input type="checkbox" name="{$actionid}provider_facebook_enabled" value="1" {if $providerConfigs.facebook.enabled}checked{/if}>
                            <span>{$mod->Lang('enable_provider')}</span>
                        </label>
                    </div>
                    <div class="oauth-provider-grid">
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_id')} (App ID)</label>
                            <input type="text" name="{$actionid}provider_facebook_client_id" value="{$providerConfigs.facebook.client_id|escape}" class="oauth-form-input">
                        </div>
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_secret')} (App Secret)</label>
                            <input type="password" name="{$actionid}provider_facebook_client_secret" value="{$providerConfigs.facebook.client_secret|escape}" class="oauth-form-input" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('scopes')}</label>
                        <input type="text" name="{$actionid}provider_facebook_scopes" value="{$providerConfigs.facebook.scopes|escape}" class="oauth-form-input" placeholder="email,public_profile">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('callback_url')}</label>
                        <div class="oauth-callback-url">{$callbackUrls.facebook|escape}</div>
                    </div>
                </div>
            </div>

            {* Twitter *}
            <div class="oauth-provider-card">
                <div class="oauth-provider-header">
                    <div class="oauth-provider-title">
                        <span class="oauth-provider-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </span>
                        Twitter / X
                    </div>
                    <div class="oauth-provider-status">
                        {if $providerConfigs.twitter.enabled}
                            <span class="oauth-badge oauth-badge-enabled">{$mod->Lang('enabled')}</span>
                        {else}
                            <span class="oauth-badge oauth-badge-disabled">{$mod->Lang('disabled')}</span>
                        {/if}
                        <span class="oauth-user-count">{$providerCounts.twitter|default:0} {$mod->Lang('users')}</span>
                    </div>
                </div>
                <div class="oauth-provider-body">
                    <div class="oauth-form-group">
                        <label class="oauth-form-checkbox">
                            <input type="checkbox" name="{$actionid}provider_twitter_enabled" value="1" {if $providerConfigs.twitter.enabled}checked{/if}>
                            <span>{$mod->Lang('enable_provider')}</span>
                        </label>
                    </div>
                    <div class="oauth-provider-grid">
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_id')}</label>
                            <input type="text" name="{$actionid}provider_twitter_client_id" value="{$providerConfigs.twitter.client_id|escape}" class="oauth-form-input">
                        </div>
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_secret')}</label>
                            <input type="password" name="{$actionid}provider_twitter_client_secret" value="{$providerConfigs.twitter.client_secret|escape}" class="oauth-form-input" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('scopes')}</label>
                        <input type="text" name="{$actionid}provider_twitter_scopes" value="{$providerConfigs.twitter.scopes|escape}" class="oauth-form-input" placeholder="tweet.read,users.read">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('callback_url')}</label>
                        <div class="oauth-callback-url">{$callbackUrls.twitter|escape}</div>
                    </div>
                </div>
            </div>

            {* Generic OAuth2 *}
            <div class="oauth-provider-card">
                <div class="oauth-provider-header">
                    <div class="oauth-provider-title">
                        <span class="oauth-provider-icon" style="color: #6366f1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/><path d="M2 12h20"/></svg>
                        </span>
                        {$mod->Lang('generic_oauth')}
                    </div>
                    <div class="oauth-provider-status">
                        {if $providerConfigs.generic.enabled}
                            <span class="oauth-badge oauth-badge-enabled">{$mod->Lang('enabled')}</span>
                        {else}
                            <span class="oauth-badge oauth-badge-disabled">{$mod->Lang('disabled')}</span>
                        {/if}
                        <span class="oauth-user-count">{$providerCounts.generic|default:0} {$mod->Lang('users')}</span>
                    </div>
                </div>
                <div class="oauth-provider-body">
                    <div class="oauth-form-group">
                        <label class="oauth-form-checkbox">
                            <input type="checkbox" name="{$actionid}provider_generic_enabled" value="1" {if $providerConfigs.generic.enabled}checked{/if}>
                            <span>{$mod->Lang('enable_provider')}</span>
                        </label>
                    </div>
                    <div class="oauth-provider-grid">
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_id')}</label>
                            <input type="text" name="{$actionid}provider_generic_client_id" value="{$providerConfigs.generic.client_id|escape}" class="oauth-form-input">
                        </div>
                        <div class="oauth-form-group">
                            <label class="oauth-form-label">{$mod->Lang('client_secret')}</label>
                            <input type="password" name="{$actionid}provider_generic_client_secret" value="{$providerConfigs.generic.client_secret|escape}" class="oauth-form-input" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('authorize_url')}</label>
                        <input type="text" name="{$actionid}provider_generic_authorize_url" value="{$providerConfigs.generic.authorize_url|escape}" class="oauth-form-input" placeholder="https://provider.com/oauth/authorize">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('token_url')}</label>
                        <input type="text" name="{$actionid}provider_generic_token_url" value="{$providerConfigs.generic.token_url|escape}" class="oauth-form-input" placeholder="https://provider.com/oauth/token">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('userinfo_url')}</label>
                        <input type="text" name="{$actionid}provider_generic_userinfo_url" value="{$providerConfigs.generic.userinfo_url|escape}" class="oauth-form-input" placeholder="https://provider.com/api/userinfo">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('scopes')}</label>
                        <input type="text" name="{$actionid}provider_generic_scopes" value="{$providerConfigs.generic.scopes|escape}" class="oauth-form-input" placeholder="openid,email,profile">
                    </div>
                    <div class="oauth-form-group">
                        <label class="oauth-form-label">{$mod->Lang('callback_url')}</label>
                        <div class="oauth-callback-url">{$callbackUrls.generic|escape}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {* Recent Logins *}
    {if $recentLogins|@count > 0}
    <div class="oauth-section">
        <div class="oauth-section-header">
            <h2 class="oauth-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                {$mod->Lang('recent_logins')}
            </h2>
        </div>
        <div class="oauth-section-body oauth-recent-logins">
            <table>
                <thead>
                    <tr>
                        <th>{$mod->Lang('user')}</th>
                        <th>{$mod->Lang('email')}</th>
                        <th>{$mod->Lang('provider')}</th>
                        <th>{$mod->Lang('last_login')}</th>
                    </tr>
                </thead>
                <tbody>
                    {foreach $recentLogins as $login}
                    <tr>
                        <td>
                            {if $login.avatar_url}
                                <img src="{$login.avatar_url|escape}" alt="" class="oauth-user-avatar">
                            {/if}
                            {$login.name|escape}
                        </td>
                        <td>{$login.email|escape|default:'-'}</td>
                        <td>{$providers[$login.provider]|default:$login.provider}</td>
                        <td>{$login.last_login|date_format:"%Y-%m-%d %H:%M"}</td>
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    {/if}

    <div class="oauth-submit-row">
        <button type="submit" name="{$actionid}submit" value="1" class="oauth-btn-submit">
            {$mod->Lang('save_settings')}
        </button>
    </div>

    {$formend}
</div>
