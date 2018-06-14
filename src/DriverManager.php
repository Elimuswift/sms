<?php

namespace Elimuswift\SMS;

use GuzzleHttp\Client;
use AfricasTalking\Gateway;
use Illuminate\Support\Manager;
use Twilio\Rest\Client as Twilio;
use Elimuswift\SMS\Drivers\NexmoSMS;
use Elimuswift\SMS\Drivers\TwilioSMS;
use Elimuswift\SMS\Drivers\WinSMS;

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
     * create africastalking gateway driver.
     *
     * @return Elimuswift\SMS\AfricasTalking
     **/
    public function createAfricastalkingDriver()
    {
        $config = $this->app['config']->get('sms.africastalking', []);
        $adapter = new Gateway($config['username'], $config['api_key'], $config['sandbox']);

        return new Drivers\AfricasTalking($adapter);
    }

    /**
     * Create an instance of the nexmo driver.
     *
     * @return NexmoSMS
     */
    protected function createNexmoDriver()
    {
        $config = $this->app['config']->get('sms.nexmo', []);
        $provider = new NexmoSMS(
            new Client(),
            $config['api_key'],
            $config['api_secret']
        );

        return $provider;
    }

    /**
     * Create an instance of the Twillo driver.
     *
     * @return TwilioSMS
     */
    protected function createTwilioDriver()
    {
        $config = $this->app['config']->get('sms.twilio', []);

        return new TwilioSMS(
            new Twilio($config['account_sid'], $config['auth_token']),
            $config['auth_token']
        );
    }

    /**
     * Create an instance of the WinSMS driver.
     *
     * @return \Elimuswift\SMS\Drivers\WinSMS
     */
    protected function createWinsmsDriver()
    {
        $config = $this->app['config']->get('sms.winsms', []);

        return new WinSMS($config['api_key']);
    }
}
