<?php


namespace app\admin\controller;

use app\common\model\mysql\AdminUser;
use think\Exception;
use think\facade\View;

class Login extends AdminBase
{

    public function initialize()
    {
        if ($this->isLogin()) {
            return $this->redirect(url("index/index"));
        }
    }

    /**
     * 渲染登录视图
     */
    public function index()
    {
        return View::fetch();
    }

    /**
     * 验证登录数据
     */
    public function check()
    {
        if (!$this->request->isPost()) {
            return show(config("status.error"), "登录方式错误");
        }

//        参数校验
        $username = input("username", "", "trim");
        $password = input("password", "", "trim");
        $captcha = input("captcha", "", "trim");
        $data = [
            "username" => $username,
            "password" => $password,
            "captcha" => $captcha,
        ];
//        内置validate数据验证
        $validate = new \app\admin\validate\AdminUser();
        $check = $validate->check($data);
        if (!$check) {
            return show(config("status.error"), $validate->getError());
        }

//        自定义验证
//        if (empty($username) || empty($passpord) || empty($captcha)) {
//            return result(config("status.error"), "参数不能为空");
//        }
//
////        验证码校验
//        if (!captcha_check($captcha)) {
//            return result(config("status.error"), "验证码错误");
//        }
        try {
            $adminUser = new \app\admin\business\AdminUser();
            $result = $adminUser::login($data);
        } catch (Exception $e) {
            return show(config("status.error"), $e->getMessage());
        }
        if (!$result) {
            return show(config("status.error"), "登陆失败");
        }
        return show(config("status.success"), "登陆成功");
    }
}