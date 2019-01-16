<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/25
 * Time: 20:43
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    // 待支付
    const UNPAD = 1;
    // 已支付
    const PAID = 2;
    // 已发货
    const DELIVERED = 3;
    // 已支付，但库存不足
    const PAID_BUT_OUT_OF = 4;
}