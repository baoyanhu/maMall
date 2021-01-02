<?php


namespace app\common\lib;


class Str
{
    /**
     * 生成登录使用的token
     * @param $string
     * @return string
     */
    public static function getLoginToken($string){
        $str = md5(uniqid(md5(microtime(true)),true));//生成一个不会重复的字符串
        $token = sha1($str.$string);
        return$token;
    }
}