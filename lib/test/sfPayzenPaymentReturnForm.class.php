<?php

/**
 * sfPayzenPaymentReturnForm Form to test payzen return
 *
 * @package    sfPayzenPaymentPlugin
 * @subpackage test
 * @author     Patrick Dos Santos <patrick.dos-santos@solution-interactive.com>
 */
class sfPayzenPaymentReturnForm extends sfForm
{
    /**
     * Builds the form.
     * 
     * @param sfPayzenPayment $payment The payment to get the form values from
     * @param array $defaults Defaults option for the form
     * @param array $options The form option
     * @param string $CSRFSecret The csrf secret key
     * @see sfForm 
     */
    public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
    {
        parent::__construct($defaults, $options, $CSRFSecret);

        $this->setWidget('vads_action_mode', new sfWidgetFormInput());
        $this->setWidget('vads_amount', new sfWidgetFormInput());
        $this->setWidget('vads_auth_result', new sfWidgetFormInput());
        $this->setWidget('vads_auth_mode', new sfWidgetFormInput());
        $this->setWidget('vads_auth_number', new sfWidgetFormInput());
        $this->setWidget('vads_capture_delay', new sfWidgetFormInput());
        $this->setWidget('vads_card_brand', new sfWidgetFormInput());
        $this->setWidget('vads_card_number', new sfWidgetFormInput());
        $this->setWidget('vads_ctx_mode', new sfWidgetFormInput());
        $this->setWidget('vads_currency', new sfWidgetFormInput());
        $this->setWidget('vads_ctx_mode', new sfWidgetFormInput());
        $this->setWidget('vads_extra_result', new sfWidgetFormInput());
        $this->setWidget('vads_payment_config', new sfWidgetFormInput());
        $this->setWidget('vads_site_id', new sfWidgetFormInput());
        $this->setWidget('vads_trans_date', new sfWidgetFormInput());
        $this->setWidget('vads_trans_id', new sfWidgetFormInput());
        $this->setWidget('vads_validation_mode', new sfWidgetFormInput());
        $this->setWidget('vads_warranty_result', new sfWidgetFormInput());
        $this->setWidget('vads_payment_certificate', new sfWidgetFormInput());
        $this->setWidget('vads_result', new sfWidgetFormInput());
        $this->setWidget('vads_version', new sfWidgetFormInput());
        $this->setWidget('vads_order_id', new sfWidgetFormInput());
        $this->setWidget('vads_order_info', new sfWidgetFormInput());
        $this->setWidget('vads_order_info_2', new sfWidgetFormInput());
        $this->setWidget('vads_order_info_3', new sfWidgetFormInput());
        $this->setWidget('vads_cust_address', new sfWidgetFormInput());
        $this->setWidget('vads_cust_country', new sfWidgetFormInput());
        $this->setWidget('vads_cust_email', new sfWidgetFormInput());
        $this->setWidget('vads_cust_id', new sfWidgetFormInput());
        $this->setWidget('vads_cust_name', new sfWidgetFormInput());
        $this->setWidget('vads_cust_phone', new sfWidgetFormInput());
        $this->setWidget('vads_cust_title', new sfWidgetFormInput());
        $this->setWidget('vads_cust_city', new sfWidgetFormInput());
        $this->setWidget('vads_cust_zip', new sfWidgetFormInput());
        $this->setWidget('vads_language', new sfWidgetFormInput());
        $this->setWidget('vads_payment_src', new sfWidgetFormInput());
        $this->setWidget('vads_user_info', new sfWidgetFormInput());
        $this->setWidget('vads_theme_config', new sfWidgetFormInput());
        $this->setWidget('vads_contract_used', new sfWidgetFormInput());
        $this->setWidget('vads_expiry_month', new sfWidgetFormInput());
        $this->setWidget('vads_expiry_year', new sfWidgetFormInput());
        $this->setWidget('vads_threeds_enrolled', new sfWidgetFormInput());
        $this->setWidget('vads_threeds_cavv', new sfWidgetFormInput());
        $this->setWidget('vads_threeds_eci', new sfWidgetFormInput());
        $this->setWidget('vads_threeds_xid', new sfWidgetFormInput());
        $this->setWidget('vads_threeds_cavvAlgorithm', new sfWidgetFormInput());
        $this->setWidget('vads_threeds_status', new sfWidgetFormInput());
        $this->setWidget('vads_threeds_sign_valid', new sfWidgetFormInput());
    }
}