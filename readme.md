Elimuswift SMS
==============


[![Latest Stable Version](https://poser.pugx.org/elimuswift/sms/v/stable.svg)](https://packagist.org/packages/elimuswift/sms)
[![Latest Unstable Version](https://poser.pugx.org/elimuswift/sms/v/unstable.svg)](https://packagist.org/packages/elimuswift/sms)
[![License](https://poser.pugx.org/elimuswift/sms/license.svg)](https://packagist.org/packages/elimuswift/sms)
[![Total Downloads](https://poser.pugx.org/elimuswift/sms/downloads.svg)](https://packagist.org/packages/elimuswift/sms)

<a id="docs-introduction"></a>
## Introduction
Elimuswift SMS is a package for sending SMS using various SMS providers. This package for [Laravel](http://laravel.com/) adds the capability to send and receive SMS/MMS messages to mobile phones from your web app. The package supports [Africas Talking](https://www.africastalking.com/)


<a id="docs-requirements"></a>
## Requirements

#### Laravel 5
* PHP: >= 5.5
* Guzzle >= 6.0

<a id="docs-configuration"></a>
## Configuration

#### Composer

First, add the Simple SMS package to your `require` in your `composer/json` file:

    "require": {
        "elimuswift/sms": "dev-master"
    }

Next, run the `composer update` command.  This will install the package into your Laravel application.

#### Service Provider

Once you have added the package to your composer file, you will need to register the service provider with Laravel.

```php
	Elimuswift\SMS\Providers\SmsServiceProvider::class,
```

#### Aliases

Finally, register the Facade.

```php
'SMS' => Elimuswift\SMS\Facades\SMS::class,
```

#### API Settings

You must run the following command to save your configuration files to your local app:

     php artisan vendor:publish --provider="Elimuswift\SMS\Providers\SmsServiceProvider"

This will copy the configuration files to your `config` folder.


## Documentation
    - Africas Talkig
 To enable the AfricasTalking driver just change config file to:

```php
'driver' => env('SMS_DRIVER', 'africastalking'),
'africastalking' => [
        'api_key' => env('AT_API_KEY', 'africastalking.api_key'),
        'username' => env('AT_USERNAME', 'africastalking.username'),
    ]
```  

### Sending an SMS

Now let us send an SMS notification
```php

use Elimuswift\SMS\Facades\SMS;

SMS::send('My first SMS message', [], function ($sms) {
	$sms->to('07xxxxxxxx');
}); 
```

Sending to multiple Contacts 

```php

use Elimuswift\SMS\Facades\SMS;
$contacts = ['0711xxxxxx', '0722xxxxxx', '0701xxxxxx'];

SMS::send('My first SMS message', [], function ($sms) use($contacts) {
	return array_map(function ($to) use($sms) {
		$sms->to($to);
	}, $contacts);	
}); 

```