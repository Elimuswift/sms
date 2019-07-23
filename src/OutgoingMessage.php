<?php

namespace Elimuswift\SMS;

use Illuminate\View\Factory;
use InvalidArgumentException;

class OutgoingMessage
{
    /**
     * The Illuminate view factory.
     *
     * @var Factory
     */
    protected $views;

    /**
     * The view file to be used when composing a message.
     *
     * @var string
     */
    protected $view;

    /**
     * The data that will be passed into the Illuminate View Factory.
     *
     * @var array
     */
    protected $data;

    /**
     * The number messages are being sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Array of numbers a message is being sent to.
     *
     * @var array
     */
    protected $to;

    /**
     * User Message Id .
     *
     * @var bool
     */
    protected $messageId = null;

    /**
     * Array of attached images.
     *
     * @var array
     */
    protected $attachImages = [];

    /**
     * Create a OutgoingMessage Instance.
     *
     * @param Factory $views
     */
    public function __construct(Factory $views)
    {
        $this->views = $views;
    }

    /**
     * Composes a message.
     *
     * @return Factory|string
     */
    public function composeMessage()
    {
        // Attempts to make a view.
        // If a view can not be created; it is assumed that simple message is passed through.
        try {
            return $this->views->make($this->view, $this->data)->render();
        } catch (InvalidArgumentException $e) {
            return $this->view;
        }
    }

    private static function uniqId($length = 13)
    {
        $bytes = openssl_random_pseudo_bytes(ceil($length / 2));

        return substr(bin2hex($bytes), 0, $length);
    }

    /**
     * Sets the numbers messages will be sent from.
     *
     * @param string $number Holds the number that messages
     */
    public function from($number)
    {
        $this->from = $number;
    }

    /**
     * Gets the from address.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Sets the numbers messages will be sent from.
     *
     * @param string $messageId Holds the message Id for  that messages
     */
    public function messageId($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * Gets the message id for the message.
     *
     * @return string
     */
    public function getMessageId()
    {
        return $this->messageId ?: static::uniqId(17);
    }

    /**
     * Sets the to addresses.
     *
     * @param string $number Holds the number that a message will be sent to.
     * @param string $carrier The carrier the number is on.
     *
     * @return $this
     */
    public function to($number, $carrier = null)
    {
        $this->to[] = [
            'number' => $number,
            'carrier' => $carrier,
        ];

        return $this;
    }

    /**
     * Returns the To addresses without the carriers.
     *
     * @return array
     */
    public function getTo()
    {
        $numbers = [];
        foreach ($this->to as $to) {
            $numbers[] = $to['number'];
        }

        return $numbers;
    }

    /**
     * Returns all numbers that a message is being sent to and includes their carriers.
     *
     * @return array An array with numbers and carriers
     */
    public function getToWithCarriers()
    {
        return $this->to;
    }

    /**
     * Sets the view file to be loaded.
     *
     * @param string $view The desired view file
     */
    public function view($view)
    {
        $this->view = $view;
    }

    /**
     * Sets the data for the view file.
     *
     * @param array $data An array of values to be passed to the View Factory.
     */
    public function data($data)
    {
        $this->data = $data;
    }

    /**
     * Returns the current view file.Returns.
     *
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Returns the view data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
