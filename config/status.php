<?php
/**
 * 该文件主要存放业务代码
 */

return[
    "success" => 1,
    "error" => 0,
    "not_login" => -1,
    "user_is_register" => -2,
    "action_not_found" => -3,
    "controller_not_found" => -4,
//    mysql状态码
    "mysql" => [
        "table_normal" => 1,//正常
        "table_pending" => 0,//待审
        "table_delete" => -1,//删除
    ]
];