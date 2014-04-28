<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.widgets.*',
        'ext.PHPExcel.*',
    ),
    // application components
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=115.28.77.119;port=3306; dbname=golf',
            'emulatePrepare' => true,
            'enableProfiling'=>true,
            'username' => 'root',
            'password' => 'qgolf@1qazxcde3',
            'charset' => 'utf8',
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
