<?php


namespace app\controller;


use app\BaseController;
use app\model\Demo;
use think\facade\Db;

class Data extends BaseController
{
    public function index(){
//        通过门面模式获取数据
        $rel = Db::table("mall_demo")
//            ->where("id",">",2)
//            ->where("category_id",2)
                ->where([
                    ["id","in","1,2,3"],
                    ["category_id","=",2]
            ])
//            ->order("id","desc")

//            ->limit("0","2")
//                ->page(2,1)
            ->select();

//        通过容器获取数据
//        $res = app("db")->table("mall_demo")->where("id",2)->find();
        dump($rel);
    }

    public function demo(){
        $data = [
            "title" => "byh4",
            "content" => "大萨达所多撒",
            "category_id" => 2,
            "create_time" => date("Y-m-d H:i:s",time()),
            "update_time" => date("Y-m-d H:i:s",time()),
            "status" => 1
        ];
//        $res = Db::table("mall_demo")->insert($data);

//        $res = Db::table("mall_demo")->where("id",1)->delete();
        $up = [
            "title" => "byh009",
            "content" => "与同仁堂"
        ];
        $res = Db::table("mall_demo")->where("id",2)->update($up);
        echo Db::getLastSql();
        dump($res);
    }

    public function mode(){
        $res = Demo::find(2);
        dump($res->toArray());
    }

    public function mod(){
        $demoObj = new Demo();
        $res = $demoObj->where("id",">",2)
            ->limit(0,2)
            ->select();
        dump(json($res));
        foreach ($res as $item){
//            dump($item['title']);
            dump($item->status_text);
        }
        dump(json($res->toArray()));
    }
}