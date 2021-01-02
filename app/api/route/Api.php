<?php

use think\facade\Route;
//基础的路由定义方式
//Route::rule('users','User/index');
//资源控制器定义方式
Route::resource('user','User');
