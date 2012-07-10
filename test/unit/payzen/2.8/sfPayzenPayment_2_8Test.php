<?php

require_once dirname(__FILE__) . '/../../bootstrap.php';
require_once dirname(__FILE__) . '/../../../../lib/payzen/2.8/sfPayzenPayment_2_8.class.php';

/**
 * Mock event listener to test the setting of vads_trans_id via filtering
 */
class mockEventListener
{

    private $eventCaught = false;

    public function listen(sfEvent $event)
    {
        $this->eventCaught = true;
        return 'filtered_trans_id';
    }

    public function wasEventCaught()
    {
        return $this->eventCaught;
    }
}

$t = new lime_test(null, new lime_output_color());

//->configure()
$t->diag('->configure()');

try
{
    $payment = new sfPayzenPayment_2_8();
    $t->fail('->configure() throws a RuntimeException if a mandatory option is not set');
} catch (RuntimeException $e)
{
    $t->pass('->configure() throws a RuntimeException if a mandatory option is not set');
}

$options = array(
    'vads_amount' => 'amount',
    'vads_site_id' => 'site_id',
    'vads_trans_id' => 'trans_id',
    'certificate' => 'certificate',);

$payment = new sfPayzenPayment_2_8($options);

$t->is($payment->__get('vads_action_mode'), sfPayzenPayment_2_8::VADS_ACTION_MODE_SILENT, '->configure() sets an option to its default value when not given in parameter');

$options = array(
    'vads_amount' => 'amount',
    'vads_site_id' => 'site_id',
    'vads_trans_id' => 'trans_id',
    'certificate' => 'certificate',
    'vads_action_mode' => sfPayzenPayment_2_8::VADS_ACTION_MODE_INTERACTIVE,
);

$payment = new sfPayzenPayment_2_8($options);

$t->is($payment->__get('vads_action_mode'), sfPayzenPayment_2_8::VADS_ACTION_MODE_INTERACTIVE, '->configure() overrides the default value for an option if its given in parameter');


$mockEventListener = new mockEventListener();

$dispatcher = ProjectConfiguration::getActive()->getEventDispatcher();
$dispatcher->connect('sf_payzen_plugin.filter_vads_trans_id', array($mockEventListener, 'listen'));

$options = array(
    'vads_amount' => 'amount',
    'vads_site_id' => 'site_id',
    'vads_trans_id' => 'trans_id',
    'certificate' => 'certificate',
    'vads_action_mode' => sfPayzenPayment_2_8::VADS_ACTION_MODE_INTERACTIVE,
);

$payment = new sfPayzenPayment_2_8($options);

$t->is($mockEventListener->wasEventCaught(), false, '->__construct() if the vads_trans_id is set, no event is sent');


$options = array(
    'vads_amount' => 'amount',
    'vads_site_id' => 'site_id',
    'certificate' => 'certificate',
    'vads_action_mode' => sfPayzenPayment_2_8::VADS_ACTION_MODE_INTERACTIVE,
);

$payment = new sfPayzenPayment_2_8($options);
$t->is($mockEventListener->wasEventCaught(), true, 
        '->__construct() if the vads_trans_id is not set an event is sent for it to be filtered');

$t->is($payment->__get('vads_trans_id'), 'filtered_trans_id', 
        '->__construct() the vads_trans_id equals the value returned by the listener');

$dispatcher->disconnect('sf_payzen_plugin.filter_vads_trans_id', $mockEventListener);