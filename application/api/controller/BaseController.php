<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 20:57
 */

namespace app\api\controller;


use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    // 用户和管理员都可以访问的前置方法
    public function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    // 只有用户才可以访问的前置方法
    public function checkExclusiveScope(){
        TokenService::needExclusiveScope();
    }
}