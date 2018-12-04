<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/11/16
 * Time: 19:20
 */

namespace app\api\model;


use think\Db;
use think\Model;

class Banner extends Model
{
    // 隐藏对象模型的属性
    protected $hidden = ['update_time','delete_time'];

    // 模型关联函数
    public function items(){
        // 参数：被关联的对象，关联模型的外键，本模型的主键
        return $this->hasMany('BannerItem','banner_id','id');
    }

    public static function getBannerByID($id){
        //TODO: 根据banner id来获取banner信息
        $banner = self::with(['items','items.img'])->find($id);  //模型查询时推荐使用静态的方法
        return $banner;
    }
}