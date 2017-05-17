<?php
return array(
	//'配置项'=>'配置值'

	/*密码令牌*/
	'TOKEN' => 'adcdefgideavr',

	 /* 数据库设置 */
    'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'tp',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'think_',    // 数据库表前缀

	'DEFAULT_MODULE'        =>  'Home',  // 默认模块
	'DEFAULT_CONTROLLER'    =>  'Public', // 默认控制器名称
	'DEFAULT_ACTION'        =>  'login', // 默认操作名称

    /*模板相关配置*/
    'TMPL_PARSE_STRING'=>array(
		'__DOC__'=>__ROOT__,
    	'__PUBLIC__'=>__ROOT__.'/Public/admin/',
		'__UPLOAD__'=>__ROOT__.'/Uploads',
		'__AVATAR__'=>__ROOT__.'/Public/Uploads/avatars',
		'__APP__'=>WEBROOT_PATH.'/admin.php/Home',
	),

	'AUTH_CONFIG'=>array(
		'AUTH_ON' => true, //认证开关
		'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
		'AUTH_GROUP' => 'think_auth_group', //用户组数据表名
		'AUTH_GROUP_ACCESS' => 'think_auth_group_access', //用户组明细表
		'AUTH_RULE' => 'think_auth_rule', //权限规则表
		'AUTH_USER' => 'think_admin'//用户信息表
	)
);