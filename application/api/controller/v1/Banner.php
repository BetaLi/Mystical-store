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
//        $banner = BannerModel::getBannerByID($id);
        $banner = BannerModel::get($id);  //模型查询时推荐使用静态的方法
//        $banner = new BannerModel();
//        $banner = $banner->get($id);
        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}