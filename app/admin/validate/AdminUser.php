<?php


namespace app\admin\validate;


use think\Validate;

class AdminUser extends Validate
{
    protected $rule = [
        "username" => "require",
        "password" => "require",
        "captcha" => "require|checkCaptcha",
    ];

    protected $message = [
        "username" => "用户名必填",
        "password" => "密码必填",
        "captcha" => "验证码必填",
    ];

    public function checkCaptcha($value){
        if (!captcha_check($value)){
            return "验证码错误";
        }
        return true;
    }
}