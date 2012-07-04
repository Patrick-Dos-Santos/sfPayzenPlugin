<?php

/**
 * sfPayzenPaymentReturn is the base class for all payzen payment returns
 *
 * @package    sfPayzenPaymentPlugin
 * @subpackage payzen
 * @author     Patrick Dos Santos <patrick.dos-santos@solution-interactive.com>
 */
abstract class sfPayzenPaymentReturn
{

    protected
            $payment = null,
            $fields = array(),
            $validatorSchema = null,
            $errorSchema = null;

    public function __construct(sfPayzenPayment $payment, $fields = array())
    {
        $this->validatorSchema = new sfValidatorSchema();
        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        $this->payment = $payment;

        $this->configure($fields);
        
        $this->fields = array_merge($this->fields, $fields);
        $this->validate();


        ProjectConfiguration::getActive()
                ->getEventDispatcher()
                ->notify(new sfEvent($this, 'sf_payzen_plugin.new_payment'));
    }

    public function validate()
    {
        $this->validatorSchema->clean($this->fields);
    }

    /**
     * Allows the child classes to be configured
     * @param array $options An array of options 
     */
    public function configure($fields = array())
    {
        
    }

    /**
     * Adds an option
     * @param string $name The option's name
     * @param mixed $value The option's value
     */
    public function addField($name, $value = null)
    {
        $this->fields[$name] = $value;
    }

    /**
     * Generates the signature for the current payment.
     *
     * To calculate the signature all the fields starting with "vads" are sorted
     * in alphabetical order. Each fields' value is added to a string followed 
     * by a +.
     * The Payzen certificate is also added at the end of the string.
     * 
     * Example :
     * 
     * with the fields vads_a = 'a', vads_b = 'b', vads_c = 'c',
     * and certificate = 'my_certificate', the string would be:
     *
     * 'a+b+c+my_certificate'
     * 
     * The actual signature is encrypted in sha1
     * 
     * @return string The signature encrypted in sha1
     */
    public function getSignature()
    {
        $columns = $this->getVadsArray();

        $signatureContent = '';

        //Adding each 'vads' field and its value separated by '+'
        foreach ($columns as $key => $value)
        {
            if (substr($key, 0, 5) == 'vads_')
            {
                $signatureContent .= $value . "+";
            }
        }

        //Adding certificate at the end of the signature
        $signatureContent .= $this->options['certificate'];
        return sha1($signatureContent);
    }

    /**
     * Returns this instance as an array
     * 
     * @return array An array of set values
     */
    public function toArray()
    {
        $a = array();
        foreach ($this->options as $column => $value)
        {
            if (null != $value)
            {
                $a[$column] = $value;
            }
        }
        return $a;
    }

    /**
     * Gets the vads options sorted
     * @return array An array of vads options sorted 
     */
    public function getVadsArray()
    {
        $vadsArray = $this->toArray();
        ksort($vadsArray);
        foreach ($vadsArray as $key => $value)
        {
            if (substr($key, 0, 5) !== 'vads_')
            {
                unset($vadsArray[$key]);
            }
        }
        return $vadsArray;
    }

    /**
     * Magic method for getters.
     * @param string $name The name of the value to get
     * @throws InvalidArgumentException if there is no method and no options for the given name
     * @return mixed Results of the "get" function if it exists. Otherwise returns the value in the options array
     */
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter))
        {
            return call_user_func(array($this, $getter));
        }
        if (!array_key_exists($name, $this->options))
        {
            throw new InvalidArgumentException(sprintf('The %s option is not supported', $name));
        }
        return $this->options[$name];
    }

    /**
     * Magic method for setters
     * @param string $name The name of the value to set
     * @param mixed $value The value to set
     * @throws InvalidArgumentException if there is no method and no options for the given name
     */
    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter))
        {
            call_user_func(array($this, $setter), $value);
        } else
        {
            if (!array_key_exists($name, $this->options))
            {
                throw new InvalidArgumentException(sprintf('The %s option is not supported', $name));
            }
            $this->options[$name] = $value;
        }
    }

    public function addMatchPaymentOrDefaultValidator($fieldName, $defaultValidator, $validatorOptions = array())
    {
        try
        {
            //if field has been set in the payment, the returned value must match
            $field = $this->payment->__get($fieldName);
            $validatorOptions = array_merge($validatorOptions, array('value' => $field));
            $this->validatorSchema[$fieldName] = new sfValidatorEqual($validatorOptions);
        } catch (InvalidArgumentException $e)
        {
            //else field is validated
            $this->validatorSchema[$fieldName] = $defaultValidator;
        }
    }
}