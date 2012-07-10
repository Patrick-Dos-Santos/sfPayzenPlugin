<?php

/**
 * sfPayzenPaymentForm Form to send the value to the Payzen platform
 *
 * @package    sfPayzenPaymentPlugin
 * @subpackage payzen
 * @author     Patrick Dos Santos <patrick.dos-santos [at] solution-interactive.com>
 */
class sfPayzenPaymentForm extends sfForm
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
    public function __construct(sfPayzenPayment $payment, $defaults = array(), $options = array(), $CSRFSecret = null)
    {
        parent::__construct($defaults, $options, $CSRFSecret);

        //We do not want the CSRF token to be sent to Payzen plateform
        unset($this['_csrf_token']);

        foreach ($payment->getVadsArray() as $name => $value)
        {
            $this->setWidget($name, new sfWidgetFormInputHidden(array('default' => $value)));
        }
        $this->setWidget('signature', new sfWidgetFormInputHidden(array('default' => $payment->getSignature())));
    }

}