<?php


namespace app\common\model\mysql;


use think\Model;

class User extends Model
{
//    写入数据时自动写入创建时间和更新时间
    protected $autoWriteTimestamp = true;
    /**
     * 根据手机号获取用户信息
     * @param $username
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserByPhoneNumber($phone_number){
        if (empty($phone_number)){
            return false;
        }
        $where = [
            "phone_number" => $phone_number
        ];
        $result = $this->where($where)->find();
        return $result;
    }

    /**
     * 根据主键id更新用户信息
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateById($id,$data){
        $id = intval($id);
        if (empty($id) || empty($data) || !is_array($data)){
            return false;
        }
        $where = [
            "id" => $id
        ];
        $result = $this->where($where)->save($data);
        return $result;
    }

    /**
     * 根据用户id查询用户信息
     * @param $id
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserById($id){
        $id = intval($id);
        if (!$id){
            return false;
        }
        $userInfo = $this->find($id);
        return $userInfo->toArray();
    }

    /**
     * 根据用户名查询用户信息
     * @param $username
     */
    public function getUserByName($username){
        if (empty($username)){
            return false;
        }
        $where = [
            "username" => $username
        ];
        $result = $this->where($where)->find();
        return $result;
    }
}