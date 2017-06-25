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
    use ParameterAware;

    /**
     * 网关配置参数
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
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