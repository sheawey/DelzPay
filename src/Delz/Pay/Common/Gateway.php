<?php

namespace Delz\Pay\Common;

use Delz\Pay\Common\Contract\IGateway;
use Delz\Pay\Common\Contract\IRequest;
use Delz\Pay\Common\Exception\PayException;

/**
 * 支付网关抽象类
 *
 * @package Delz\Pay\Common
 */
abstract  class Gateway implements IGateway
{
    /**
     * 网关配置参数
     *
     * @var array
     */
    protected $parameters = [];

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
     * @param string $class
     * @param array $parameters
     * @return IRequest
     */
    protected function createRequest($class, array $parameters= [])
    {
        $parameters = array_merge($this->parameters, $parameters);
        $request = new $class($parameters);

        return $request;
    }

    /**
     * 发起支付请求
     *
     * @param array $parameters
     * @return IRequest
     * @throws PayException
     */
    public function purchase(array $parameters = [])
    {
        throw new PayException("not support purchase");
    }

    /**
     * 异步通知
     *
     * @param array $parameters
     * @return IRequest
     * @throws PayException
     */
    public function notify(array $parameters = [])
    {
        throw new PayException("not support notify");
    }

    /**
     * 查询订单
     *
     * @param array $parameters
     * @return IRequest
     * @throws PayException
     */
    public function query(array $parameters = [])
    {
        throw new PayException("not support query");
    }

    /**
     * 关闭订单
     *
     * @param array $parameters
     * @return IRequest
     * @throws PayException
     */
    public function close(array $parameters = [])
    {
        throw new PayException("not support close");
    }

    /**
     * 退款
     *
     * @param array $parameters
     * @return IRequest
     * @throws PayException
     */
    public function refund(array $parameters = [])
    {
        throw new PayException("not support refund");
    }

    /**
     * 退款查询
     *
     * @param array $parameters
     * @return IRequest
     * @throws PayException
     */
    public function queryRefund(array $parameters = [])
    {
        throw new PayException("not support queryRefund");
    }


}