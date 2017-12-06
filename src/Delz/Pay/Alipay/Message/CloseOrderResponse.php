<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Contract\IRequest;

/**
 * 统一收单交易关闭接口请求结果类
 *
 * @package Delz\Pay\Alipay\Message
 */
class CloseOrderResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function __construct(IRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data['alipay_trade_close_response'];
    }
}