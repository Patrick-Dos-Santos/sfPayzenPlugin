<?php

require_once dirname(__FILE__).'/../../bootstrap.php';
require_once dirname(__FILE__).'/../../../../lib/payzen/base/sfPayzenPayment.class.php';
require_once dirname(__FILE__).'/../../../../lib/payzen/2.8/sfPayzenPayment_2_8.class.php';

$t = new lime_test(1, new lime_output_color());

$t->is(true, true);
