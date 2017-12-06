<?php

namespace Delz\Pay\Alipay;

use Delz\Pay\Common\Gateway as BaseGateway;
use Delz\Pay\Alipay\Message\QueryOrderRequest;
use Delz\Pay\Alipay\Message\CloseOrderRequest;

/**
 * 支付宝抽象类
 * @package Delz\Pay\Alipay
 */
class Gateway extends BaseGateway
{
    /**
     * 获取支付宝分配给开发者的应用ID
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->getParameter('app_id');
    }

    /**
     * 设置支付宝分配给开发者的应用ID
     *
     * @param string $appId 支付宝分配给开发者的应用ID
     */
    public function setAppId($appId)
    {
        $this->setParameter('app_id', $appId);
    }

    /**
     * 私钥或私钥文件路径
     *
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->getParameter('private_key');
    }

    /**
     * @param string $privateKey 私钥或私钥文件路径
     */
    public function setPrivateKey($privateKey)
    {
        $this->setParameter('private_key', $privateKey);
    }

    /**
     * {@inheritdoc}
     */
    public function query(array $parameters = [])
    {
        return $this->createRequest(QueryOrderRequest::class, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function close(array $parameters = [])
    {
        return $this->createRequest(CloseOrderRequest::class, $parameters);
    }


}