{* OAuth Login Template *}

<style>
:root {
    --oauth-radius: 0.5rem;
    --oauth-shadow: 0 2px 4px rgba(0,0,0,0.1);
    --oauth-shadow-hover: 0 4px 8px rgba(0,0,0,0.15);
}

.oauth-login {
    max-width: 400px;
    margin: 0 auto;
    padding: 2rem;
}

.oauth-login-title {
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 1.5rem;
    color: #1f2937;
}

.oauth-login-desc {
    text-align: center;
    color: #6b7280;
    margin-bottom: 1.5rem;
}

.oauth-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
    padding: 1rem;
    border-radius: var(--oauth-radius);
    margin-bottom: 1.5rem;
    text-align: center;
}

.oauth-providers {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.oauth-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 0.875rem 1.25rem;
    border: 1px solid #e5e7eb;
    border-radius: var(--oauth-radius);
    font-size: 1rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: var(--oauth-shadow);
    cursor: pointer;
}

.oauth-btn:hover {
    box-shadow: var(--oauth-shadow-hover);
    transform: translateY(-1px);
}

.oauth-btn-icon {
    width: 24px;
    height: 24px;
    flex-shrink: 0;
}

.oauth-btn-icon svg {
    width: 100%;
    height: 100%;
}

/* Provider-specific styles */
.oauth-btn-github {
    background: #24292e;
    color: #ffffff;
    border-color: #24292e;
}
.oauth-btn-github:hover {
    background: #1b1f23;
    color: #ffffff;
}

.oauth-btn-google {
    background: #ffffff;
    color: #374151;
    border-color: #e5e7eb;
}
.oauth-btn-google:hover {
    background: #f9fafb;
    color: #374151;
}

.oauth-btn-facebook {
    background: #1877F2;
    color: #ffffff;
    border-color: #1877F2;
}
.oauth-btn-facebook:hover {
    background: #1565d8;
    color: #ffffff;
}

.oauth-btn-twitter {
    background: #000000;
    color: #ffffff;
    border-color: #000000;
}
.oauth-btn-twitter:hover {
    background: #1a1a1a;
    color: #ffffff;
}

.oauth-btn-generic {
    background: #6366f1;
    color: #ffffff;
    border-color: #6366f1;
}
.oauth-btn-generic:hover {
    background: #4f46e5;
    color: #ffffff;
}

.oauth-divider {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin: 1.5rem 0;
    color: #9ca3af;
    font-size: 0.875rem;
}

.oauth-divider::before,
.oauth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
}

.oauth-logged-in {
    text-align: center;
    padding: 1rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: var(--oauth-radius);
}

.oauth-logged-in-msg {
    color: #166534;
    margin: 0 0 0.5rem 0;
}

.oauth-logged-in-user {
    font-weight: 600;
    color: #15803d;
}
</style>

<div class="oauth-login">
    {if isset($error)}
        <div class="oauth-error">{$error|escape}</div>
    {/if}
    
    {if isset($is_logged_in) && $is_logged_in}
        <div class="oauth-logged-in">
            <p class="oauth-logged-in-msg">{$mod->Lang('already_logged_in')}</p>
            <p class="oauth-logged-in-user">{$user.name|escape}</p>
        </div>
    {else}
        <h2 class="oauth-login-title">{$mod->Lang('login_title')}</h2>
        <p class="oauth-login-desc">{$mod->Lang('login_description')}</p>
        
        {if $providers|@count > 0}
            <div class="oauth-providers">
                {foreach $providers as $provider}
                    <a href="{$provider.login_url}" class="oauth-btn oauth-btn-{$provider.key}">
                        <span class="oauth-btn-icon">{$provider.icon}</span>
                        <span>{$mod->Lang('login_with', $provider.display_name)}</span>
                    </a>
                {/foreach}
            </div>
        {else}
            <p class="oauth-login-desc">{$mod->Lang('error_no_providers')}</p>
        {/if}
    {/if}
</div>
