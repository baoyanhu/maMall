<?php


namespace app\api\validate;


use think\Validate;

class User extends Validate
{
    protected $rule = [
        "phone_number" => "require",
        "code" => "require|number|min:4",
        "type" => "require|in:1,2",
        "username" => "require",
        "sex" => "require|in:0,1,2"
    ];

    protected $message = [
        "phone_number" => "手机号必填",
        "code.require" => "验证码必填",
        "code.number" => "验证码必须为数字",
        "code.min" => "验证码不得低于4个字符",
        "type.require" => "类型必填",
        "type.in" => "类型数值错误",
        "username" => "用户名必填",
        "sex.require" => "性别必选",
        "sex.in" => "性格数值错误"
    ];

    protected $scene = [
        "send_code" => ['phone_number'],
        "login" => ['phone_number','code','type'],
        "update" => ['username','sex']
    ];
}