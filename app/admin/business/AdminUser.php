<?php


namespace app\admin\business;


use think\Exception;

class AdminUser
{
    /**
     * 更新用户登录信息
     * @param $data
     * @throws Exception
     */
    public static function login($data)
    {
        try {
            $adminUserObj = new \app\common\model\mysql\AdminUser();
            $adminUser = self::getAdminUserByUserName($data['username']);
//        验证密码是否正确
            $checkPhpass = checkPhpass($data['password'], $adminUser->password);
            if (!$checkPhpass) {
                throw new Exception("密码错误");
            }

            $data = [
                "update_time" => time(),
                "last_login_time" => time(),
                "last_login_ip" => Request()->ip()
            ];

            $result = $adminUserObj->updateById($adminUser['id'], $data);
            if (!$result) {
                throw new Exception("登陆失败");
            }
        } catch (Exception $e) {
//            todo 需要将错误信息写入日志 $e->getMessage()
            throw new Exception("系统异常,请重新登录");
        }

//        将用户信息存入session
        session(config("admin.admin_user"), $adminUser->toArray());
        return true;
    }

    /**
     * 根据用户名获取用户信息
     * @param $username
     * @return array|bool|\think\Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function getAdminUserByUserName($username)
    {
        //        验证用户是否存在
        $adminUserObj = new \app\common\model\mysql\AdminUser();
        $adminUser = $adminUserObj->getAdminUserByUserName($username);
        if (empty($adminUser) || $adminUser->status != config("status.mysql.table_normal")) {
            return false;
        }
        return $adminUser;
    }
}