<?php


namespace app\common\lib;


class Time
{
    public static function tokenDataExpireTime($type){
        $type = !in_array($type,[1,2]) ? 2 : $type;
        if ($type == 1){
            $type = 7 * 24 * 3600;
        }elseif($type == 2){
            $type = 30 * 24 * 3600;
        }
        return $type;
    }
}