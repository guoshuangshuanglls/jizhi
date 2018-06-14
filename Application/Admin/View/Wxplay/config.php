<?php
return array(
	'LOAD_EXT_CONFIG' => 'db',
	'PAGE_SIZE'       =>15,
	'APPKEY'          =>'23783085',
	'SECRET'          =>'11de2dd8738e7b92c2ce649cc3910fb0',
	'TEMPLATE_CODE'   =>'SMS_63815704',
	'DEFAULT_MODULE'  =>  'Admin',  // 默认模块
	// 开启路由
	'URL_ROUTER_ON' => true, 
	'URL_MODEL'=>2,
	'URL_ROUTE_RULES'=>array(
		'wxpay' => array('Admin/Wxplay/getrollback')),

	// 缓存设置
    // 'SESSION_TYPE'        => 'Memcache',
    // 'MEMCACHE_HOST'       => '127.0.0.1',
    // 'MEMCACHE_PORT'       => '11211',
    // 'DATA_CACHE_TYPE'     => 'Memcache',
    // 'DATA_CACHE_TIME'     => '3600',

);