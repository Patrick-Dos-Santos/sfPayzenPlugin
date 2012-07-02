<?php

require_once dirname(__FILE__) . '/../../bootstrap.php';
require_once dirname(__FILE__) . '/../../../../lib/payzen/base/sfPayzenPayment.class.php';

/**
 * Instanciation of sfPayzenPayment without the payzen api version set in the configure() 
 */
class sfPayzenPaymentInstanceWithoutVersion extends sfPayzenPayment
{
    
}

/**
 * Instanciation of sfPayzenPayment 
 */
class sfPayzenPaymentInstance extends sfPayzenPayment
{

    private $fakeOption = null;

    public function configure($options = array())
    {
        parent::configure($options);
        $this->payzenApiVersion = '1.0';
        $this->addRequiredOption('required_option');
        $this->addOption('option_name', 'option_value');
    }

    //For the __get function tests
    public function getMethod()
    {
        return 'getMethod() call successfull';
    }

    //For the __set function tests
    public function setFakeOption($parameter)
    {
        $this->fakeOption = $parameter;
    }

    public function getFakeOption()
    {
        return $this->fakeOption;
    }

}

/**
 * Mock event listener to test if an event is thrown when instanciating a sfPayzenPayment 
 */
class mockEventListener
{

    private $eventCaught = false;

    public function listen(sfEvent $event)
    {
        $this->eventCaught = true;
    }

    public function wasEventCaught()
    {
        return $this->eventCaught;
    }

}

$mockEventListener = new mockEventListener();
ProjectConfiguration::getActive()
        ->getEventDispatcher()
        ->connect('sf_payzen_plugin.new_payment', array($mockEventListener, 'listen'));


$t = new lime_test(null, new lime_output_color());

//__construct()
$t->diag('->__construct()');

$t->is($mockEventListener->wasEventCaught(), false, '->__construct() no "sf_payzen_plugin.new_payment" is triggered before a sfPayzenPayment is constructed ');

try
{
    $payment = new sfPayzenPaymentInstanceWithoutVersion();
    $t->fail('->__construct() throws a sfException if the payzen api version is not set');
} catch (sfException $e)
{
    $t->pass('->__construct() throws a sfException if the payzen api version is not set');
    $t->is($mockEventListener->wasEventCaught(), false, '->__construct() no "sf_payzen_plugin.new_payment" if an exception is thrown');
}

try
{
    $payment = new sfPayzenPaymentInstance(array('unknown_key' => 'unknown_value'));
    $t->fail('->__construct() throws a InvalidArgumentException if an option is not supported');
} catch (InvalidArgumentException $e)
{
    $t->pass('->__construct() throws a InvalidArgumentException if an option is not supported');
    $t->is($mockEventListener->wasEventCaught(), false, '->__construct() no "sf_payzen_plugin.new_payment" if an exception is thrown');
}

try
{
    $payment = new sfPayzenPaymentInstance(array());
    $t->fail('->__construct() throws a RuntimeException if a mandatory option is not set');
} catch (RuntimeException $e)
{
    $t->pass('->__construct() throws a RuntimeException if a mandatory option is not set');
    $t->is($mockEventListener->wasEventCaught(), false, '->__construct() no "sf_payzen_plugin.new_payment" if an exception is thrown');
}

$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));
$t->is($payment->__get('option_name'), 'option_value', '->__construct() if an option is not passed in parameter it is set to the default value');

$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate', 'option_name' => 'passed_option_value'));
$t->is($payment->__get('option_name'), 'passed_option_value', '->__construct() if an option is passed in parameter it is set to the passed value');

$t->is($mockEventListener->wasEventCaught(), true, '->__construct() a "sf_payzen_plugin.new_payment" event is thrown when instanciating a sfPayzenPayment');


//configure()
// Since configure is called in the __construct no need to test it
 
 
//addOption()
$t->diag('->addOption()');

$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));
$payment->addOption('new_option');

$t->is($payment->__get('new_option'), null, '->addOption() add an empty option when no option value is passed');

$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));
$payment->addOption('new_option', 'new_value');

$t->is($payment->__get('new_option'), 'new_value', '->addOption() sets an option to the given value');

