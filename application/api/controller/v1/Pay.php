<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/25
 * Time: 20:03
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use \app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope' => ['only' => 'getPreOrder']
    ];

    public function getPreOrder($id=''){
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify(){
        // 通知的频率15/15/30/180/1800/1800/1800/3600. 单位秒

        // 1. 检测库存量，超卖
        // 2. 更新订单的状态
        // 3. 库存量的扣除
        // 4. 如果成功处理，我们返回给微信成功处理的消息，否则返回没有成功处理的消息
        // 特点:post; xml

        $notify = new WxNotify();
        $notify->Handle();
    }
}