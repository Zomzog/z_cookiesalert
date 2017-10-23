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
            $cart = $context->cart;
            $cookie = $context->cookie;
            $customer = $context->customer;
            $id_lang = $cookie->id_lang;

            // Default response with translation from the module
            $response = array('status' => false, "message" => $module->l('Nothing here.'));

            switch (Tools::getValue('action')) {

                case 'action_name':

                    // Edit default response and do some work here
                    $response = array('status' => true, "message" => $module->l('It works !'));

                    break;

                default:
                    break;

            }
        }

        // Classic json response
        $json = Tools::jsonEncode($response);
        echo $json;
        die;

        // For displaying like any other use this method to assign and display your template placed in modules/modulename/views/template/front/...
        // Just put some vars in your template
        // $this->context->smarty->assign(array('var1'=>'value1'));
        // $this->setTemplate('template.tpl');

        // For sending a template in ajax use this method
        // $this->context->smarty->fetch('template.tpl');
    }
    // displayAjax for FrontEnd Invoke the ajax action
    // ajaxProcess for BackEnd Invoke the ajax action

    public function displayAjaxAcceptCookies()
    {
        $this->context->cookie->__set('zcookiealert', "accepted");

        header('Content-Type: application/json');
        die(Tools::jsonEncode(['cookie'=> "accepted"]));
    }
}