<?php

require_once dirname(__FILE__) . '/../../bootstrap.php';
require_once dirname(__FILE__) . '/../../../../lib/payzen/base/sfPayzenPaymentForm.class.php';

$t = new lime_test(null, new lime_output_color());

/**
 * Instanciation of sfPayzenPayment 
 */
class sfPayzenPaymentStub extends sfPayzenPayment
{

    public function configure($options = array())
    {
        $this->payzenApiVersion = '1.0';
    }

}

//->__construct()
$t->diag('->__construct()');
$payment = new sfPayzenPaymentStub(array('certificate' => 'certificate'));
$payment->addOption('vads_a', 'a');

$form = new sfPayzenPaymentForm($payment);

try
{
    $form->getWidget('certificate');
    $t->fail('->__construct() non "vads" fields are not taken into account when creating the form');
} catch (InvalidArgumentException $e)
{
    $t->pass('->__construct() non "vads" fields are not taken into account when creating the form');
}

//vads values
$wigdet = $form->getWidget('vads_a');

$t->isa_ok($wigdet, 'sfWidgetFormInputHidden', '->__construct() sets "vads" fields as hidden inputs');
$t->is($wigdet->getDefault(), 'a', '->__construct() sets "vads" values as default values for the widgets');

//signature
$wigdet = $form->getWidget('signature');

$t->isa_ok($wigdet, 'sfWidgetFormInputHidden', '->__construct() sets the signature as an hidden input');
$t->is($wigdet->getDefault(), $payment->getSignature(), '->__construct() gets the signature from the sfPayzenPayment object');