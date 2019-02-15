<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/6
 * Time: 20:07
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}