<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/11/16
 * Time: 19:20
 */

namespace app\api\model;


use think\Db;

class Banner
{
    public static function getBannerByID($id){
        //TODO: 根据banner id来获取banner信息
//        $result = Db::query('select * from banner_item where banner_id=?',[$id]);
//        return $result;
//        $result = Db::table('banner_item')->where('banner_id','=',$id)->select();
        $result = Db::table('banner_item')->where(function($query) use ($id){
            $query->where('banner_id','=', $id);
        })->select();
        return $result;
    }
}