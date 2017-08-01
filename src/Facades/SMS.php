<?php

namespace Elimuswift\SMS\Facades\SMS;

use Illuminate\Support\Facades\Facade;

/**
 * Class SMS
 */
class SMS extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sms';
    }
}
