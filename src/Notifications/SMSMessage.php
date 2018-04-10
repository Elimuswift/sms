<?php

namespace Elimuswift\SMS\Notifications\Messages;

class SMSMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The data to be passed to the view.
     *
     * @var array
     */
    public $viewData = [];

    /**
     * Create a new message instance.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param string $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the data to be passed to the view message.
     *
     * @param array $data
     *
     * @return $this
     */
    public function viewData(array $data)
    {
        $this->viewData = $data;

        return $this;
    }
}
