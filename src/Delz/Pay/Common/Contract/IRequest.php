<?php

namespace Delz\Pay\Common\Contract;

use Delz\Common\Model\IParameterAware;
use Delz\Pay\Common\Exception\InvalidRequestException;

/**
 * 调用第三方支付网关的接口，需要传递一些参数, IRequest接口就是管理这些参数的类
 *
 * 主要有如下功能：
 * - 设置参数
 * - 在发送前检查参数是否符合规范
 * - 构造符合规范的数据
 * - 发送构造好的数据到支付网关
 *
 * @package Delz\Pay\Common\Contract
 */
interface IRequest
{
    /**
     * 构造符合规范的数据
     *
     * 如果数据不符合规范，抛出InvalidRequestException异常
     *
     * @return array 数据格式是数组
     * @throws InvalidRequestException
     */
    public function getData();

    /**
     * 将getData()获取到的数据发送请求
     *
     * @return IResponse
     */
    public function send();


}