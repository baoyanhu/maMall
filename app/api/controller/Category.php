<?php


namespace app\api\controller;
use app\common\business\Category as CategoryBus;
use app\common\lib\Tree;

class Category extends ApiBase
{
    /**
     * 首页无限分类
     * @return \think\response\Json
     */
    public function index(){
        $categoryBus = new CategoryBus();
        $categorys = $categoryBus->getAllCategorys();
        $categorysTreeObj = new Tree();
        $categorysTreeInfo = $categorysTreeObj->getTree($categorys);
        return show(config("status.success"),'OK',$categorysTreeInfo);
    }
}