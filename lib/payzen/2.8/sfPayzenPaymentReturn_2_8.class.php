<?php

/**
 * sfPayzenPaymentReturn_2_8 represents a payment return from Payzen 2.8 API
 * 
 * @package    sfPayzenPaymentPlugin
 * @subpackage payzen
 * @author     Patrick Dos Santos <patrick.dos-santos [at] solution-interactive.com>
 * @see sfPayzenPaymentReturn
 */
class sfPayzenPaymentReturn_2_8 extends sfPayzenPaymentReturn
{
    /**
     * @see sfPayzenPaymentReturn
     */
    public function configure($fields = array())
    {
        parent::configure($fields);
        $this->addField('Signature');
        $this->addField('vads_amount');
        $this->addField('vads_action_mode');
        $this->addField('vads_amount');
        $this->addField('vads_auth_result');
        $this->addField('vads_auth_mode');
        $this->addField('vads_auth_number');
        $this->addField('vads_capture_delay');
        $this->addField('vads_card_brand');
        $this->addField('vads_card_number');
        $this->addField('vads_ctx_mode');
        $this->addField('vads_currency');
        $this->addField('vads_ctx_mode');
        $this->addField('vads_extra_result');
        $this->addField('vads_payment_config');
        $this->addField('vads_site_id');
        $this->addField('vads_trans_date');
        $this->addField('vads_trans_id');
        $this->addField('vads_validation_mode');
        $this->addField('vads_warranty_result');
        $this->addField('vads_payment_certificate');
        $this->addField('vads_result');
        $this->addField('vads_version');
        $this->addField('vads_order_id');
        $this->addField('vads_order_info');
        $this->addField('vads_order_info_2');
        $this->addField('vads_order_info_3');
        $this->addField('vads_cust_address');
        $this->addField('vads_cust_country');
        $this->addField('vads_cust_email');
        $this->addField('vads_cust_id');
        $this->addField('vads_cust_name');
        $this->addField('vads_cust_phone');
        $this->addField('vads_cust_title');
        $this->addField('vads_cust_city');
        $this->addField('vads_cust_zip');
        $this->addField('vads_language');
        $this->addField('vads_payment_src');
        $this->addField('vads_user_info');
        $this->addField('vads_theme_config');
        $this->addField('vads_contract_used');
        $this->addField('vads_expiry_month');
        $this->addField('vads_expiry_year');
        $this->addField('vads_threeds_enrolled');
        $this->addField('vads_threeds_cavv');
        $this->addField('vads_threeds_eci');
        $this->addField('vads_threeds_xid');
        $this->addField('vads_threeds_cavvAlgorithm');
        $this->addField('vads_threeds_status');
        $this->addField('vads_threeds_sign_valid');

        //required fields
        $this->validatorSchema['Signature'] = new sfValidatorString(array('required' => true));
        $this->validatorSchema['vads_action_mode'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_action_mode'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_amount'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_amount'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_auth_mode'] = new sfValidatorChoice(array('choices' => array('MARK', 'FULL'), 'required' => true));
        $this->validatorSchema['vads_ctx_mode'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_ctx_mode'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_currency'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_currency'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_payment_config'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_payment_config'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_site_id'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_site_id'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_trans_date'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_trans_date'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_trans_id'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_trans_id'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_version'] = new sfValidatorEqual(array('value' => $this->payment->__get('vads_version'), 'required' => true, 'strict' => true));
        $this->validatorSchema['vads_contract_used'] = new sfValidatorString(array('max_length' => 250, 'required' => true));

        //can be empty
        $this->validatorSchema['vads_auth_result'] = new sfValidatorInteger(array('max' => 99));
        $this->validatorSchema['vads_auth_number'] = new sfValidatorInteger(array('max' => 999999));
        $this->validatorSchema['vads_card_brand'] = new sfValidatorString(array('max_length' => 127));
        $this->validatorSchema['vads_card_number'] = new sfValidatorString(array('max_length' => 19));
        $this->validatorSchema['vads_extra_result'] = new sfValidatorInteger(array('max' => 99));
        $this->validatorSchema['vads_payment_certificate'] = new sfValidatorString(array('max_length' => 40));
        $this->validatorSchema['vads_result'] = new sfValidatorInteger(array('max' => 99));
        $this->validatorSchema['vads_warranty_result'] = new sfValidatorChoice(array('choices' => array('YES', 'NO', 'UNKNOWN')));
        $this->validatorSchema['vads_threeds_enrolled'] = new sfValidatorString(array('max_length' => 1));
        $this->validatorSchema['vads_threeds_cavv'] = new sfValidatorString(array('max_length' => 28));
        $this->validatorSchema['vads_threeds_eci'] = new sfValidatorInteger(array('max' => 99));
        $this->validatorSchema['vads_threeds_xid'] = new sfValidatorString(array('max_length' => 28));
        $this->validatorSchema['vads_threeds_cavvAlgorithm'] = new sfValidatorInteger(array('max' => 9));
        $this->validatorSchema['vads_threeds_status'] = new sfValidatorString(array('max_length' => 1));
        $this->validatorSchema['vads_threeds_sign_valid'] = new sfValidatorInteger(array('max' => 1));

        //must match the payment value if possible
        $this->addMatchPaymentOrDefaultValidator('vads_validation_mode', new sfValidatorInteger(array('max' => 9, 'required' => true)));
        $this->addMatchPaymentOrDefaultValidator('vads_capture_delay', new sfValidatorInteger(array('max' => 999, 'required' => true)));
        $this->addMatchPaymentOrDefaultValidator('vads_order_id', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_order_info', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_order_info_2', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_order_info_2', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_order_info_3', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_address', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_country', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_email', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_id', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_name', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_title', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_phone', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_city', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_cust_zip', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_language', new sfValidatorString(array('required' => true)));
        $this->addMatchPaymentOrDefaultValidator('vads_payment_src', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_user_info', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_theme_config', new sfValidatorString());
        $this->addMatchPaymentOrDefaultValidator('vads_expiry_month', new sfValidatorInteger(array('max' => 99)));
        $this->addMatchPaymentOrDefaultValidator('vads_expiry_year', new sfValidatorInteger(array('max' => 9999)));
    }
}