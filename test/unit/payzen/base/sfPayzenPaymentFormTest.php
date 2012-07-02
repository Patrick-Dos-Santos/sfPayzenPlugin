<?php

require_once dirname(__FILE__).'/../../bootstrap.php';
require_once dirname(__FILE__).'/../../../../lib/payzen/base/sfPayzenPaymentForm.class.php';

$t = new lime_test(1, new lime_output_color());

$t->is(true, true);

//    public function __construct(sfPayzenPayment $payment, $defaults = array(), $options = array(), $CSRFSecret = null)
//    {
//        parent::__construct($defaults, $options, $CSRFSecret);
//
//        //We do not want the CSRF token to be sent to Payzen plateform
//        unset($this['_csrf_token']);
//        
//        foreach ($payment->toArray() as $name => $value) {
//            if (substr($name, 0, 5) == 'vads_') {
//                $this->setWidget($name, new sfWidgetFormInputHidden(array('default' => $value)));
//            }
//        }
//        $this->setWidget('signature', new sfWidgetFormInputHidden(array('default' => $payment->getSignature())));
//    }