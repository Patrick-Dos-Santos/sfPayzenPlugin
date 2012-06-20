<?php

/**
 * sfPayzenPayment_2_8 represents a payment for the Payzen 2.8 API
 * 
 * @package    sfPayzenPaymentPlugin
 * @subpackage payzen
 * @author     Patrick Dos Santos <patrick.dos-santos@solution-interactive.com>
 * @see sfPayzenPayment
 */
class sfPayzenPayment_2_8 extends sfPayzenPayment
{
    //Payzen api version
    const PAYZEN_API_VERSION = '2_8';
    
    //vads_action_mode
    const
            VADS_ACTION_MODE_SILENT = 'SILENT',
            VADS_ACTION_MODE_INTERACTIVE = 'INTERACTIVE';
    
    //vads_contracts
    const
            VADS_CONTRACTS_AMEX = 'AMEX',
            VADS_CONTRACTS_CB = 'CB';
    
    //vads_ctx_mode
    const
            VADS_CTX_MODE_TEST = 'TEST',
            VADS_CTX_MODE_PRODUCTION = 'PRODUCTION';
    
    //vads_currency. List of all currencies : http://www.currency-iso.org/iso_index/isVADS_CURRENCY_GBPo_tables/iso_tables_a1.htm
    const
            VADS_CURRENCY_EURO = '978',
            VADS_CURRENCY_USD = '840',
            VADS_CURRENCY_GBP = '826';
    
    //vads_language
    const
            VADS_LANGUAGE_DE = 'de', //Deutsch
            VADS_LANGUAGE_EN = 'en', //English
            VADS_LANGUAGE_ZH = 'zh', //Chinese
            VADS_LANGUAGE_ES = 'es', //Spanish
            VADS_LANGUAGE_FR = 'fr', //French
            VADS_LANGUAGE_IT = 'it', //Italian
            VADS_LANGUAGE_JP = 'jp', //Japanese
            VADS_LANGUAGE_PT = 'pt'; //Portuguese
    
    //vads_payment_cards
    const
            VADS_PAYMENT_CARDS_AMEX = 'AMEX',
            VADS_PAYMENT_CARDS_CB = 'CB',
            VADS_PAYMENT_CARDS_MASTERCARD = 'MASTERCARD',
            VADS_PAYMENT_CARDS_VISA = 'VISA',
            VADS_PAYMENT_CARDS_MAESTRO = 'MAESTRO',
            VADS_PAYMENT_CARDS_ECARD = 'E-CARTEBLEUE';
    
    //vads_page_action
    const
            VADS_PAGE_ACTION_PAYMENT = 'SINGLE';
    
    //vads_payment_config
    const
            VADS_PAYMENT_CONFIG_SINGLE = 'SINGLE',
            VADS_PAYMENT_CONFIG_MULTI = 'MULTI';
    
    //vads_return_mode
    const
            VADS_RETURN_MODE_NONE = 'NONE',
            VADS_RETURN_MODE_GET = 'GET',
            VADS_RETURN_MODE_POST = 'POST';
    
   //vads_validation_mode
    const
            VADS_VALIDATION_MODE_AUTO = '0',
            VADS_VALIDATION_MODE_MANUAL = '1';
    
   //vads_version
    const
            VADS_VERSION_V2 = 'V2';

    /**
     * @see sfPayzenPayment
     */
    public function configure($options = array())
    {
        parent::configure($options);

        $this->setPayzenApiVersion(self::PAYZEN_API_VERSION);

        $this->addRequiredOption('certificate');

        $this->addRequiredOption('vads_amount');
        $this->addRequiredOption('vads_site_id');
        $this->addRequiredOption('vads_trans_id');

        $this->addOption('vads_action_mode', self::VADS_ACTION_MODE_SILENT);
        $this->addOption('vads_available_languages');
        $this->addOption('vads_capture_delay');
        $this->addOption('vads_contracts');
        $this->addOption('vads_contrib');
        $this->addOption('vads_ctx_mode', self::VADS_CTX_MODE_TEST);
        $this->addOption('vads_currency', self::VADS_CURRENCY_EURO);
        $this->addOption('vads_cust_address');
        $this->addOption('vads_cust_cell_phone');
        $this->addOption('vads_cust_city');
        $this->addOption('vads_cust_country');
        $this->addOption('vads_cust_email');
        $this->addOption('vads_cust_id');
        $this->addOption('vads_cust_name');
        $this->addOption('vads_cust_phone');
        $this->addOption('vads_cust_title');
        $this->addOption('vads_cust_zip');
        $this->addOption('vads_language');
        $this->addOption('vads_order_id');
        $this->addOption('vads_order_info');
        $this->addOption('vads_order_info2');
        $this->addOption('vads_order_info3');
        $this->addOption('vads_page_action', self::VADS_PAGE_ACTION_PAYMENT);
        $this->addOption('vads_payment_cards');
        $this->addOption('vads_payment_config', self::VADS_PAYMENT_CONFIG_SINGLE);
        $this->addOption('vads_redirect_error_message');
        $this->addOption('vads_redirect_error_timeout');
        $this->addOption('vads_redirect_success_message');
        $this->addOption('vads_redirect_success_timeout');
        $this->addOption('vads_return_mode', self::VADS_RETURN_MODE_NONE);
        $this->addOption('vads_ship_to_city');
        $this->addOption('vads_ship_to_country');
        $this->addOption('vads_ship_to_name');
        $this->addOption('vads_ship_to_phone_num');
        $this->addOption('vads_ship_state');
        $this->addOption('vads_ship_street');
        $this->addOption('vads_ship_street2');
        $this->addOption('vads_ship_to_zip');
        $this->addOption('vads_shop_name');
        $this->addOption('vads_shop_url');
        $this->addOption('vads_theme_config');
        $this->addOption('vads_trans_date', gmdate("YmdHis", time()));
        $this->addOption('vads_validation_mode');
        $this->addOption('vads_version', self::VADS_VERSION_V2);
        $this->addOption('vads_url_cancel');
        $this->addOption('vads_url_error');
        $this->addOption('vads_url_referral');
        $this->addOption('vads_url_refused');
        $this->addOption('vads_url_success');
        $this->addOption('vads_url_return');
        $this->addOption('vads_user_info');
    }

}