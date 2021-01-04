<?php


namespace app\common\model\mysql;


use think\Model;

class Category extends Model
{
    //    写入数据时自动写入创建时间和更新时间
    protected $autoWriteTimestamp = true;

    /**
     * 根据分类名称和pid获取数据
     * @param $data
     * @return array|bool|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getCategoryInfo($data){
        if (empty($data)){
            return false;
        }
        $where = [
            "pid" => $data['pid'],
            "name" => $data['name']
        ];
        $result = $this->where($where)->find();
        return $result;
    }

    /**
     * 获取所有分类数据
     */
    public function getCategorys($fileds = '*'){
        $where = [
            'status' => config("status.mysql.table_normal")
        ];
        $result = $this->where($where)->field($fileds)->select();
        if (!$result){
            return [];
        }
        return $result->toArray();
    }

    /**
     * 获取分类栏目数据
     * @param $data
     * @param $num
     */
    public function getLists($data,$num){
        $where = [
            'pid' => $data['pid'],
        ];
        $order = [
            'listorder' => 'asc',
            'id' => 'asc'
        ];
        $result = $this->where("status","<>",config("status.mysql.table_delete"))
            ->where($where)
            ->order($order)
            ->paginate($num);
        return $result;
    }
}