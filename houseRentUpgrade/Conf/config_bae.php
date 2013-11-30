<?php
//BAE下固定mysql配置
return array(
		
		"BUCKET"=>"zuketuan-public",
		"BCS_HOST"=>"bcs.duapp.com",
		'URL_MODEL'=>3,
		'BUCKET_PREFIX'=>'zuketuan-',
		'DB_TYPE'=> 'mysql',     // 数据库类型
		'DB_HOST'=> HTTP_BAE_ENV_ADDR_SQL_IP, // 服务器地址
		'DB_NAME'=> 'wZPhzsANmcCRTnWQdRqe',        // 数据库名,填写你创建的数据库
		'DB_USER'=> HTTP_BAE_ENV_AK,    // 用户名
		'DB_PWD'=> HTTP_BAE_ENV_SK,         // 密码
		'DB_PORT'=> HTTP_BAE_ENV_ADDR_SQL_PORT,        // 端口
		
		//更改模板替换变量，让普通能在所有平台下显示
		'TMPL_PARSE_STRING'=>array(
		'/Public/upload'=>file_domain('zuketuan-public').'/upload'
		)
);
