<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 8:48
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '请求的产品列表不存在';
    public $errorCode = 30001;
}