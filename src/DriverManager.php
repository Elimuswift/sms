<?php

namespace Elimuswift\SMS;

use SimpleSoftwareIO\SMS\DriverManager as Manager;

/**
  * Create driver instances defined in config file.
  **/
 class DriverManager extends Manager
 {
     /**
     * create africastalking gateway driver.
     *
     * @return Elimuswift\SMS\AfricasTalking
     **/
    public function createAfricastalkingDriver()
    {
        $config = $this->app['config']->get('sms.africastalking', []);

        $provider = new AfricasTalking(
            $config['api_key'],
            $config['username'],
            null
        );

        return $provider;
    }

    /**
     * Create sematime driver.
     *
     * @return Elimuswift\SMS\Sematime
     **/
    public function createSematimeDriver()
    {
        $config = $this->app['config']->get('sms.sematime', []);

        $provider = new Sematime(
            $config['api_key'],
            $config['username']
        );

        return $provider;
    }
 } // END public class DriverManager
