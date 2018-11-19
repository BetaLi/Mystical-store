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

    protected  function isPositiveInteger($value,$rule='',$data='',$field=''){
        if(is_numeric($value)&&is_int($value+0)&&($value+0)>0 ){
            return true;
        } else{
           return $field.'必须是正整数';
        }
    }
}