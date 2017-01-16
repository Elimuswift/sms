Elimuswift SMS
==========


[![Latest Stable Version](https://poser.pugx.org/elimuswift/sms/v/stable.svg)](https://packagist.org/packages/elimuswift/sms)
[![Latest Unstable Version](https://poser.pugx.org/elimuswift/sms/v/unstable.svg)](https://packagist.org/packages/elimuswift/sms)
[![License](https://poser.pugx.org/elimuswift/sms/license.svg)](https://packagist.org/packages/elimuswift/sms)
[![Total Downloads](https://poser.pugx.org/elimuswift/sms/downloads.svg)](https://packagist.org/packages/elimuswift/sms)

<a id="docs-introduction"></a>
## Introduction
Elimuswift SMS is a wrappper for [simplesoftwareio/simple-sms](https://github.com/simplesoftwareio/simple-sms). This package for [Laravel](http://laravel.com/) adds the capability to send and receive SMS/MMS messages to mobile phones from your web app. It currently supports a free way to send SMS messages through E-Mail gateways provided by the wireless carriers. The package also supports 11 paid services, [Africas Talking,](https://www.africastalking.com/) [Call Fire,](https://www.callfire.com/) [EZTexting,](https://www.eztexting.com) [FlowRoute,](https://www.flowroute.com/) [LabsMobile,](http://www.labsmobile.com) [Mozeo,](https://www.mozeo.com/) [Nexmo,](https://www.nexmo.com/) [Plivo,](https://www.plivo.com/) [Sematime,](https://www.sematime.com/)[Twilio,](https://www.twilio.com) [Zenvia](http://www.zenvia.com.br/)


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
        "elimuswift/sms": "1.0.*"
    }

Next, run the `composer update` command.  This will install the package into your Laravel application.

#### Service Provider

Once you have added the package to your composer file, you will need to register the service provider with Laravel.

Add `Elimuswift\SMS\Providers\SmsServiceProvider::class` in your `config/app.php` configuration file within the `providers` array.

#### Aliases

Finally, register the Facade.

Add `'SMS' => SimpleSoftwareIO\SMS\Facades\SMS::class` in your `config/app.php` configuration file within the `aliases` array.

#### API Settings

You must run the following command to save your configuration files to your local app:

     php artisan vendor:publish --provider="Elimuswift\SMS\Providers\SmsServiceProvider"

This will copy the configuration files to your `config` folder.


## Documentation
This package adds two more SMS drivers 
    - Africas Talkig
    - Sematime
 To enable either of these drivers just change config file to:

 #### Sematime

 ```php
 'driver' => env('SMS_DRIVER', 'sematime'),
 'sematime' => [
        'api_key' => env('SEMATIME_SECRET', 'sematime.api_key'),
        'username' => env('SEMATIME_USERNAME', 'sematime.username'),
    ]
```

#### Africas Talking

```php
'driver' => env('SMS_DRIVER', 'africastalking'),
'africastalking' => [
        'api_key' => env('AT_API_KEY', 'africastalking.api_key'),
        'username' => env('AT_USERNAME', 'africastalking.username'),
    ]
```  

Documentation for Simple SMS can be found on this [website.](https://www.simplesoftware.io/docs/simple-sms)
