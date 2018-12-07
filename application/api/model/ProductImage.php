<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 15:02
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = [
        'img_id','delete_time','product_id'
    ];

    public function imgUrl(){
        return $this->belongsTo('Image','img_id','id');
    }
}