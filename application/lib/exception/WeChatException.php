<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 18:58
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器调用接口失败';
    public $errorCode = 999;
}