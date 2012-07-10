<?php

/**
 * sfPayzenPlugin configuration.
 * 
 * @package    sfPayzenPlugin
 * @subpackage config
 * @author     Patrick Dos Santos <patrick.dos-santos [at] solution-interactive.com>
 * @version    SVN: $Id: sfPayzenPluginConfiguration.class.php 25546 2009-12-17 23:27:55Z Jonathan.Wage $
 */
class sfPayzenPluginConfiguration extends sfPluginConfiguration
{
    /**
     * @see sfPluginConfiguration
     */
    public function initialize()
    {
        $this->dispatcher->connect('routing.load_configuration', array('sfPayzenRouting', 'listenToRoutingLoadConfigurationEvent'));
    }

}