<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    //读取器
    protected function prefixImgUrl($value,$data){
        if($data['from']==1){
            return config('setting.img_prefix').$value;
        }else{
            return $value;
        }
    }
}
