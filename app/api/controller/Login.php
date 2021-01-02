<?php

declare(strict_types = 1);
namespace app\api\controller;


use app\api\validate\User;
use app\BaseController;
use think\Exception;

class Login extends BaseController
{
    public function index() :object{
        if (!$this->request->isPost()){
            return show(config("status.error"),'请求类型错误');
        }
        $phone_number = input("param.phone_number","","trim");
        $code = input("param.code",0,"intval");
        $type = input("param.type",0,"intval");

        $data = [
            "phone_number" => $phone_number,
            "code" => $code,
            "type" => $type
        ];

        $validate = new User();
        if (!$validate->scene('login')->check($data)){
            return show(config("status.error"),$validate->getError());
        }
        try {
            $userBisness = new \app\common\business\User();
            $result = $userBisness->login($data);
        }catch (Exception $e){
            return show($e->getCode(),$e->getMessage());
        }

        if ($result){
            return show(config("status.success"),"登陆成功",$result);
        }
        return show(config("status.error"),"登陆失败");
    }
}