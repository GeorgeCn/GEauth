<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/2
 * Time: 15:19
 */
return array(
  'DB_CONFIG_LOG' =>array(
    'DB_TYPE' => 'Mysql', // 数据库类型
    'DB_HOST' => 'dev.uuabc.com',
    'DB_PWD' => 'root',
    'DB_HOST' => '10.63.0.30',
    'DB_PWD' => 'root',
    'DB_USER' => 'root',
    'DB_NAME' => 'uuabc_log',
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_PORT' => 3306,
  ),


//    'DB_TYPE' => 'Mysql', // 数据库类型
/*  'DB_USER' => 'root',
  'DB_HOST' => '127.0.0.1',
  'DB_PWD' => '',
  'DB_NAME' => 'test',*/
//   'DB_HOST' => "120.132.8.157",//'10.63.0.30',//'120.132.21.197',
//    'DB_PWD' => 'Dev666#h',//'root',
//    'DB_USER' => "dev",//'root',
//    'DB_NAME' => 'uuabc',//'',
//    'DB_PREFIX' => '', // 数据库表前缀
//    'DB_PORT' => 3306,

    'DB_HOST' => '10.63.0.30',
    'DB_PWD' => 'root',
    'DB_USER' => 'root',
    'DB_NAME' => 'auth',//'uuabc''uu_develop_bak',
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_PORT' => 3306,
//
//    'DB_HOST' => '10.63.0.30',
//    'DB_PWD' => 'root',
//    'DB_USER' => 'root',
//    'DB_NAME' => 'uu_develop_online',
//    'DB_PREFIX' => '', // 数据库表前缀
//    'DB_PORT' => 3306,

//    'DB_HOST' => 'sithome.uuabc.com',
//    'DB_PWD' => 'zhangcheng',
//    'DB_USER' => 'zhangcheng',
//    'DB_NAME' => 'uuabc',//'uuabc''uu_develop_bak',
//    'DB_PREFIX' => '', // 数据库表前缀
//    'DB_PORT' => 3306,

//    'DB_HOST' => 'rm-bp1zze70pn305sak54o.mysql.rds.aliyuncs.com',
//    'DB_PWD' => 'zhangcheng',
//    'DB_USER' => 'zhangcheng',
//    'DB_NAME' => 'uuabc',//'uuabc''uu_develop_bak',
//    'DB_PREFIX' => '', // 数据库表前缀
//    'DB_PORT' => 3306,

    // 普通配置
//redis 1
    'SESSION_REDIS_HOST'    =>  '10.63.0.30', //分布式Redis,默认第一个为主服务器
    'SESSION_REDIS_PORT'    =>  '6379',
    'SESSION_REDIS_AUTH'=>'',
    'REDIS_PERSISTENT' => true,  //是否长连接*/
//redis 2
//    'REDIS_HOST' => '10.63.0.30',
//    'REDIS_PASSWORD' => null,
//    'REDIS_PORT' => '6379',
//    'REDIS_PERSISTENT' => false,  //是否长连接


    'WECHAT_PUSHED' => false,  //是否微信推送 false true
    'NEW_VERSION' =>true ,  //是开启新版本  false true
  'mongodb'=>[
    'master'=>[
      'host'=>'10.63.0.30',
      'port'=>'27017',
      'database'=>'local',
      'username'=>null,
      'password'=>null
    ]]
);