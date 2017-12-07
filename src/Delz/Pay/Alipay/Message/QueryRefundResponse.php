<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Contract\IRequest;

/**
 * 退款结果查询请求结果类
 *
 * @package Delz\Pay\Alipay\Message
 */
class QueryRefundResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function __construct(IRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data['alipay_trade_fastpay_refund_query_response'];
        $this->checkSign($data['sign']);
    }
}