<?php

require_once dirname(__FILE__).'/../../bootstrap.php';
require_once dirname(__FILE__).'/../../../../lib/payzen/base/sfPayzenPaymentForm.class.php';

$t = new lime_test(1, new lime_output_color());

$t->is(true, true);