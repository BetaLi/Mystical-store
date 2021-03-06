<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 19:59
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

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

    public static function getCurrentTokenVar($key){
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }
        else{
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)){
                return $vars[$key];
            }
            else{
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    public static function getCurrentUid(){
        // token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    public static function needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope>=ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope==ScopeEnum::User){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    public static function isValidOperate($checkUID){
        if(!$checkUID){
            throw new Exception('检测UID时必须传入一个被传入的UID');
        }
        $currentUID  = self::getCurrentUid();
        if($currentUID == $checkUID){
            return true;
        }else{
            return false;
        }
    }
}