//getRequiredOptions(), addRequiredOptions
$t->diag('->getRequiredOptions()');

$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));
$t->isa_ok($payment->getRequiredOptions(), 'array', '->getRequiredOptions() returns an array');

$t->diag('->addRequiredOption()');
$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));
$payment->addRequiredOption('required_option2');

$expectedRequiredOptions = array('certificate', 'required_option', 'required_option2');
$t->is_deeply($payment->getRequiredOptions(), $expectedRequiredOptions, '->addRequiredOption() adds a required option');


//getPayzenApiVersion()
$t->diag('->getPayzenApiVersion()');
$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));
$t->isa_ok($payment->getPayzenApiVersion(), 'string', '->getPayzenApiVersion() returns a string');

//setPayzenApiVersion()
$t->diag('->setPayzenApiVersion()');
$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));
$payment->setPayzenApiVersion('9.9');
$t->is($payment->getPayzenApiVersion(), '9.9', '->setPayzenApiVersion() sets the Payzen API version');


//getSignature()
$t->diag('->getSignature()');
$payment = new sfPayzenPaymentInstance(array(
            'required_option' => 'required_value', 'certificate' => 'my_certificate'));

$payment->addOption('vads_a', 'a');
$payment->addOption('vads_c', 'c');
$payment->addOption('vads_b', 'b');
$payment->addOption('certificate', 'my_certificate');
$payment->addOption('non_vads_field', 'non_vads_value');

$signatureContent = 'a+b+c+my_certificate';
$expectedSignature = sha1($signatureContent);

$t->isa_ok($payment->getSignature(), 'string', '->getSignature() returns a string');
$t->is($payment->getSignature(), $expectedSignature, '->getSignature() generates the signature from the vads fields and the certificate');

//toArray()
$t->diag('->toArray()');
$payment = new sfPayzenPaymentInstance(array(
            'required_option' => 'required_value', 'certificate' => 'my_certificate'));

$payment->addOption('vads_a', 'a');
$payment->addOption('vads_c', 'c');
$payment->addOption('vads_b', 'b');
$payment->addOption('certificate', 'my_certificate');
$payment->addOption('non_vads_field', 'non_vads_value');
$payment->addOption('null_field');

$t->isa_ok($payment->toArray(), 'array', '->toArray() returns an array');

$expectedArray = array(
    'option_name' => 'option_value',
    'required_option' => 'required_value',
    'certificate' => 'my_certificate',
    'vads_a' => 'a',
    'vads_c' => 'c',
    'vads_b' => 'b',
    'certificate' => 'my_certificate',
    'non_vads_field' => 'non_vads_value',
);

$t->is_deeply(
        $payment->toArray(), $expectedArray, '->toArray() returns the options that were set');

//->__get()
$t->diag('->__get()');
$payment = new sfPayzenPaymentInstance(array(
            'required_option' => 'required_value',
            'certificate' => 'my_certificate'));

try
{
    $payment->unexisting;
    $t->fail('->__get() returns an InvalidArgumentException 
        if an option does not exists');
} catch (InvalidArgumentException $e)
{
    $t->pass('->__get() returns an InvalidArgumentException if an option does not exists');
}

$t->is($payment->required_option, 'required_value', '->__get() returns an option\'s value');
$t->is($payment->method, 'getMethod() call successfull', '->__get() calls a getFieldName() method for a field called "fieldName"');


//->__set()
$t->diag('->__set()');
$payment = new sfPayzenPaymentInstance(array('required_option' => 'required_value', 'certificate' => 'my_certificate'));

try
{
    $payment->unexisting = 'unexisting';
    $t->fail('->__set() returns an InvalidArgumentException if an option does not exists');
} catch (InvalidArgumentException $e)
{
    $t->pass('->__set() returns an InvalidArgumentException if an option does not exists');
}
$payment->required_option = 'new_value';
$t->is($payment->required_option, 'new_value', '->_set() sets an option\'s value');

$payment->fakeOption = 'fake_option_value';
$t->is($payment->getFakeOption(), 'fake_option_value', '->_set() calls a setFieldName() method for a field called "fieldName"');