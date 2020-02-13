<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

date_default_timezone_set('Africa/Dar_es_Salaam');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
$config = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'ETE FRAMEWORK',
	//'theme' => 'public',
	'defaultController' => 'public',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'revina',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
		'module' => array(
        'publishDirectory' => true
       ),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'application.modules.user.components.YumWebUser',
			'loginUrl' => array('//public/login'),
		),
		
		'cache' => array('class' => 'system.caching.CDummyCache'),
		
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => true,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		/*'db2'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=pms_schema',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '0991ibrah',
			'tablePrefix' => '',
			'charset' => 'utf8',
		
		$dsn = 'mysql:host=tanzaniangurucom.ipagemysql.com;dbname=pms';
    $username = 'ibrah';
    $password = '0991ibrah@';),*/
		
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=41.86.176.19;dbname=pms',
			'emulatePrepare' => true,
			'username' => 'ibrah',
			'password' => 'ibrah0991',
			'tablePrefix' => '',
			'charset' => 'utf8',
		),
		
		'authManager' => array(
	
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'public/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'innocentruge@gmail.com',
	),
);

$modules_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR;
$handle_mod = opendir($modules_dir);

while (false !== ($file = readdir($handle_mod))) {
    if ($file != "." && $file != ".." && is_dir($modules_dir . $file)) {
        $config = CMap::mergeArray($config, require($modules_dir . $file . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'main.php'));
    }
}


closedir($handle_mod);

return $config;
