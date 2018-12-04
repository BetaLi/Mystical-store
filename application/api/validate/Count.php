<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/3
 * Time: 20:53
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule=[
        'count' => 'isPositiveInteger|between:1,15'
    ];
}