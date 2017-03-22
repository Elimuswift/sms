<?php

namespace Elimuswift\SMS;

use SimpleSoftwareIO\SMS\DoesNotReceive;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

/**
 * Send sms messages through sematime API.
 *
 * @author Master Weez <wizqydy@gmail.com>
 **/
class Sematime extends AbstractSMS implements DriverInterface
{
    use DoesNotReceive;

    public function __construct($api_key, $username)
    {
        $this->sema = new Sematime\Sematime($api_key, $username);
    }

//end __construct()

    /**
     * Send the sms message.
     *
     * @return GuzzleHttp\Client;
     *
     * @param OutgoingMessage $message
     **/
    public function send(OutgoingMessage $message)
    {
        return $this->sema->sendMessage($message->getTo(), $message->composeMessage());
    }

//end send()

    /**
     * Creates many IncomingMessage objects and sets all of the properties.
     *
     * @param string $rawMessage
     *
     * @return mixed
     */
    protected function processReceive($rawMessage)
    {
        return $rawMessage;
    }

//end processReceive()
}//end class
 // END public class AfricasTalkingDriver
