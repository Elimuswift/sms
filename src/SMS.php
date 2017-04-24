<?php

namespace Elimuswift\SMS;

use Illuminate\Container\Container;
use SimpleSoftwareIO\SMS\SMS as BaseSMS;
use SimpleSoftwareIO\SMS\Drivers\DriverInterface;

class SMS extends BaseSMS
{
    /**
     * The Driver Interface instance.
     *
     * @var \SimpleSoftwareIO\SMS\Drivers\DriverInterface
     */
    protected $driver;

    /**
     * The IOC Container.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    public function __construct(DriverInterface $driver)
    {
        parent::__construct($driver);
    }
}
