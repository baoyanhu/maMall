<?php


namespace app\admin\controller;


class Logout extends AdminBase
{
    public function index(){
//        清除session
        session(config("admin.admin_user"),null);

        return redirect(url("login/index"));
    }
}