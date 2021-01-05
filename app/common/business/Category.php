<?php


namespace app\common\business;
use app\common\model\mysql\Category as CategoryModel;
use think\Exception;

class Category
{
    public $model;
    public function __construct()
    {
        $this->model = new CategoryModel();
    }

    /**
     * 添加商品分类
     * @param $data
     */
    public function add($data){
        $data['status'] = config("status.mysql.table_normal");
        $categoryInfo = $this->model->getCategoryInfo($data);
        if ($categoryInfo && $categoryInfo['status'] != config("status.mysql.table_delete")){
            throw new Exception("分类已存在");
        }
        $this->model->save($data);
        return $this->model->id;
    }

    /**
     * 查询所有分类数据
     */
    public function getCategorys(){
        $fileds = "id,name,pid";
        try {
            $categorys = $this->model->getCategorys($fileds);
        }catch (Exception $e){
            $categorys = [];
        }
        return $categorys;
    }

    /**
     * 前端无限分类展示
     * @return array
     */
    public function getAllCategorys(){
        $fileds = "id as category_id,name,pid";
        try {
            $categorys = $this->model->getCategorys($fileds);
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
        $categoryList = $this->model->getLists($data,$num);
        if (!$categoryList){
            return [];
        }
        $result = $categoryList->toArray();
        $result['render'] = $categoryList->render();

//        获取每一个分类下子分类的总数
//        先获取当前所有的父类id
        $pids = array_column($result['data'],'id');
        $childs = $this->model->getChildLists($pids);
        if (empty($childs)){
            $childs = [];
        }else{
            $childs = $childs->toArray();
        }
        $idCounts = [];
        foreach ($childs as $item){
            $idCounts[$item['pid']] = $item['count'];
        }
//        给返回的数据新加childcount Key
        foreach ($result['data'] as $k=>$item){
            $result['data'][$k]['childCount'] = $idCounts[$item['id']] ?? 0;
        }

        return $result;
    }

    /**
     * 根据id获取数据
     * @param $id
     */
    public function getById($id){
        $categoryInfo = $this->model->find($id);
        if (!$categoryInfo){
            return [];
        }
        return $categoryInfo;
    }

    /**
     * 更新分类排序
     * @param $data
     */
    public function updateOrderList($data){
        $categoryInfo = $this->getById($data['id']);
        if (empty($categoryInfo)){
            throw new Exception('不存在当前分类信息');
        }
        try {
            $result = $this->model->updateOrderList($data);
        }catch (Exception $e){
            throw new Exception('系统错误');
        }

        return $result;
    }

    /**
     * 更改分类状态
     * @param $data
     */
    public function changeStatus($data){
        $categoryInfo = $this->getById($data['id']);
        if (empty($categoryInfo)){
            throw new Exception('不存在当前分类信息');
        }
        if ($categoryInfo['status'] == $data['status']){
            throw new Exception('请勿多次修改相同的分类状态');
        }
        try {
            $result = $this->model->changeStatus($data);
        }catch (Exception $e){
            throw new Exception('系统错误');
        }

        return $result;
    }

    /**
     * 删除分类
     * @param $id
     */
    public function delCategory($id){
        $categoryInfo = $this->getById($id);
        if (empty($categoryInfo)){
            throw new Exception('不存在当前分类信息');
        }
        try {
            $result = $this->model->delCategory($id);
        }catch (Exception $e){
            throw new Exception('系统错误');
        }
        return $result;
    }

    /**
     * 获取父类分类信息
     * @param $id
     */
    public function getParentById($id){
        $categoryInfo = $this->getById($id);
        if (empty($categoryInfo)){
            throw new Exception('不存父类分类信息');
        }
        $parentCategory = $this->model->getParentById($id);
        if (!$parentCategory){
            return [];
        }
        return $parentCategory;
    }

    public function editSave($data){
        $categoryInfo = $this->getById($data['id']);
        if (empty($categoryInfo)){
            throw new Exception('不存在当前分类信息');
        }

        $categoryInfo = $this->model->getCategoryInfo($data);
        if ($categoryInfo && $categoryInfo['status'] != config("status.mysql.table_delete")){
            throw new Exception("分类已存在");
        }
        try {
            $result = $this->model->editSave($data);
        }catch (Exception $e){
            throw new Exception("系统错误");
        }
        return $result;
    }
}