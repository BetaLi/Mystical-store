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
use app\api\validate\IDMustBePositiveInt;
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
        $collection = collection($products);
        $products = $collection->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if(!$products){
            throw new ProductException();
        }
        $collection = collection($products);
        $products = $collection->hidden(['summary']);
        return $products;
    }

    public function getOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return $product;
    }

    public function deleteOne(){

    }
}