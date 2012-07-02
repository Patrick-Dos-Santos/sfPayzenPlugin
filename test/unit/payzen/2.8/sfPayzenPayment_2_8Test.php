<?php

require_once dirname(__FILE__) . '/../../bootstrap.php';
require_once dirname(__FILE__) . '/../../../../lib/payzen/2.8/sfPayzenPayment_2_8.class.php';

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