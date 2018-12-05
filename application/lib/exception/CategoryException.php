<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 15:17
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '请求的分类列表不存在';
    public $errorCode = 50000;
}