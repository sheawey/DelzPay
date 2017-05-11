<?php

namespace Delz\Pay\WeChat\Message;

use Delz\Common\Util\Http;
use Delz\Pay\Common\Exception\InvalidRequestException;
use Delz\Pay\WeChat\Helper;

/**
 * 订单查询请求
 *
 * @package Delz\Pay\WeChat\Message
 */
class QueryOrderRequest extends Request
{
    /**
     * 查询订单网址
     */
    const API_ORDER_QUERY = 'https://api.mch.weixin.qq.com/pay/orderquery';

    public function send()
    {
        $response = Http::post(self::API_ORDER_QUERY, ['body' => Helper::array2xml($this->getData())]);
        $data = Helper::xml2array($response->getBody());

        return new QueryOrderResponse($this, $data);
    }

    public function getData()
    {
        $this->checkRequired(
            'app_id',
            'mch_id'
        );

        if(!$this->getOutTradeNo() && !$this->getTransactionId()) {
            throw new InvalidRequestException("The 'transaction_id' or 'out_trade_no' parameter is required");
        }

        $data = array (
            'appid'          => $this->getAppId(),
            'mch_id'         => $this->getMchId(),
            'transaction_id' => $this->getTransactionId(),
            'out_trade_no'   => $this->getOutTradeNo(),
            'nonce_str'      => md5(uniqid()),
        );

        //过滤空值
        $data = array_filter($data);

        //生成签名
        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }

    public function getTransactionId()
    {
        return $this->getParameter('transaction_id');
    }

    public function setTransactionId($transactionId)
    {
        $this->setParameter('transaction_id', $transactionId);
    }


}