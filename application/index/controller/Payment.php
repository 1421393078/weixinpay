<?php
namespace app\index\controller;
use EasyWeChat\Factory;
use think\Request;
//支付
class Payment extends Common
{
    public function index()
    {
    	$config = $this->getConfig('fanxin');
    	// $app = Factory::payment($this->config);
    	var_dump($config);
    }

    public function getApp($merchantName)
    {
    	$config = $this->getConfig($merchantName);
    	$config['sandbox'] = true ; 
    	return Factory::payment($config);
    }

    // 企业付款到用户零钱
    public function toBalance()
    {	
        $data = Request::instance()->get();
    	$merchantName = 'fanxin';
        $app = $this->getApp($merchantName);
        $data = [
            'partner_trade_no' => '1233455', // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => 'oxTWIuGaIt6gTKsQRLau2M0yL16E',
            'check_name' => 'NO_CHECK', // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
            're_user_name' => '王小帅', // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
            'amount' => 100, // 企业付款金额，单位为分
            'desc' => '理赔', // 企业付款操作说明信息。必填
        ];

        $info = $app->transfer->toBalance($data);
        return $this->checkSuccess($info,'付款成功','付款失败');
    }

    
    // 下单
    public function unify()
    {
    	$merchantName = 'fanxin';
        $app = $this->getApp($merchantName);
        $data = [
			'body' => '腾讯充值中心-QQ会员充值',
			'out_trade_no' => '20150806125346',
            'total_fee' => 302,
			// 'total_fee' => 88,
			'spbill_create_ip' => '123.12.12.123', // 可选，如不传该参数，SDK 将会自动获取相应 IP 地址
			'notify_url' => 'https://pay.weixin.qq.com/wxpay/pay.action', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
			'trade_type' => 'JSAPI', // 请对应换成你的支付方式对应的值类型
			'openid' => 'oUpF8uMuAJO_M2pxb1Q9zNjWeS6o',
		];
        $info = $app->order->unify($data);
        return $this->checkSuccess($info,'下单成功','下单失败');
    }

    // public function 

}
