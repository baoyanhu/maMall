<?php


namespace app\common\business;


use app\common\lib\Str;
use app\common\lib\Time;
use think\Exception;

class User
{
    public $userObj;
    public function __construct()
    {
        $this->userObj = new \app\common\model\mysql\User();
    }

    /**
     * 用户登录
     * @param $data
     * @return array|bool
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function login($data){
        cache(config("redis.code_pre")."17647643764","1234");
        $redis_code = cache(config("redis.code_pre").$data['phone_number']);
        if (empty($redis_code) || $redis_code != $data['code']){
            throw new Exception("不存在该验证码",-1009);
        }

//        判断表是否有当前登录用户数据
        $user = $this->userObj->getUserByPhoneNumber($data['phone_number']);
//        没有用户信息则新建用户数据
        if (empty($user)){
            $username = "yunce-".$data['phone_number'];
            $data = [
                "username" => $username,
                "phone_number" => $data['phone_number'],
                "type" => $data['type'],
                "status" => config("status.mysql.table_normal")
            ];
            try {
                $this->userObj->save($data);
                $user_id = $this->userObj->id;
                $username = $this->userObj->username;
            }catch (Exception $e){
                throw new Exception("数据库内部异常");
            }
        }else{
//            存在用户数据则更新数据记录
            $updateData = [
                "update_time" => time(),
            ];
            try {
                $this->userObj->updateById($user['id'],$updateData);
                $user_id = $user->id;
                $username = $user->username;
            }catch (Exception $e){
                throw new Exception("数据库内部异常");
            }
        }
        $token = Str::getLoginToken($data['phone_number']);
        $token_data = [
            "user_id" => $user_id,
            "username" => $username
        ];
        $res = cache(config("redis.token").$token,$token_data,Time::tokenDataExpireTime($data['type']));
        return $res ? ['token' => $token,'username'=>$username] : false;
    }

    /**
     * 根据id获取用户信息
     * @param $id
     * @return array|bool
     */
    public function getUserById($id){
        $user = $this->userObj->getUserById($id);
        if (!$user || $user['status'] != config('status.mysql.table_normal')){
            return [];
        }
        return $user;
    }

    /**
     * 根据用户id修改用户信息
     * @param $id
     * @param $data
     * @throws Exception
     */
    public function update($id,$data){
        $user = $this->getUserById($id);
        if (!$user){
            throw new Exception("用户信息不存在");
        }

        $userResult = $this->getUserByName($data['username']);

        if ($userResult && $userResult['id'] != $id){
            throw new Exception("用户名已存在");
        }
        try {
            return $this->userObj->updateById($id,$data);
        }catch (Exception $e){
            throw new Exception("数据库内部异常");
        }

    }

    /**
     * 根据用户名查询用户信息
     */
    public function getUserByName($username){
        $user = $this->userObj->getUserByName($username);
        if (!$user || $user['status'] != config('status.mysql.table_normal')){
            return [];
        }
        return $user->toArray();
    }
}