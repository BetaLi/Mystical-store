<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/4
 * Time: 15:09
 */

namespace app\api\controller\v1;

use \app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategories(){
        $categories = CategoryModel::all([],'topicImg');
        if(!$categories){
           throw new CategoryException();
        }
        return $categories;
    }
}