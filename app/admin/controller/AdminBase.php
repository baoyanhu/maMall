<?php


namespace app\admin\controller;


use app\BaseController;
use think\exception\HttpResponseException;

class AdminBase extends BaseController
{
    protected $adminUser = null;
    public function initialize(){

        parent::initialize();
//        判断用户是否登录
//        if (!$this->isLogin()){
//            return $this->redirect(url("login/index"),302);
//        }
    }

    /**
     * 判断用户是否登录
     */
    public function isLogin(){
        $this->adminUser = session(config("admin.admin_user"));
        if (empty($this->adminUser)){
            return false;
        }
        return true;
    }

    /**
     * 用户未登录重定向到登录页面
     * @param mixed ...$args
     */
    public function redirect(...$args){
        throw new HttpResponseException(redirect(...$args));
    }
}