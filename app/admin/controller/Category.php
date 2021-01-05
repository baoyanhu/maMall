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
            "categoryLists" => $categoryLists,
            "pid" => $pid
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
        $check = $CategoryVil->scene('add')->check($data);
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

    /**
     * 渲染当前分类名称及编辑页面
     * @return string
     */
    public function edit(){
        $id = input("param.id","","intval");
        $data = [
            'id' => $id
        ];
//        验证参数
        $CategoryVil = new CategoryVil();
        $check = $CategoryVil->scene('edit')->check($data);
        if (!$check){
            return show(config("status.error"),$CategoryVil->getError());
        }
        try {
            $categoryBus = new CategoryBus();
            $category = $categoryBus->getById($id)->toArray();
            if ($category['pid'] == 0){
                $parentCategory['name'] = "顶级分类";
            }else{
                $parentCategory = $categoryBus->getParentById($category['pid']);
            }
        }catch (Exception $e){
            $category = [];
            $parentCategory = [];
        }
        return View::fetch("",[
            "category" => $category,
            'parentCategory' => $parentCategory
        ]);
    }

    public function editSave(){
        $id = input("param.id","","intval");
        $name = input("param.name","","trim");
        $data = [
            'id' => $id,
            'name' => $name
        ];
//        验证参数
        $CategoryVil = new CategoryVil();
        $check = $CategoryVil->scene('editSave')->check($data);
        if (!$check){
            return show(config("status.error"),$CategoryVil->getError());
        }
//        到业务逻辑
        try {
            $categoryBus = new CategoryBus();
            $res = $categoryBus->editSave($data);
            if (!$res){
                return show(config("status.error"),"更新失败");
            }
        }catch (Exception $e){
            return show(config("status.error"),$e->getMessage());
        }

        return show(config("status.success"),"更新成功");
    }

    /**
     * 更新分类排序
     */
    public function orderlist(){
        $id = input("param.id","","intval");
        $orderlist = input("param.orderlist","","intval");
        $data = [
            'id' => $id,
            'orderlist' => $orderlist
        ];
//        验证参数
        $CategoryVil = new CategoryVil();
        $check = $CategoryVil->scene('orderlist')->check($data);
        if (!$check){
            return show(config("status.error"),$CategoryVil->getError());
        }

//        更新排序
        try {
            $categoryBus = new CategoryBus();
            $result = $categoryBus->updateOrderList($data);
        }catch (Exception $e){
            return show(config("status.error"),$e->getMessage());
        }
        if (!$result){
            return show(config("status.error"),"排序失败");
        }
        return show(config("status.success"),"排序成功");
    }

    /**
     * 更改分类状态
     */
    public function changeStatus(){
        $id = input("param.id","","intval");
        $status = input("param.status","","intval");
        $data = [
            'id' => $id,
            'status' => $status
        ];
//        验证参数
        $CategoryVil = new CategoryVil();
        $check = $CategoryVil->scene('changeStatus')->check($data);
        if (!$check){
            return show(config("status.error"),$CategoryVil->getError());
        }

        // 修改状态
        try {
            $categoryBus = new CategoryBus();
            $result = $categoryBus->changeStatus($data);
        }catch (Exception $e){
            return show(config("status.error"),$e->getMessage());
        }
        if (!$result){
            return show(config("status.error"),"状态修改失败");
        }
        return show(config("status.success"),"状态修改成功");
    }

    /**
     * 删除分类
     */
    public function del(){
        $id = input("param.id","","intval");
        $data = [
            'id' => $id,
        ];
//        验证参数
        $CategoryVil = new CategoryVil();
        $check = $CategoryVil->scene('del')->check($data);
        if (!$check){
            return show(config("status.error"),$CategoryVil->getError());
        }

        // 删除分类
        try {
            $categoryBus = new CategoryBus();
            $result = $categoryBus->delCategory($id);
        }catch (Exception $e){
            return show(config("status.error"),$e->getMessage());
        }
        if (!$result){
            return show(config("status.error"),"分类删除失败");
        }
        return show(config("status.success"),"分类删除成功");
    }
}