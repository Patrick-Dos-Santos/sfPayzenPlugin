<?php

class sfPayzenComponents extends sfComponents
{
    public function executePayzenForm($request)
    {
        //Merging the given options with those in the app.yml
        $yamlOptions = sfConfig::get('app_sf_payzen_plugin_options');
        if ($yamlOptions) {
            $this->options = array_merge($yamlOptions, $this->options);
        }

        if (!$this->payzen_version) {
            throw new sfException('SfPayzenComponents : You must set the payzen_version');
        }

        //Instanciating the sfPayzenPayment builder for the given version
        $class = 'sfPayzenPayment_' . $this->payzen_version;
        if (!class_exists($class)) {
            throw new sfException(sprintf('SfPayzenComponents : Unknown %s class. Please check the sfPayzenPlugin documentation for more information', $class));
        }
        $payment = new $class($this->options);
        $this->form = new sfPayzenPaymentForm($payment);
    }
}