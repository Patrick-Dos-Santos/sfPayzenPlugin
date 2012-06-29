<?php

/**
 * sfPayzenPayment is the base class for all sfPayzenPayment versions
 *
 * @package    sfPayzenPaymentPlugin
 * @subpackage payzen
 * @author     Patrick Dos Santos <patrick.dos-santos@solution-interactive.com>
 */
abstract class sfPayzenPayment
{

    protected
            $requiredOptions = array(),
            $options = array(),
            $payzenApiVersion;

    /**
     * sfPayzenPayment is the base class for all Payzen payment
     * 
     * @param array $options An array of options
     * @throws sfException When the version is not set in the options
     * @throws InvalidArgumentException When an option is invalid
     * @throws RuntimeException When missing a mandatory option
     */
    public function __construct($options = array())
    {
        $this->addRequiredOption('certificate');
        $this->configure($options);

        if (!$this->payzenApiVersion)
        {
            throw new sfException('sfPayzenPayment : you must set the version in the child builder');
        }

        $currentOptionKeys = array_keys($this->options);
        $optionKeys = array_keys($options);

        // check option names
        if ($diff = array_diff($optionKeys, array_merge($currentOptionKeys, $this->requiredOptions)))
        {
            throw new InvalidArgumentException(sprintf('%s does not support the following options: \'%s\'.', get_class($this), implode('\', \'', $diff)));
        }

        // check required options
        if ($diff = array_diff($this->requiredOptions, array_merge($currentOptionKeys, $optionKeys)))
        {
            throw new RuntimeException(sprintf('%s requires the following options: \'%s\'.', get_class($this), implode('\', \'', $diff)));
        }

        $this->options = array_merge($this->options, $options);

        ProjectConfiguration::getActive()
                ->getEventDispatcher()
                ->notify(new sfEvent($this, 'sf_payzen_plugin.new_payment'));
    }

    /**
     * Allows the child classes to be configured
     * @param array $options An array of options 
     */
    public function configure($options = array())
    {
        
    }

    /**
     * Adds an option
     * @param string $name The option's name
     * @param mixed $value The option's value
     */
    public function addOption($name, $value = null)
    {
        $this->options[$name] = $value;
    }

    /**
     * Adds a mandatory option
     * @param string $name The option name
     */
    public function addRequiredOption($name)
    {
        $this->requiredOptions[] = $name;
    }

    /**
     * Returns an array of required options
     * @return array The required option 
     */
    public function getRequiredOptions()
    {
        return $this->requiredOptions;
    }
    
    /**
     * Sets the payzen API version
     * @param string $version The Payzen API version 
     */
    public function setPayzenApiVersion($version)
    {
        $this->payzenApiVersion = $version;
    }
    
    /**
     * Gets the payzen API version
     * @return string The payzen API version 
     */
    public function getPayzenApiVersion()
    {
        return $this->payzenApiVersion;
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
        $columns = $this->toArray();
        ksort($columns);

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

}