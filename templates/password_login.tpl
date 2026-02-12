<style>
.oauth-login {
    max-width: 400px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border: 1px solid #e0dcd6;
    border-radius: 8px;
}
.oauth-login h2 {
    margin: 0 0 1.5rem 0;
    font-size: 1.5rem;
    font-weight: 600;
    color: #2e353e;
    text-align: center;
}
.oauth-form-group {
    margin-bottom: 1rem;
}
.oauth-form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #2e353e;
}
.oauth-form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e0dcd6;
    border-radius: 6px;
    font-size: 1rem;
    box-sizing: border-box;
}
.oauth-form-input:focus {
    outline: none;
    border-color: #dd6d0a;
    box-shadow: 0 0 0 3px rgba(221, 109, 10, 0.1);
}
.oauth-btn {
    width: 100%;
    padding: 0.75rem 1.5rem;
    background: #dd6d0a;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.15s;
}
.oauth-btn:hover {
    background: #c25f08;
}
.oauth-errors {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1rem;
}
.oauth-errors ul {
    margin: 0;
    padding: 0 0 0 1.5rem;
}
.oauth-link {
    text-align: center;
    margin-top: 1rem;
    color: #666;
}
.oauth-link a {
    color: #dd6d0a;
    text-decoration: none;
}
.oauth-link a:hover {
    text-decoration: underline;
}
</style>

<div class="oauth-login">
    <h2>{$mod->Lang('login_title')|default:'Sign In'}</h2>
    
    {if $errors}
    <div class="oauth-errors">
        <ul>
        {foreach $errors as $error}
            <li>{$error}</li>
        {/foreach}
        </ul>
    </div>
    {/if}
    
    {$formstart}
    <input type="hidden" name="{$actionid}return_url" value="{$return_url|escape}" />
    
    <div class="oauth-form-group">
        <label class="oauth-form-label" for="oauth-email">{$mod->Lang('field_email')|default:'Email'}</label>
        <input type="email" id="oauth-email" name="{$actionid}email" class="oauth-form-input" value="{$email|escape}" required />
    </div>
    
    <div class="oauth-form-group">
        <label class="oauth-form-label" for="oauth-password">{$mod->Lang('field_password')|default:'Password'}</label>
        <input type="password" id="oauth-password" name="{$actionid}password" class="oauth-form-input" required />
    </div>
    
    <button type="submit" name="{$actionid}submit_login" class="oauth-btn">
        {$mod->Lang('btn_login')|default:'Sign In'}
    </button>
    {$formend}
    
    <p class="oauth-link">
        {$mod->Lang('no_account')|default:"Don't have an account?"} 
        <a href="{$register_url}">{$mod->Lang('btn_register')|default:'Create Account'}</a>
    </p>
</div>
