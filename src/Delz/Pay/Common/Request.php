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
    /**
     * @var array
     */
    protected $parameters = [];

    public function __construct(array $parameters= [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getParameter($key)
    {
        if ($this->hasParameter($key)) {
            return $this->parameters[$key];
        }

        return null;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasParameter($key)
    {
        return isset($this->parameters[$key]);
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