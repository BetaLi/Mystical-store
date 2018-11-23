<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/11/16
 * Time: 16:05
 */

namespace app\api\controller\v1;

use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner
{
    /**
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner 的id号
     */
    public function getBanner($id){
        (new IDMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);
//        $banner->hidden(['update_time']); //用于隐藏模型对象中的属性
//        $banner->visible(['id']); //用于显示模型对象的属性
        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}