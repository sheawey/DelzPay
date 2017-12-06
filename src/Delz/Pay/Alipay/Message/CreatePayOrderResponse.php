<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Contract\IRequest;

/**
 * 统一收单交易支付返回结果
 *
 * @package Delz\Pay\Alipay\Message
 */
class CreatePayOrderResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function __construct(IRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data['alipay_trade_pay_response'];
    }

    /**
     * 是否等待客户付款
     *
     * @return bool
     */
    public function isWaitingForPay()
    {
        return $this->data['code'] == '10003';
    }

}