<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/11/16
 * Time: 16:51
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rule=[
        'id'=>'require|isPositiveInteger',
    ];

    protected $message = [
        'id' => 'id必须是正整数'
    ];
}