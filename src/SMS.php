<?php

namespace Elimuswift\SMS;

use Closure;
use Elimuswift\SMS\Contracts\DriverInterface;
use Illuminate\Contracts\Foundation\Application;

class SMS
{
    /**
     * The Driver Interface instance.
     *
     * @var Drivers\DriverInterface
     */
    protected $driver;

    /**
     * The IOC Container.
     *
     * @var Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The global from address.
     *
     * @var string
     */
    protected $from;

    /**
     * Creates the SMS instance.
     *
     * @param DriverInterface $driver
     */
    public function __construct(DriverInterface $driver, Application $app)
    {
        $this->driver = $driver;
        $this->app = $app;
    }

    /**
     * Changes the set SMS driver.
     *
     * @param $driver
     */
    public function driver($driver)
    {
        $this->app->extend('sms.sender', function ($sender) use ($driver) {
            return (new DriverManager($this->app))->driver($driver);
        });
        $this->driver = $this->app['sms.sender'];
    }

    /**
     * Send a SMS.
     *
     * @param string $view the desired view
     * @param array $data the data that needs to be passed into the view
     * @param Closure $callback the methods that you wish to fun on the message
     * @param Closure|null $responseCallback
     *
     * @return OutgoingMessage the outgoing message that was sent
     */
    public function send($view, $data, $callback, Closure $responseCallback = null)
    {
        $data['message'] = $message = $this->createOutgoingMessage();

        //We need to set the properties so that we can later pass this onto the Illuminate Mailer class if the e-mail gateway is used.
        $message->view($view);
        $message->data($data);

        call_user_func($callback, $message);
        $response = $this->driver->send($message);

        return $this->runCallbacks($response, $responseCallback);
    }

    /**
     * Run callbacks
     *
     * @param $payload
     * @param $callback
     * @return mixed
     */
    protected function runCallbacks($payload, $callback)
    {
        if (is_callable($callback)) {
            return $callback($payload);
        }
        return $payload;
    }

    /**
     * Creates a new Message instance.
     *
     * @return OutgoingMessage
     */
    protected function createOutgoingMessage()
    {
        $message = new OutgoingMessage($this->app['view']);

        //If a from address is set, pass it along to the message class.
        if (isset($this->from)) {
            $message->from($this->from);
        }

        return $message;
    }

    /**
     * Sets the IoC app.
     *
     * @param Container $app
     */
    public function setContainer(Container $app)
    {
        $this->app = $app;
    }

    /**
     * Sets the number that message should always be sent from.
     *
     * @param $number
     */
    public function alwaysFrom($number)
    {
        $this->from = $number;
    }

    /**
     * Receives a SMS via a push request.
     *
     * @return IncomingMessage
     */
    public function receive()
    {
        //Passes all of the request onto the driver.
        $raw = $this->app['Illuminate\Support\Facades\Input'];

        return $this->driver->receive($raw);
    }

    /**
     * Queries the provider for a list of messages.
     *
     * @param array $options The options to pass onto a provider.  See each provider for a list of options.
     *
     * @return array returns an array of IncomingMessage objects
     */
    public function checkMessages(array $options = [])
    {
        return $this->driver->checkMessages($options);
    }

    /**
     * Gets a message by it's ID.
     *
     * @param $messageId the requested messageId
     *
     * @return IncomingMessage
     */
    public function getMessage($messageId)
    {
        return $this->driver->getMessage($messageId);
    }

    /**
     * Get the current diver .
     *
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }
}
