<?php


namespace app\admin\controller;

use think\facade\View;

class Index extends AdminBase
{
    /**
     * 渲染后台视图
     * @return string
     */
    public function index(){
        return View::fetch();
    }

    /**
     * 渲染后台首页视图
     * @return string
     */
    public function welcome(){
        return View::fetch();
    }
}