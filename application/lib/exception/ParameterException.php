<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/11/17
 * Time: 9:46
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}