<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/11/16
 * Time: 20:03
 */

namespace app\lib\exception;


class BannerMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求banner不存在';
    public $errorCode = 40000;
}