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
####  Africas Talkig

To enable the AfricasTalking driver just change config file to:

```php
'driver' => env('SMS_DRIVER', 'africastalking'),
'africastalking' => [
        'api_key' => env('AT_API_KEY', 'africastalking.api_key'),
        'username' => env('AT_USERNAME', 'africastalking.username'),
    ]
``` 
<a id="docs-nexmo-driver"></a>
#####  Nexmo Driver

This driver sends messages through the [Nexmo](https://www.nexmo.com/product/messaging/) messaging service.  It is very reliable and capable of sending messages to mobile phones worldwide.
```php
    return [
        'driver' => 'nexmo',
        'from' => 'Company Name',
        'nexmo' => [
            'api_key'       => 'Your Nexmo API Key',
            'api_secret'    => 'Your Nexmo API Secret',
            'encoding'      => 'unicode', // Can be `unicode` or `gsm`
        ]
    ]; 
```

<a id="docs-twilio-driver"></a>
#### Twilio Driver

This driver sends messages through the [Twilio](https://www.twilio.com/sms) messaging service.  It is very reliable and capable of sending messages to mobile phones worldwide.

```php
    return [
        'driver' => 'twilio',
        'from' => '+15555555555', //Your Twilio Number in E.164 Format.
        'twilio' => [
            'account_sid' => 'Your SID',
            'auth_token' => 'Your Token',
            'verify' => true,  //Used to check if messages are really coming from Twilio.
        ]
    ];
```
<a id="docs-send-sms"></a>
#### Sending an SMS

With eerything set up the right way sending an SMS notification would be as simple as:

```php

use Elimuswift\SMS\Facades\SMS;

SMS::send('My first SMS message', [], function ($sms) {
	$sms->to('07xxxxxxxx');
}); 
```
#### Multiple Recipients

Sending to multiple Contacts 

```php

use Elimuswift\SMS\Facades\SMS;
$contacts = ['0711xxxxxx', '0722xxxxxx', '0701xxxxxx'];

SMS::send('My bulk SMS notification', [], function ($sms) use($contacts) {
	return array_map(function ($to) use($sms) {
		$sms->to($to);
	}, $contacts);	
}); 

```

#### Send a Blade View

You can also use a view to send the sms notification, just pass the name of the view as the first argument to the `send()` method, the second parameter is the data to be passed to the view.
```php
use App\Order;

$order = Order::with('user')->first();

SMS::send('sms.order-shiped', compact('order'), function($sms) use($order) {
    $sms->to($order->user->phone_number);
});
```

### Using Laravel Notifications

The package comes with a notification chanel for sending SMS messages using laravels notification system. To get stated add `routeNotificationForSMS()` method in your notifiable. this method should return the notifiables's phone number.

```php
    /**
     * Get the notification identifier for SMS.
     *
     * @return string
     */
    public function routeNotificationForSMS()
    {
        return $this->attributes['phone_number'];
    }
``` 

#### Sending The Notification
Now you can use the channel in your `via()` method inside the notification:

```php
use Elimuswift\SMS\Chennels\SMSChannel;
use Elimuswift\SMS\Notifications\SMSMessage;
use Illuminate\Notifications\Notification;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [SMSChannel::class];
    }

    public function toSms($notifiable)
    {
        return (new SMSMessage())
            ->content("Your {$notifiable->service} account was approved!");
    }
}
```
You can also send a notification as a blade view.

```php

public function toSms($notifiable)
{
    return (new SMSMessage('path.to.view'))
         ->viewData(['foo' => 'Bar', 'baaz' => 'blah']);
}

```

