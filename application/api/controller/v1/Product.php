<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/3
 * Time: 20:50
 */

namespace app\api\controller\v1;


use app\api\validate\Count;
use \app\api\model\Product as ProductModel;
use app\lib\exception\ProductException;

class Product
{
    /*
     * @ url /api/:version/product/recent?count
     */
    public function getRecent($count=15){
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if(!$products){
            throw new ProductException();
        }
        return $products;
    }
}