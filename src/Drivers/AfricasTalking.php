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
     * The gateway for sending SMS via africas talking.
     *
     * @var Gateway
     */
    protected $gateway;

    /**
     * Create a new intance of AfricasTalking driver.
     *
     * @param Gateway $getway Africas talkig Gateway
     **/
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
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
        $options = [
            'from' => $message->getFrom(),
        ];
        
        return $this->gateway->sms->sendMessage($message->getTo(), $message->composeMessage());
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
