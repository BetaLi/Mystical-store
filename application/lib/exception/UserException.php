<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 17:09
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}