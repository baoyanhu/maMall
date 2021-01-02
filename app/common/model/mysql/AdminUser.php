<?php


namespace app\common\model\mysql;


use think\Model;

class AdminUser extends Model
{
    /**
     * 根据用户名获取后台管理用户信息
     * @param $username
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getAdminUserByUserName($username){
        if (empty($username)){
            return false;
        }
        $where = [
            "username" => $username
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
}