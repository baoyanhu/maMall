<?php


namespace app\controller;


class Error
{
    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
        $result = [
            'status' => 0,
            'message' => '控制器不存在',
            'rel' => null
        ];
        return json($result,400);
        return show(config("status.controller_not_found"),"控制器不存在");
    }
}