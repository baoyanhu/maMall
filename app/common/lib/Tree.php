<?php


namespace app\common\lib;


class Tree
{
    /**
     * 树状无限分类
     * @param $data
     */
    public function getTree($data){
        $items = [];
        foreach ($data as $v){
            $items[$v['category_id']] = $v;
        }
        $tree = [];
        foreach ($items as $k=>$item){
            if (isset($items[$item['pid']])){
                $items[$item['pid']]['list'][] = &$items[$k];
            }else{
                $tree[] = &$items[$k];
            }
        }
        return $tree;
    }
}