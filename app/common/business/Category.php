<?php


namespace app\common\business;
use app\common\model\mysql\Category as CategoryModel;
use think\Exception;

class Category
{
    public $categoryObj;
    public function __construct()
    {
        $this->categoryObj = new CategoryModel();
    }

    /**
     * 添加商品分类
     * @param $data
     */
    public function add($data){
        $data['status'] = config("status.mysql.table_normal");
        $categoryInfo = $this->categoryObj->getCategoryInfo($data);
        if ($categoryInfo && $categoryInfo['status'] == config("status.mysql.table_normal")){
            throw new Exception("分类已存在");
        }
        $this->categoryObj->save($data);
        return $this->categoryObj->id;
    }

    /**
     * 查询所有分类数据
     */
    public function getCategorys(){
        $fileds = "id,name,pid";
        try {
            $categorys = $this->categoryObj->getCategorys($fileds);
        }catch (Exception $e){
            $categorys = [];
        }
        return $categorys;
    }

    /**
     * 获取分类栏目数据
     * @param $data
     * @param $num
     */
    public function getLists($data,$num){
        $categoryList = $this->categoryObj->getLists($data,$num);
        if (!$categoryList){
            return [];
        }
        $result = $categoryList->toArray();
        $result['render'] = $categoryList->render();
        return $result;
    }
}