<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 19:59
 */

namespace app\api\service;


class Token
{
    public static function generateToken(){
        // 32个字符组成一组随机字符串
        $randChars = getRandChars(32);
        // 进行加密
        $timestamp = time();
        // salt
        $salt = config('secure.token_salt');
        // MD5
        return md5($randChars . $timestamp . $salt);
    }
}