Elimuswift SMS
==========


[![Latest Stable Version](https://poser.pugx.org/elimuswift/sms/v/stable.svg)](https://packagist.org/packages/elimuswift/sms)
[![Latest Unstable Version](https://poser.pugx.org/elimuswift/sms/v/unstable.svg)](https://packagist.org/packages/elimuswift/sms)
[![License](https://poser.pugx.org/elimuswift/sms/license.svg)](https://packagist.org/packages/elimuswift/sms)
[![Total Downloads](https://poser.pugx.org/elimuswift/sms/downloads.svg)](https://packagist.org/packages/elimuswift/sms)

<a id="docs-introduction"></a>
## Introduction



<a id="docs-requirements"></a>
## Requirements

#### Laravel 5
* PHP: >= 5.6.4
* Guzzle >= 6.0

<a id="docs-configuration"></a>
## Configuration

#### Composer

First, add the Simple SMS package to your `require` in your `composer/json` file:





#### Africas Talking

```php
'driver' => env('SMS_DRIVER', 'africastalking'),
'africastalking' => [
        'api_key' => env('AT_API_KEY', 'africastalking.api_key'),
        'username' => env('AT_USERNAME', 'africastalking.username'),
    ]
```  

Documentation for Simple SMS can be found on this [website.](https://www.simplesoftware.io/docs/simple-sms)
