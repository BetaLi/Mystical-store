<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 19:54
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use \app\api\service\Token as TokenService;
use \app\api\service\Order as OrderService;
use app\api\validate\PagingParameter;
use \app\api\model\Order as OrderModel;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    // 用户选择商品后，项api提交订单相关的商品信息
    // API在接收到用户的信息后，需要检查订单相关的库存量
    // 有库存，把订单数据存入数据库中，返回客户端消息，客户端可以支付
    // 调用支付接口进行支付
    // 还需要再次进行库存量检测
    // 服务器调用微信的支付接口进行支付
    // 小程序根据服务器返回的结果拉起微信支付
    // 微信会返回给我们一个支付结果
    // 成功：进行库存量的检测
    // 成功：进行库存量的扣除，失败：返回一个支付失败的结果

    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'placeOrder'],
        'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser']
    ];

    public function getSummaryByUser($page=1, $size=15){
        (new PagingParameter())->goCheck();
        $uid = TokenService::getCurrentUid();
        $pagingOrders = OrderModel::getSummaryByUser($uid,$page,$size);
        if($pagingOrders->isEmpty()){
            return [
                'data' => [],
                'current_page' => $pagingOrders->getCurrentPage()
            ];
        }
        $data = $pagingOrders->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return [
            'data' => $data,
            'current_page' => $pagingOrders->getCurrentPage()
        ];
    }

    public function getDetail($id){
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid = TokenService::getCurrentUid();
        $order = new OrderService();
        $status = $order->place($uid,$products);
        return $status;
    }
}