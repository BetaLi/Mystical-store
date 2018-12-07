<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 17:50
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = [
        'id','delete_time','user_id'
    ];
}