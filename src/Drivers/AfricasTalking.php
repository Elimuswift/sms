<?php

namespace Elimuswift\SMS\Drivers;

use AfricasTalking\Gateway;
use Elimuswift\SMS\DoesNotReceive;
use Elimuswift\SMS\OutgoingMessage;
use Elimuswift\SMS\Contracts\DriverInterface;

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
    public function __construct(Gateway $gateway)
    {
        $this->atsms = $gateway;
    }

    /**
     * Send sms message.
     *
     * @return object Elimuswift\SMS\AfricasTalking
     *
     * @param object $message Elimuswift\SMS\OutgoingMessage
     **/
    public function send(OutgoingMessage $message)
    {
        return $this->atsms->sms->sendMessage($message->getTo(), $message->composeMessage());
    }


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
}
