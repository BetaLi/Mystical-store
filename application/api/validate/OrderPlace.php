<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/6
 * Time: 19:02
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Validate;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts'
    ];

    protected $singleRule = [
        'product_id' => 'require|isPositiveInteger',
        'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values){
        if(is_array($values)){
            throw new ParameterException([
                'msg' => '商品参数不正确'
            ]);
        }
        if(empty($values)){
            throw new ParameterException([
                'msg' => '商品列表不可为空'
            ]);
        }

        foreach($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }

    protected function checkProduct($value){
        $validate = new Validate($this->singleRule);
        $result = $validate->check($value);
        if(!$result){
            throw new ParameterException([
                'msg' => '商品列表参数错误'
            ]);
        }
    }
}