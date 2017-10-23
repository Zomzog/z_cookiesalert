<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Z_Cookiesalert extends Module
{
    public function __construct()
    {
        $this->name = 'z_cookiesalert';
        $this->tab = 'front_office_features';
        $this->version = '0.1.0';
        $this->author = 'Zomzog';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Cookies Alert');
        $this->description = $this->l('Cookies alert for users.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall? :(');

        if (!Configuration::get('Z_COOKIES_ALERT_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function install()
    {
        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        return parent::install() &&
            $this->registerHook('displayFooter') &&
            $this->registerHook('header') &&
            Configuration::updateValue('Z_COOKIES_ALERT_MESSAGE', 'En poursuivant votre navigation, vous acceptez l\'utilisation des cookies pour disposer de services et d\'offres adaptés à vos centres d\'intérêt.');
    }

    /**
     * Hook to footer
     * @param $params
     * @return mixed
     */
    public function hookDisplayFooter($params)
    {
        if ($this->context->cookie->zcookiealert != "accepted") {
            $this->context->smarty->assign(
                array(
                    'z_cookies_alert_name' => Configuration::get('Z_COOKIES_ALERT_NAME'),
                    'z_cookies_alert_message' => Configuration::get('Z_COOKIES_ALERT_MESSAGE'),
                )
            );
            return $this->display(__FILE__, 'z_cookiesalert.tpl');
        }
    }

    /**
     * Add CSS to header
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet('modules-z_cookiesalert', 'modules/' . $this->name . '/views/css/z_cookiesalert.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules-z_cookiesalert', 'modules/' . $this->name . '/views/js/z_cookiesalert.js', ['position' => 'bottom', 'priority' => 150]);
    }

    /**
     * Enable configuration
     * @return string
     */
    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            $z_cookies_alert_name = (String)Tools::getValue('Z_COOKIES_ALERT_NAME');
            if (!$z_cookies_alert_name
                || empty($z_cookies_alert_name)
                || !Validate::isGenericName($z_cookies_alert_name))
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            else {
                Configuration::updateValue('Z_COOKIES_ALERT_NAME', $z_cookies_alert_name);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }
        return $output . $this->displayConfigForm();
    }

    /**
     * Display configuration form
     * @return mixed
     */
    public function displayConfigForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Message'),
                        'name' => 'Z_COOKIES_ALERT_MESSAGE',
                        'size' => 128,
                        'required' => true
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right'
                )
            )
        );

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                        '&token=' . Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );

        // Load current value
        $helper->fields_value['Z_COOKIES_ALERT_MESSAGE'] = Configuration::get('Z_COOKIES_ALERT_MESSAGE');

        return $helper->generateForm(array($fields_form));
    }
}