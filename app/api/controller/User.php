<?php


namespace app\api\controller;
use app\common\business\User as UserBis;
use app\api\validate\User as UserVil;
use think\cache\driver\Redis;
use think\Exception;

class User extends AuthBase
{
    /**
     * 获取用户个人中心基本信息
     * @return \think\response\Json
     */
    public function index(){
        $user = new UserBis();
        $userInfo = $user->getUserById($this->user_id);
        if (!$userInfo){
            $result = [];
            return show(config("status.error"),"用户信息不存在",$result);
        }else{
            $result =  [
                'username' => $userInfo['username'],
                'sex' => $userInfo['sex']
            ];
        }
        return show(config("status.success"),"OK",$result);
    }

    /**
     * 更新用户中心基本信息
     * @return \think\response\Json
     */
    public function update(){
        $username = input('username','','trim');
        $sex = input('sex',0,'intval');
        $data = [
            'username' => $username,
            'sex' => $sex,
            'update_time' => time()
        ];
        $vilidateObj = new UserVil();
        $vilidate = $vilidateObj->scene('update')->check($data);
        if (!$vilidate){
            return show(config('status.error'),$vilidateObj->getError());
        }

        try {
            $userBis = new UserBis();
            $result = $userBis->update($this->user_id,$data);
        }catch (Exception $e){
            return show($e->getCode(),$e->getMessage());
        }

        if (!$result){
            return show(config("status.error"),"更新失败");
        }

        $token_data = [
            "user_id" => $this->user_id,
            "username" => $username
        ];
//        更新用户个人中心信息需将redis也更新
        $redis = new Redis();
        cache(config("redis.token").$this->access_token,$token_data,$redis->TTL(config("redis.token").$this->access_token));
        return show(config("status.success"),"更新成功");
    }
}