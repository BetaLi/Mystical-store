<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 15:07
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden=[
        'product_id','delete_time','id'
    ];
}