<?php
if (!defined('THINK_PATH'))exit();


$DB = require("../config.inc.php");	//数据库配置

//系统配置
$system = array(

	//路由配置
	'URL_MODEL'             => 3,							//URL重写，兼容模式  如：home.php?s=/User/user   或者  home.php/User/user
	'URL_ROUTER_ON'   => true, //开启路由
	'URL_HTML_SUFFIX' => '.html',	//URL伪静态
	'PREV_URL' => $_SERVER["HTTP_REFERER"],		//上一页地址配置
	
	//session及时区配置
	'SESSION_AUTO_START' => true,				//session常开
	'DEFAULT_TIMEZONE'=>'Asia/Shanghai', 	// 设置默认时区
			
	//模板配置
	//'DEFAULT_THEME' => 'default',
	//'TMPL_ACTION_SUCCESS' => 'public:success',
	//'TMPL_ACTION_ERROR' => 'public:error',

	/*以下添加扩展配置*/
		
);

//RBAC用户权限配置
$RBAC = array(

    'SESSION_AUTO_START' => true,
    'USER_AUTH_ON' => true,
    'USER_AUTH_TYPE' => 2, 				// 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY' => 'authId', 		// 用户认证SESSION标记
    'ADMIN_AUTH_KEY' => 'administrator',		//管理员标示,有所有访问权限
    'AUTH_PWD_ENCODER' => 'md5', // 用户认证密码加密方式
    'USER_AUTH_GATEWAY' => '/Public/login', // 默认认证网关
    'NOT_AUTH_MODULE' => 'Public', 	// 默认无需认证模块
    'REQUIRE_AUTH_MODULE' => '', 	// 默认需要认证模块
    'NOT_AUTH_ACTION' => '', 				// 默认无需认证操作
    'REQUIRE_AUTH_ACTION' => '', 		// 默认需要认证操作
    'GUEST_AUTH_ON' => false, 			// 是否开启游客授权访问
    'GUEST_AUTH_ID' => 0, 					// 游客的用户ID
    'DB_LIKE_FIELDS' => 'title|remark',
		
	'USER_AUTH_MODEL' => 'User', 	// 默认验证数据表模型
    'RBAC_ROLE_TABLE' => 'oa_role',	
    'RBAC_USER_TABLE' => 'oa_role_user',
    'RBAC_ACCESS_TABLE' => 'oa_access',
    'RBAC_NODE_TABLE' => 'oa_node',
	
);
return array_merge($DB, $system,$RBAC);
?>