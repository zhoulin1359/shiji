<?php
/**
 * Created by PhpStorm.
 * User: zhoulin
 * Date: 2017/3/3
 * Time: 16:26
 * Email: zhoulin@mapgoo.net
 */

return array(
    //Redis 配置
    'redis' => array(
        'host' => '172.17.0.3',
        'port' => 6379,
        //'auth' => '123456',
        'select' => 1
    ),
    //数据库
    'db' => [
        // required
        'database_type' => 'mysql',
        'database_name' => 'history_base',
        'server' => '172.17.0.4',
        'username' => 'root',
        'password' => '123456',

        // [optional]
        'charset' => 'utf8',
        'port' => 3306,

        // [optional] Table prefix
        'prefix' => '',

        // [optional] Enable logging (Logging is disabled by default for better performance)
        'logging' => true
    ],
    //数据库
    'db_jeemu' => [
        // required
        'database_type' => 'mysql',
        'database_name' => 'history_jeemu',
        'server' => '172.17.0.4',
        'username' => 'root',
        'password' => '123456',

        // [optional]
        'charset' => 'utf8',
        'port' => 3306,

        // [optional] Table prefix
        'prefix' => 'his_',

        // [optional] Enable logging (Logging is disabled by default for better performance)
        'logging' => true
    ],
    //日志数据库
    'db_log' => [
        // required
        'database_type' => 'mysql',
        'database_name' => 'test',
        'server' => '172.17.0.4',
        'username' => 'root',
        'password' => '123456',

        // [optional]
        'charset' => 'utf8',
        'port' => 3306,

        // [optional] Table prefix
        'prefix' => '',

        // [optional] Enable logging (Logging is disabled by default for better performance)
        'logging' => true
    ],
    'alidayu'=>[
        'app_key'=>'23311866',
        'app_secret'=>'a873b1e2d9ef791b041a95016da1a114'
    ],
    'wechat'=>[
        'appid'=>'wxfa31e52b4e31f982',
        'appsecret'=>'f1ab5f7267fc73eb7c0ff710efef2759'
    ],
    //开发模式
    'debug' => true
);
