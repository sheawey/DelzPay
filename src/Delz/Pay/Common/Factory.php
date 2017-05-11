<?php

namespace Delz\Pay\Common;

use Delz\Pay\Common\Contract\IGateway;
use Delz\Pay\Common\Exception\PayException;

/**
 * 支付工厂类
 *
 * @package Delz\Pay\Common
 */
class Factory
{
    /**
     * @param string $class
     * @return IGateway
     * @throws PayException
     */
    public static function create($class)
    {
        $class = self::getPayClassName($class);

        if (!class_exists($class)) {
            throw new PayException("Class '$class' not found");
        }

        $gateway = new $class();

        if(!$gateway instanceof IGateway) {
            throw new PayException("Class '$class' must be instance of \\Delz\\Pay\\IGateway");
        }

        return $gateway;
    }

    /**
     * \Custom\Gateway  => \Custom\Gateway
     * \Custom_Gateway     => \Custom_Gateway
     * Stripe              => \Delz\Pay\Stripe\Gateway
     * PayPal\Express      => \Delz\Pay\PayPal\ExpressGateway
     * PayPal_Express      => \Delz\Pay\PayPal\ExpressGateway
     *
     * @param string $name
     * @return string
     */
    public static function getPayClassName($name)
    {
        if (0 === strpos($name, '\\')) {
            return $name;
        }

        $name = str_replace('_', '\\', $name);

        if (false === strpos($name, '\\')) {
            $name .= '\\';
        }

        return '\\Delz\\Pay\\' . $name . 'Gateway';
    }
}