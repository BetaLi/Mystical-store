<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/25
 * Time: 20:14
 */

namespace app\api\service;


use app\api\validate\OrderException;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\TokenException;
use think\Exception;
use \app\api\model\Order as OrderModel;
use \app\api\service\Order as OrderService;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');
class Pay
{
    private $orderID;
    private $orderNO;

    function __construct($orderID)
    {
        if(!$orderID){
            throw new Exception('订单号不可以为空');
        }
        $this->orderID = $orderID;
    }

    public function pay(){
        // 订单号可能是不存在的
        // 订单号存在，订单号和当前的用户是不匹配的
        // 订单有可能已经被支付过
        // 进行库存量检测
        $this->checkOrderValid();
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if(!$status['pass']){
            return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrice){
        // openid
        $openid = Token::getCurrentTokenVar('openid');
        if(!$openid){
            throw new TokenException();
        }
        $wxOrderData = new \WxPayUnifiedOrder();
        $wxOrderData->SetOut_trade_no($this->orderNO);
        $wxOrderData->SetTrade_type('JSAPI');
        $wxOrderData->SetTotal_fee($totalPrice*100);
        $wxOrderData->SetBody('零食商贩');
        $wxOrderData->SetOpenid($openid);
        $wxOrderData->SetAppid('wx163d3a3fd4858b6d');
        $wxOrderData->SetNotify_url(config(secure.pay_back_url));
        return $this->getPaySignature($wxOrderData);
    }

    private function getPaySignature($wxOrderData){
        $config = new PayConfig();
        $wxOrder = \WxPayApi::unifiedOrder($config, $wxOrderData);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] != 'SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取支付订单失败','error');
        }
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;
    }

    private function sign($wxOrder){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time() . mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
        $jsApiPayData->SetSignType('md5');
        $sign = $jsApiPayData->MakeSign();
        $rawValues = $jsApiPayData->GetValues();
        $rawValues['paySign'] = $sign;
        unset($rawValues['app_id']);
        return $rawValues;
    }

    private function recordPreOrder($wxOrder){
        OrderModel::where('id','=',$this->orderID)
            ->update(['prepay_id'=>$wxOrder['prepay_id']]);
    }

    private function checkOrderValid(){
        $order = OrderModel::where('id','=',$this->orderID)
            ->find();
        if(!$order){
            throw new OrderException();
        }
        if(!Token::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg'=>'订单与用户不匹配',
                'errorCode'=>10003
            ]);
        }
        if($order->status != OrderStatusEnum::UNPAD){
            throw new OrderException([
                'msg'=>'订单已支付',
                'errorCode'=>80003,
                'error'=>400
            ]);
        }
        $this->orderNO = $order->order_no;
        return true;
    }
}