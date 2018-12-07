<?php
/**
 * Created by PhpStorm.
 * User: Lcoder
 * Date: 2018/12/5
 * Time: 15:54
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address extends BaseController
{
    protected $beforeActionList = [
        'checkPrimaryScope' => ['only' => 'createOrUpdateAddress']
    ];

    public function createOrUpdateAddress(){

        $validate = new AddressNew();
        $validate->goCheck();

        // 根据Token获取用户的uid
        // 根据uid查找用户数据 判断用户是否存在 不存在抛出异常
        // 获取用户从客户端提交来的地址信息
        // 根据用户地址信息是否存在从而判断是否将地址添加还是更新

        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
        $dataArray = $validate->getDataByRule(input('post.'));
        $userAddress = $user->address;
        if(!$userAddress){
            $user->address()->save($dataArray);
        }
        else{
            $user->address->save($dataArray);
        }
//        return $user;
        return json(new SuccessMessage(),201);
    }
}