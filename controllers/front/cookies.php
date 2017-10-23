<?php
/**
 * Created by PhpStorm.
 * User: Zomzog
 * Date: 23/10/2017
 * Time: 22:20
 */
require_once _PS_MODULE_DIR_.'z_cookiesalert/z_cookiesalert.php';

class Z_CookiesalertCookiesModuleFrontController extends ModuleFrontController {

    public function initContent()
    {
        $module = new Z_Cookiesalert;

        // You may should do some security work here, like checking an hash from your module
        if (Tools::isSubmit('action')) {

            // Usefull vars derivated from getContext
            $context = Context::getContext();
            $cookie = $context->cookie;

            $cookie->__set('zcookiealert', "accepted");

            // Default response with translation from the module
            $response = array('status' => true, "message" => $module->l('Done.'));
        }

        // Classic json response
        die(Tools::jsonEncode($response));
    }
    // displayAjax for FrontEnd Invoke the ajax action
    // ajaxProcess for BackEnd Invoke the ajax action

    public function displayAjaxAcceptCookies()
    {

        header('Content-Type: application/json');
        die(Tools::jsonEncode(['cookie'=> "accepted"]));
    }
}