<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/3
 * Time: 19:07
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = [
        'delete_time','main_img_id','from','create_time','update_time','category_id','pivot'
    ];

    public function imgs(){
       return $this->hasMany('ProductImage','product_id','id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty','product_id','id');
    }

    public function getMainImgUrlAttr($value,$data){
        return $this->prefixImgUrl($value,$data);
    }

    public static function getMostRecent($count){
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    public static function getProductsByCategoryID($categoryID){
        $products = self::where('category_id','=',$categoryID)->select();
        return $products;
    }

    public static function getProductDetail($id){
        // Query
        $product = self::with([
            'imgs' => function($query){
                $query->with(['imgUrl'])
                ->order('order','asc');
            }
        ])
                ->with(['properties'])
                ->find($id);
        return $product;
    }
}