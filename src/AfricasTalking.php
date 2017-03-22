<?php

namespace Elimuswift\SMS;

use SimpleSoftwareIO\SMS\DoesNotReceive;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

/**
 * Send sms messages via africas talking.
 *
 * @author Master Weez
 **/
class AfricasTalking extends AbstractSMS implements DriverInterface
{
    use DoesNotReceive;

    /**
     * Create a new intance of AfricasTalking driver.
     *
     * @param string $api_key  Africas talkig apikey
     * @param string $username Africas talkig username
     * @param string $from     Africas talkig from number
     **/
    public function __construct($api_key, $username, $from)
    {
        $this->atsms = new SmsSender($api_key, $username);
        $this->from = $from;
    }

//end __construct()

    /**
     * Send sms message.
     *
     * @return object Elimuswift\SMS\SmsSender
     *
     * @param object $message SimpleSoftwareIO\SMS\OutgoingMessage
     **/
    public function send(OutgoingMessage $message)
    {
        return $this->atsms->from($this->from)->sendMessage($message->getTo(), $message->composeMessage());
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
