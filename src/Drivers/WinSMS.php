<?php

namespace Elimuswift\SMS\Drivers;

use Ramsey\Uuid\Uuid;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Elimuswift\SMS\DoesNotReceive;
use Elimuswift\SMS\OutgoingMessage;
use Elimuswift\SMS\Contracts\DriverInterface;

/**
 * Send sms messages via africas talking.
 *
 * @author Master Weez
 **/
class WinSMS extends AbstractSMS implements DriverInterface
{
    use DoesNotReceive;

    /**
     * Guzzle HTTP client.
     *
     * @var Client
     */
    protected $client;

    /**
     * WinSMS api endpoint.
     *
     * @var string
     **/
    protected $endpoint = 'https://www.winsms.co.za/api/rest/v1/';

    /**
     * Create a new intance of WinSMS driver.
     *
     * @param Client $client
     **/
    public function __construct($apiKey)
    {
        $headers = [
            'AUTHORIZATION' => $apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
        $this->client = new Client(['base_uri' => $this->endpoint, 'headers' => $headers]);
    }

    /**
     * Send sms message.
     *
     * @return object Elimuswift\SMS\WinSMS
     *
     * @param object $message Elimuswift\SMS\OutgoingMessage
     **/
    public function send(OutgoingMessage $message)
    {
        $body = [
            'message' => $message->composeMessage(),
            'recipients' => $this->prepareContacts($message->getTo()),
            'maxSegments' => ceil(strlen($message->composeMessage()) / 160),
        ];

        return $this->client->post('sms/outgoing/send', ['body' => json_encode($body)]);
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

    /**
     * Prepare message recipients.
     *
     * @param array $contacts
     *
     * @return array
     **/
    protected function prepareContacts(array $contacts)
    {
        return Collection::make($contacts)->transform(function ($value, $key) {
            return [
                'mobileNumber' => $value,
                'clientMessageId' => Uuid::uuid4(),
            ];
        })->toArray();
    }
}
