<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Contract\IRequest;

/**
 * 统一收单交易创建返回结果类
 *
 * @package Delz\Pay\Alipay\Message
 */
class CreateOrderResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function __construct(IRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data['alipay_trade_create_response'];
        $this->checkSign($data['sign']);
    }

    /**
     * 支付宝交易号
     *
     * @return string
     */
    public function getTradeNo()
    {
        return isset($this->data['trade_no']) ? $this->data['trade_no'] : null;
    }

    /**
     * 商户订单号
     *
     *
     * @return string
     */
    public function getOutTradeNo()
    {
        return isset($this->data['out_trade_no']) ? $this->data['out_trade_no'] : null;
    }
}