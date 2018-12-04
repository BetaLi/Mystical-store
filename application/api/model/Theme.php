<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/3
 * Time: 19:08
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['update_time','delete_time','topic_img_id','head_img_id'];

    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }

    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');
    }

    public function products(){
        return $this->belongsToMany('product','theme_product','product_id','theme_id');
    }

    public static function getThemeWithProduct($id){
        $theme = self::with('products,topicImg,headImg')->find($id);
        return $theme;
    }
}