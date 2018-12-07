<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 17:23
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}