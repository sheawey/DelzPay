<?php

namespace Delz\Pay\Common\Contract;

/**
 * 支付异步返回接口
 *
 * @package Delz\Pay\Common\Contract
 */
interface INotifyResponse
{
    /**
     * 是否支付
     *
     * @return bool
     */
    public function isPaid();

    /**
     * 成功结果
     *
     * @return string
     */
    public function getSuccessResult();

    /**
     * 失败结果
     *
     * @param string $reason 失败理由
     * @return string
     */
    public function getFailResult($reason = '');
}