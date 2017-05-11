<?php

namespace Delz\Pay\Common\Contract;

/**
 * 第三方支付网关接口
 *
 * 任何第三方支付网关必须实现这些接口方法，包括
 *
 * - 发起支付请求
 * - 支付结果异步通知
 * - 支付订单查询
 * - 关闭支付订单
 * - 申请退款
 * - 退款查询(对退款是否成功进行跟踪)
 *
 * @package Delz\Pay\Common\Contract
 */
interface IGateway
{
    /**
     * 发起支付请求
     *
     * @param array $parameters
     * @return IRequest
     */
    public function purchase(array $parameters = []);

    /**
     * 支付结果异步通知
     *
     * @param mixed $parameters
     * @return IRequest
     */
    public function notify(array $parameters = []);

    /**
     * 支付订单查询
     *
     * @param array $parameters
     * @return IRequest
     */
    public function query(array $parameters = []);

    /**
     * 关闭支付订单
     *
     * @param array $parameters
     * @return IRequest
     */
    public function close(array $parameters = []);

    /**
     * 申请退款
     *
     * @param array $parameters
     * @return IRequest
     */
    public function refund(array $parameters = []);

    /**
     * 退款查询
     *
     * @param array $parameters
     * @return mixed
     */
    public function queryRefund(array $parameters = []);
}