<?php
    header('content-type:text/html;charset=utf-8');
    ini_set("display_errors",1);
    //使用dd扩展库 This package will add the helper functions dd and dump to your application.
    //引入composer加载文件
    require_once "./vendor/autoload.php";
    //使用dd友好方式输出并die掉程序函数和dump，友好方式输出函数
    $str = "hello word";
    $str1 = "NiuShao";
    $str2 = array(
        '1'=>'a',
        '2'=>'b',
        '3'=>'c',
    );
    /*
    echo $str;
    var_dump($str2);
    dump($str);
    dump($str1);
    dump($str2);
    dd($str2);
    dd($str2);
    */
    //受用carbon库
    /*
    dump( Carbon\Carbon::now() );
    dd( Carbon\Carbon::now()->toDateTimeString());
    */