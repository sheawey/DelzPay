<?php

namespace Delz\Pay\Alipay\Message;

use Delz\Pay\Common\Contract\IRequest;

/**
 * 统一收单线下交易预创建请求结果类
 *
 * @package Delz\Pay\Alipay\Message
 */
class CreatePreOrderResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function __construct(IRequest $request, $data)
    {
        $this->request = $request;
        $this->data = $data['alipay_trade_precreate_response'];
        $this->checkSign($data['sign']);
    }

    /**
     * 当前预下单请求生成的二维码码串
     *
     * @return string
     */
    public function getQrCode()
    {
        return isset($this->data['qr_code']) ? $this->data['qr_code'] : null;
    }
}