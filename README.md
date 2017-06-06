# 支付组件

参考Omnipay实现。

目前支持的有：

(1) 微信支付

包括公众号支付、小程序支付、App支付、扫码付等。

## 举例说明

以微信支付说明：

    /**
      * 利用composer的自动加载
      *
      * @var \Composer\Autoload\ClassLoader $loader
      */
    $loader = require __DIR__ . "/../vendor/autoload.php";
    
    /**
     * @var JsGateway $weChatPay
     */
    $weChatPay = PayGatewayFactory::create('WeChat_Js');
    $weChatPay->setAppId('appId');
    $weChatPay->setMchId('mchId');
    $weChatPay->setApiKey('apikey');
    
    //发起支付请求
    $request = $weChatPay->purchase($parameters);
    $response = $request->send();
    if ($response->isSuccessful()) {
        //获取返回数据
        $result = $response->getData();
        return $result;
    }
    
    //异步回调
    $request = $weChatPay->notify();
    $response = $request->send();
              
    //如果支付成功
    if ($response->isPaid()) {
         //获取支付成功返回参数
        $data = $response->getData();
        
        //这里处理支付成功的逻辑
        
        //向微信报告支付成功
        echo $response->getSuccessResult();
    } else {
        //向微信报告支付失败
        echo $response->getFailResult('FAIL');
    }
    
    //退款
    
    $weChatPay->setCertPath(__DIR__ . '/../resource/cert/wxpay/apiclient_cert.pem');
    $weChatPay->setKeyPath(__DIR__ . '/../resource/cert/wxpay/apiclient_key.pem');
    $parameters = [
        'out_trade_no' => '123456',
        'out_refund_no' => '654321',
        'total_fee' => 100,
        'refund_fee' => 100,
         //'refund_account' => 'REFUND_SOURCE_RECHARGE_FUNDS',//如果要从余额退款，请去掉注释
    ];
    $request = $weChatPay->refund($parameters);
    $response = $request->send();
    if ($response->isSuccessful()) {
        //这里处理退款请求提交成功的逻辑
    }
    
    //退款结果查询
    
    $parameters = [
        'out_refund_no' => '123456',
    ];
    $request = $weChatPay->queryRefund($parameters);
    $response = $request->send();
    if ($response->isSuccessful()) {
        //这里处理退款成功的逻辑
    }
