<?php

namespace Delz\Pay\Common;

use Delz\Pay\Common\Contract\IRequest;
use Delz\Pay\Common\Exception\InvalidRequestException;

/**
 * 支付请求抽象类
 *
 * @package Delz\Pay\Common
 */
abstract class Request implements IRequest
{
    use ParameterAware;

    public function __construct(array $parameters= [])
    {
        $this->parameters = $parameters;
    }

    /**
     * 判断是否是空值，如果是，抛出异常
     */
    protected function checkRequired()
    {
        foreach (func_get_args() as $key) {
            $value = $this->getParameter($key);
            if (is_null($value)) {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }
}