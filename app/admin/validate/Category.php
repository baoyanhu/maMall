<?php


namespace app\admin\validate;


use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'pid' => 'require',
        'name' => 'require',
        'id' => 'require|integer',
        'orderlist' => 'require|integer',
        'status' => 'require|in:0,1'
    ];

    protected $message = [
      'pid' => 'pid必填',
      'name' => '分类名称必填',
       'id.require' => 'id不能为空',
       'id.integer' => 'id类型错误',
       'orderlist.require' => '排序数值不能为空',
       'orderlist.integer' => '排序数值类型错误',
        'status.require' => '状态值不能为空',
        'status.in' => '状态数值范围不合法'
    ];
    protected $scene = [
        'add' => ['pid','name'],
        'orderlist'  =>  ['id','orderlist'],
        'changeStatus' => ['id','status'],
        'del' => ['id'],
        'edit' => ['id'],
        'editSave' => ['id','name']
    ];
}