<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/27
 * Time: 20:20
 */

namespace app\api\service;

use app\api\model\Product;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use \app\api\model\Order as OrderModel;
use \app\api\service\Order as OrderService;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');
class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($objData, $config, &$msg)
    {
        if($objData['result_code'] == 'SUCCESS'){
            $orderNo = $objData['out_trade_no'];
            Db::startTrans();
            try{
                $order = OrderModel::where('order_no','=',$orderNo)
                    ->lock(true)
                    ->find();
                if($order->status == 1){
                    $service = new OrderService();
                    $stock_status = $service->checkOrderStock($order->id);
                    if($stock_status['pass']){
                        $this->updateOrderStatus($order->id,true);
                        $this->reduceStock($stock_status);
                    }else{
                        $this->updateOrderStatus($order->id,false);
                    }
                }
                Db::commit();
                return true;
            }catch(Exception $err){
                Log::error($err);
                Db::rollback();
                return false;
            }
        }else{
            return true;
        }
    }

    private function updateOrderStatus($orderID, $success){
        $status = $success? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id','=',$orderID)
            ->update(['status'=>$status]);
    }

    private function reduceStock($stock_status){
        foreach ($stock_status['pStatusArray'] as $singlePStatus){
            Product::where('id','=',$singlePStatus['id'])
                ->setDec('stock',$singlePStatus['count']);
        }
    }
}