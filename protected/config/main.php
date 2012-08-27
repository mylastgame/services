<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Web сервисы',
   'charset' => 'UTF-8',

	// preloading 'log' component
	'preload'=>array(
       'log',
       'bootstrap'
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
      'application.controllers.REST.RestController',
      'application.controllers.to.ToController'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
      /*'gii'=>array(
         'class'=>'system.gii.GiiModule',
			'password'=>'1f2r3b]',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1', '192.168.56.1'),
         'generatorPaths'=>array('bootstrap.gii')
		)*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
         'autoRenewCookie'=>true,
         'loginUrl'=>null
		),
      'bootstrap'=>array('class'=>'ext.bootstrap.components.Bootstrap'),
      /*'authManager'=>array( ////not Using!
          'class'=>'CDbAuthManager',
          'connectionID'=>'db',
      ),*/
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
      'urlManager'=>array(
         'urlFormat'=>'path',
         'showScriptName'=>false,         
         'rules'=>array(                   
            // REST patterns
            array('REST/maintenance/mark/list', 'pattern'=>'REST/maintenance/marks', 'verb'=>'GET'),
            array('REST/maintenance/mark/view', 'pattern'=>'REST/maintenance/mark/<markId:\d+>', 'verb'=>'GET'),
            array('REST/maintenance/model/list', 'pattern'=>'REST/maintenance/mark/<markId:\d+>/models', 'verb'=>'GET'),            
            array('REST/maintenance/model/view', 'pattern'=>'REST/maintenance/model/<modelId:\d+>', 'verb'=>'GET'),
            array('REST/maintenance/mod/list', 'pattern'=>'REST/maintenance/model/<modelId:\d+>/mods', 'verb'=>'GET'),            
            array('REST/maintenance/mod/view', 'pattern'=>'REST/maintenance/mod/<modId:\d+>', 'verb'=>'GET'),                          
            array('REST/maintenance/maintenance/count', 'pattern'=>'REST/maintenance/mod/<modId:\d+>/maintenances', 'verb'=>'GET'),        
            array('REST/maintenance/maintenance/view', 'pattern'=>'REST/maintenance/mod/<modId:\d+>/maintenance/<maintOrder:((\d+)|(all))>', 'verb'=>'GET'),                         
            array('REST/zzap/zzap/putModels', 'pattern'=>'REST/zzap/models', 'verb'=>'GET'),
            array('REST/zzap/zzap/putMods', 'pattern'=>'REST/zzap/mods', 'verb'=>'GET'),
            array('REST/zzap/zzap/put', 'pattern'=>'REST/zzap/', 'verb'=>'GET'),
            // Other controllers        
            'to'=>'to/mark',
            'to/mod/<id:\d+>/order/<maintenance_order:\d+>'=>'to/mod/view',
            'to/maintenance/<id:\d+>/order/<maintenance_order:\d+|all>/create'=>'to/maintenance/partCreate',
            'to/maintenance/<id:\d+>/order/<maintenance_order:\d+|all>/delete'=>'to/maintenance/partDelete',
            'to/maintenance/<id:\d+>/part/<part_id:\d+>/edit'=>'to/maintenance/partEdit',

            'to/<controller:\w+>/<id:\d+>'=>'to/<controller>/view',            
            'to/<controller:\w+>/<action:\w+>'=>'to/<controller>/<action>',
            'to/<controller:\w+>/<action:\w+>/<id:\d+>'=>'to/<controller>/<action>',
            'to/<id:\d+>/<controller:\w+>/<action:\w+>/'=>'to/<controller>/<action>',
             
            '/login'=>'site/login',
            '/logout'=>'site/logout',
            //'/authm'=>'site/authm',                        
            'soap/maintenanceParts'=>'SOAP/soap/maintenanceParts', 
            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        ),
      ), 
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
      'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=test_yii',
			'emulatePrepare' => true,
			'username' => 'services',
			'password' => '1f2r3b]',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
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
      'clientScript'=>array(
          'packages'=>array(
              'bootstrap-responsive'=>array(
                  'basePath'=>'ext.bootstrap.assets.',
                  'css'=>array('css/bootstrap-responsive.min.css')
              )
           ) 
      )
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);