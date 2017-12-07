<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Contract\IRequest;

/**
 * 退款请求结果类
 *
 * @package Delz\Pay\Alipay\Message
 */
class RefundResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function __construct(IRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data['alipay_trade_refund_response'];
        $this->checkSign($data['sign']);
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->isSignOk && $this->data['msg'] == 'Success' && $this->data['code'] == '10000' && isset($this->data['trade_no']);
    }
}