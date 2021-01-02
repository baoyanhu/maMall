<?php


namespace app\api\controller;


class Logout extends AuthBase
{
    /**
     * 退出登录 清楚redis token缓存
     */
    public function index(){
        $res = cache(config("redis.token").$this->access_token,null);
        if ($res){
            return show(config("status.success"),"退出登录成功");
        }
        return show(config("status.error"),"退出登录失败");
    }
}