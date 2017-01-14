<?php
namespace Elimuswift\SMS;

use Exception;

class SmsSender
{
	protected $_apiKey ;
    protected $_username ;
    protected $_method='GET';
    protected $_requestBody;
    protected $_requestUrl;
    protected $_responseBody;
    protected $_responseInfo;
    protected $_headers;
    protected $options;
    protected $from;
    protected $client;

    	//  API URL ENDPOINTS
    const SMS_URL = "https://api.africastalking.com/version1/messaging";
    const VOICE_URL        = 'https://voice.africastalking.com';
	const USER_DATA_URL    = 'https://api.africastalking.com/version1/user';
	const SUBSCRIPTION_URL = 'https://api.africastalking.com/version1/subscription';
	const AIRTIME_URL      = 'https://api.africastalking.com/version1/airtime';

		//	Response Status CODES
    const OK =200;
    const CREATED = 201;
    const UNAUTHORIZED =401;
    const FORBIDDEN =403;
    const BAD_REQUEST =400;
    const NOT_FOUND =404;
    const SERVER_ERROR =500;
	
	public function __construct($apikey, $username)
	{
		$this->client = app('GuzzleHttp\ClientInterface');
		$this->_apiKey= $apikey;
		$this->_username= $username;
		$this->init();
	}
	private function init()
	{ 
		$this->_headers=[
							'Accept'=>'application/json',
							'apiKey'=>$this->_apiKey,
							'content-type'=>'application/x-www-form-urlencoded'
						];
	}
	public function sendMessage(array $to=null, $message=null)
	{
		if(! is_null($to) AND ! is_null($message)):
			$params=[
						'username' => $this->_username,
						'message'    => $message,
			        	'to' => implode(',',$to),
			        	'bulkSMSMode' => 1,
					];
			if(! is_null($this->from)){
				$params['from']	= $this->from;
			}
			if(! is_null($this->options)){
				foreach ( $this->options_ as $key => $value ) {
		  			$params[$key] = $value;
				}
			}

			$this->_requestBody=http_build_query($params, '', '&');
			$this->_requestUrl = self::SMS_URL;
			$this->_method='POST';
			//dd($this);
			return $this->send();
		endif;
		throw new Exception('The recipient or message is missing');
	}
	public function getUserData()
	  {
	  	$this->_method='GET';
	    $this->_requestUrl = self::USER_DATA_URL.'?username='.$this->_username;
	    return $this->send()->UserData;  
	   	 
	   }

	  public function send()
	  {
	  	$response = $this->client->request($this->_method,$this->_requestUrl, [
		  			  'body'=>$this->_requestBody,
		  			  'headers'=>$this->_headers
		  			  ]);
	  	if((int) $response->getStatusCode() == self::OK || $response->getStatusCode() == self::CREATED){
	  		return json_decode($response->getBody());		
	  	}
	  throw new Exception($response->getBody().$response->getStatusCode(), 1);  
	  }
	  public function from($from)
	   {
	   		$this->from = $from;
	   		return $this;
	   } 
	  public function options(Array $options=null)
	  {
	  	 $allowedKeys = [
			    'enqueue',
			    'keyword',
			    'linkId',
			    'retryDurationInHours'
			    ];
		foreach ( $options_ as $key => $value ) {
			if ( in_array($key, $allowedKeys) && strlen($value) > 0 ) {
	  		$this->options[$key] = $value;
			} else {
	  		throw new Exception("Invalid key in options array: ".$key);
			}
      	}
      	return $this;
	  }
	  public function fetchMessages($lastReceivedId_='')
	  {
	    $username = $this->_username;
	    $this->_requestUrl = self::SMS_URL.'?username='.$username.'&lastReceivedId='. intval($lastReceivedId_);
	    
	 	$response = $this->send();
	 	return $response;	         
	  }
	  public function createSubscription($phoneNumber_, $shortCode_, $keyword_)
	  {
	  	
	  	if ( strlen($phoneNumber_) == 0 || strlen($shortCode_) == 0 || strlen($keyword_) == 0 ) {
	      throw new Exception('Please supply phoneNumber, shortCode and keyword');
	    }
	    
	    $params = array(
			    'username'    => $this->_username,
			    'phoneNumber' => $phoneNumber_,
			    'shortCode'   => $shortCode_,
			    'keyword'     => $keyword_
			    );
	    $this->_method = 'POST';
	    $this->_requestUrl  = self::SUBSCRIPTION_URL."/create";
	    $this->_requestBody = http_build_query($params, '', '&');
	    
	    return $this->send();
	  }
	 public function deleteSubscription($phoneNumber_, $shortCode_, $keyword_)
	  {
	    if ( strlen($phoneNumber_) == 0 || strlen($shortCode_) == 0 || strlen($keyword_) == 0 ) {
	      throw new Exception('Please supply phoneNumber, shortCode and keyword');
	    }
	    
	    $params = array(
			    'username'    => $this->_username,
			    'phoneNumber' => $phoneNumber_,
			    'shortCode'   => $shortCode_,
			    'keyword'     => $keyword_
			    );
	    
	    $this->_requestUrl  = self::SUBSCRIPTION_URL."/delete";
	    $this->_requestBody = http_build_query($params, '', '&');
	    
	    $this->_method = 'POST';

	    return $this->send();
	  }
	public function fetchPremiumSubscriptions($shortCode_, $keyword_, $lastReceivedId_ = 0)
	{
		    $username = $this->_username;
		    $this->_requestUrl  = self::SUBSCRIPTION_URL.'?username='.$username.'&shortCode='.$shortCode_;
		    $this->_requestUrl .= '&keyword='.$keyword_.'&lastReceivedId='.intval($lastReceivedId_);
		    
		     return $this->send();
	}
	public function call($from_, $to_)
	{
	    if ( strlen($from_) == 0 || strlen($to_) == 0 ) {
	      throw new Exception('Please supply both from and to parameters');
	    }
	    
	    $params = array(
			    'username' => $this->_username,
			    'from'     => $from_,
			    'to'       => $to_
			    );
	    
	    $this->_requestUrl  = self::VOICE_URL . "/call";
	    $this->_requestBody = http_build_query($params, '', '&');
	    
	    $this->_method = 'POST';
		return $this->send();
	}
	public function getNumQueuedCalls($phoneNumber_, $queueName = null) 
	{  	
	  	$this->_requestUrl = self::VOICE_URL . "/queueStatus";
	  	$params = array(
	  	      "username"     => $this->_username, 
	  	      "phoneNumbers" => $phoneNumber_
	  	     );
	  	$queueName === null ?: $params['queueName'] = $queueName;
	  	$this->_requestBody   = http_build_query($params, '', '&');
	  
	   	$this->_method = 'POST';
		return $this->send();
	}
	public function sendAirtime(Array $recipients) 
	  {
	  	$params = array(
	  	    "username"    => $this->_username, 
	  	    "recipients"  => json_encode($recipients)
	  	   );
	  	$this->_requestUrl  = self::AIRTIME_URL . "/send";
	  	$this->_requestBody = http_build_query($params, '', '&');	  	
	  	$this->_method = 'POST';
		return $this->send();
	  }
}