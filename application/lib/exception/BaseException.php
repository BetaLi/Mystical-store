<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/11/16
 * Time: 19:59
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    //HTTP 状态码
    public $code = 400;

    //错误信息
    public $msg = '参数错误';

    //自定义的状态码
    public $errorCode = 10000;

    public function __construct($params=[])
    {
        if(!is_array($params)){
            return;
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}