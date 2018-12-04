<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/3
 * Time: 19:55
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '请求的主题不存在,检查请求ID';
    public $errorCode = 30000;
}