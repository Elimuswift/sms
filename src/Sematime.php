<?php
namespace Elimuswift\SMS;

use SimpleSoftwareIO\SMS\DoesNotReceive;
use SimpleSoftwareIO\SMS\OutgoingMessage;
use SimpleSoftwareIO\SMS\Drivers\AbstractSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

/**
 * undocumented class
 *
 * @package default
 * @author 
 **/
 class Sematime extends AbstractSMS implements DriverInterface
{
	use DoesNotReceive;
	 
	public function __construct($api_key, $username)
	{
		$this->sema = new Sematime\Sematime($api_key, $username);
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function send(OutgoingMessage $message)
	{
		return $this->sema->sendMessage($message->getTo(), $message->composeMessage());
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