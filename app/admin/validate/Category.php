<?php


namespace app\admin\validate;


use think\Validate;

class Category extends Validate
{
    protected $rule = [
        'pid' => 'require',
        'name' => 'require'
    ];

    protected $message = [
      'pid' => 'pid必填',
      'name' => '分类名称必填'
    ];
}