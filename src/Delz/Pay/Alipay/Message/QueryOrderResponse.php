<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Contract\IRequest;

/**
 * 统一收单线下交易查询请求返回结果类
 *
 * @package Delz\Pay\Alipay\Message
 */
class QueryOrderResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function __construct(IRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data['alipay_trade_query_response'];
        $this->checkSign($data['sign']);
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return $this->isSignOk && $this->data['msg'] == 'Success' && $this->data['code'] == '10000' && ($this->data['trade_status'] == 'TRADE_SUCCESS' || $this->data['trade_status'] == 'TRADE_FINISHED');
    }

    /**
     * 是否等待买家付款中
     *
     * @return bool
     */
    public function isWaitingForPay()
    {
        return $this->isSignOk && isset($this->data['trade_status']) && $this->data['trade_status'] == 'WAIT_BUYER_PAY';
    }

    /**
     * 是否交易关闭
     *
     * 未付款交易超时关闭，或支付完成后全额退款
     *
     * @return bool
     */
    public function isClosed()
    {
        return $this->isSignOk && isset($this->data['trade_status']) && $this->data['trade_status'] == 'TRADE_CLOSED';
    }

    /**
     * 是否交易结束
     *
     * 交易结束，不可退款
     *
     * @return bool
     */
    public function isFinished()
    {
        return $this->isSignOk && isset($this->data['trade_status']) && $this->data['trade_status'] == 'TRADE_FINISHED';
    }
}