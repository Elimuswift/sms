<?php
namespace Elimuswift\SMS;

use SimpleSoftwareIO\SMS\DoesNotReceive;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

/**
 * Send sms messages via africas talking
 *
 * @package elimuswift/sms
 * @author Master Weez
 **/
 class AfricasTalking extends AbstractSMS implements DriverInterface
{
	use DoesNotReceive;
	
	/**
	 * undocumented function
	 *
	 * @return void
	 * @param sting $api_key Africas talkig apikey
	 * @param sting $username Africas talkig username 
	 * @param sting $from Africas talkig from number 
	 **/
	public function __construct($api_key, $username,$from)
	{
		$this->atsms = new SmsSender($api_key, $username);
		$this->from = $from;
	}

	/**
	 * Send sms message
	 *
	 * @return object Elimuswift\SMS\SmsSender
	 * @param  object $message SimpleSoftwareIO\SMS\OutgoingMessage
	 **/
	public function send(OutgoingMessage $message)
	{
		return $this->atsms->from($this->from)->sendMessage($message->getTo(), $message->composeMessage());
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

} // END public class AfricasTalkingDriver