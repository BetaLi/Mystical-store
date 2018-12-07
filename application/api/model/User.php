<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 17:10
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address(){
        return $this->hasOne('UserAddress','user_id','id');
    }

    public static function  getByOpenID($openid){
        $user = self::where('openid','=',$openid)->find();
        return $user;
    }
}