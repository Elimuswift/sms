<?php

namespace Elimuswift\SMS\Drivers;

use AfricasTalking\Gateway;
use Elimuswift\SMS\DoesNotReceive;
use Elimuswift\SMS\OutgoingMessage;
use Elimuswift\SMS\Contracts\DriverInterface;
use GuzzleHttp\Psr7\Response;
use Roamtech\Gateway\Client;

/**
 * Send sms messages via Roamtechs Emalify.
 *
 * @author Master Weez
 **/
class EmalifySMS extends AbstractSMS implements DriverInterface
{
    use DoesNotReceive;

    /**
     * The gateway for sending SMS via africas talking.
     *
     * @var Gateway
     */
    protected $gateway;

    public function __construct(Client $gateway)
    {
        //Resolve gateway
        $this->gateway = $gateway;

    }

    /**
     * Send sms message.
     *
     * @param OutgoingMessage $message \Elimuswift\SMS\OutgoingMessage
     *
     * @return Response Guzzle PSR response
     */
    public function send(OutgoingMessage $message)
    {
        $options = [
            'from' => $message->getFrom(),
            'messageId' => $message->getMessageId(),
        ];

        return $this->gateway->sms()->sendMessage(
            $message->composeMessage(),
            $message->getTo(),
            $options
        );
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
