<?php


namespace app\model;


use think\Model;

class Demo extends Model
{
    public function getStatusTextAttr($value,$data){
        $status = [
            0 => "删除",
            1 => "正常"
        ];
        return $status[$data['status']];
    }
}