<?php

namespace Elimuswift\SMS;

use AfricasTalking\Gateway;
use Illuminate\Support\Manager;

/**
  * Create driver instances defined in config file.
  **/
class DriverManager extends Manager
{
     /**
     * Get the default sms driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['sms.driver'];
    }

    /**
     * Set the default sms driver name.
     *
     * @param string $name
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['sms.driver'] = $name;
    }

    /**
     * Create an instance of the Log driver.
     *
     * @return LogSMS
     */
    protected function createLogDriver()
    {
        $provider = new Drivers\LogSMS($this->app['log']);

        return $provider;
    }

    /**
     * create africastalking gateway driver.
     *
     * @return Elimuswift\SMS\AfricasTalking
     **/
    public function createAfricastalkingDriver()
    {
        $config = $this->app['config']->get('sms.africastalking', []);
        $adapter = new Gateway($config['username'], $config['api_key']);
        
        return new Drivers\AfricasTalking($adapter);
    }
}
