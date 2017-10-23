<!-- Block mymodule -->
<div id="cookies_alert" class="cookies_alert" data-url="{url entity='module' name='z_cookiesalert' controller='Cookies' params = [action => 'action_name']}">
    <div class="cookie-close accept-cookie"><i class="material-icons">close</i></div>
    <div class="container">
        <p>
            {if isset($z_cookies_alert_message) && $z_cookies_alert_message}
                {$z_cookies_alert_message}
            {else}
                z_cookies_alert_message must be configured !
            {/if}
        </p>
    </div>
</div>
<!-- /Block mymodule -->