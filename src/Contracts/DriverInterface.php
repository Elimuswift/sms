<?php

namespace Elimuswift\SMS\Contracts;

use Elimuswift\SMS\OutgoingMessage;

interface DriverInterface
{
    /**
     * Sends a SMS message.
     *
     * @param \Elimuswift\SMS\OutgoingMessage $message
     */
    public function send(OutgoingMessage $message);

    /**
     * Checks the server for messages and returns their results.
     *
     * @param array $options
     *
     * @return array
     */
    public function checkMessages(array $options = []);

    /**
     * Gets a single message by it's ID.
     *
     * @param string|int $messageId
     *
     * @return \Elimuswift\SMS\IncomingMessage
     */
    public function getMessage($messageId);

    /**
     * Receives an incoming message via REST call.
     *
     * @param mixed $raw
     *
     * @return \Elimuswift\SMS\IncomingMessage
     */
    public function receive($raw);
}
