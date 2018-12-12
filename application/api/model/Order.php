<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/12
 * Time: 20:19
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id','delete_time','update_time'];
}