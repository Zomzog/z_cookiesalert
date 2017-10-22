<!-- Block mymodule -->
<div id="cookies_alert" class="cookies_alert">
    <div class="cookie-close accept-cookie"><i class="material-icons">close</i></div>
    <div class="container">
        <p>
            {if isset($z_cookies_alert_message) && $z_cookies_alert_message}
                {$z_cookies_alert_message}
            {else}
                z_cookies_alert_message must be configured !
            {/if}
    </div>
</div>
<!-- /Block mymodule -->