<?php


namespace app\admin\controller;


use think\Exception;
use think\facade\View;
use app\admin\validate\Category as CategoryVil;
use app\common\business\Category as CategoryBus;

class Category extends AdminBase
{
    /**
     * 渲染商品分类首页
     * @return string
     */
    public function index(){
        $pid = input("param.pid",0,"intval");
        $data = [
            'pid' => $pid
        ];
        try {
            $categoryBus = new CategoryBus();
            $categoryLists = $categoryBus->getLists($data,3);
        }catch (Exception $e){
            $categoryLists = [];
        }
        return View::fetch("",[
            "categoryLists" => $categoryLists
        ]);
    }

    /**
     * 渲染分类数据及添加页面
     * @return string
     */
    public function add(){
        $categoryBus = new CategoryBus();
        $categorys = $categoryBus->getCategorys();
        return View::fetch("",[
            "categorys" => json_encode($categorys)
        ]);
    }

    /**
     * 添加分类
     */
    public function save(){
//        接收参数
        $pid = input("param.pid","0","intval");
        $name = input("param.name","","trim");

        $data = [
            'pid' => $pid,
            'name' => $name
        ];
//        验证参数
        $CategoryVil = new CategoryVil();
        $check = $CategoryVil->check($data);
        if (!$check){
            return show(config("status.error"),$CategoryVil->getError());
        }
//        到业务逻辑
        try {
            $categoryBus = new CategoryBus();
            $res = $categoryBus->add($data);
            if (!$res){
                return show(config("status.error"),"新增失败");
            }
        }catch (Exception $e){
            return show(config("status.error"),$e->getMessage());
        }

        return show(config("status.success"),"新增成功");
    }
}