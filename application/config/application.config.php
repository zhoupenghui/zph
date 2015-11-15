<?php

return array(
    //数据库相关配置
    'database' => array(
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'pwd' => '123456',
        'charset' => 'utf8',
        'dbname' => 'jingxi2',
        'prefix' => 'jx_',
    ),
    //应用整体相关配置
    'app' => array(
        'defaultPlatform' => 'front',
        'defaultController' => 'index',
        'defaultAction' => 'index',
    ),
    //上传文件相关
    'upload' => array(
        'uploadDir' => 'upload' . DS,
        'maxSize' => 2097152,
        'allowType' => array(
            'image/jpeg', 'image/png', 'image/gif'
        ),
    ),
);
