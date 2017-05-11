<?php

namespace Delz\Pay\Common\Contract;

/**
 * IRequest向支付网关发送请求后支付网关返回的结果类接口
 *
 * @package Delz\Pay\Common\Contract
 */
interface IResponse
{
    /**
     * 支付网关返回数据
     *
     * @return mixed
     */
    public function getData();

    /**
     * 请求是否成功
     *
     * @return boolean
     */
    public function isSuccessful();

    /**
     * 如果失败，返回失败code
     *
     * @return string
     */
    public function getErrorCode();

    /**
     * 如果失败，返回失败信息
     *
     * @return string
     */
    public function getErrorMessage();
}