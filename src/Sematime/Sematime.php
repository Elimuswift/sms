<?php

namespace Elimuswift\SMS\Sematime;

/**
 * SendSMS With SemaTime API.
 *
 * @author    The Weezqyd
 *          wizqydy@gmail.com
 * @copyright Elimuswift Inc
 *
 *  Copyright (c) 2016, Elimuswift Inc.
 *       All rights reserved.
 */
class Sematime
{
    private $_apiKey;
    private $_userid;
    private $_requestBody;
    private $_requestUrl;

    protected $_method = 'GET';
    private $SMS_URL = 'http://api.sematime.com/v1/{userId}/messages';
    private $URL = 'http://api.sematime.com/v1/{userId}';

    private $OK = 200;
    private $CREATED = 201;
    private $UNAUTHORIZED = 401;
    private $FORBIDDEN = 403;
    private $BAD_REQUEST = 400;
    private $NOT_FOUND = 404;
    private $SERVER_ERROR = 500;

    const Debug = true;

    public function __construct($apikey, $username)
    {
        $this->client = app('GuzzleHttp\ClientInterface');
        $this->_apiKey = $apikey;
        $this->_username = $username;
        $this->boot();
    }

//end __construct()

    /**
     * undocumented function.
     *
     * @author
     **/
    private function boot()
    {
        $this->_headers = [
                           'apiKey' => $this->_apiKey,
                           'content-type' => 'application/json',
                          ];
    }

//end boot()

    public function sendMessage($to_, $message_, array $options_ = array())
    {
        if (count($to_) == 0 || strlen($message_) == 0) {
            throw new SematimeAPIException('No recipients found or message is empty');
        }

        $params = [
                              'message' => $message_,
                              'recipients' => implode(',', $to_),
                             ];
        $this->_requestUrl = str_replace('{userId}', $this->_userid, $this->SMS_URL);
        $this->_requestBody = json_encode($params);

        $this->_method = 'POST';
        $response = $this->send();

        return json_decode($response->getBody());
    }

//end sendMessage()

    public function send()
    {
        $response = $this->client->request(
            $this->_method,
            $this->_requestUrl,
            [
             'body' => $this->_requestBody,
             'headers' => $this->_headers,
            ]
        );
        if ((int) $response->getStatusCode() == $this->OK || $response->getStatusCode() == $this->CREATED) {
            return json_decode($response->getBody());
        }

        throw new SematimeAPIException($response->getBody().$response->getStatusCode(), 1);
    }

//end send()
}//end class
