<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 15:10
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden=['delete_time','update_time'];
    public function topicImg(){
        return $this->belongsTo('Image','topic_img_id','id');
    }
}