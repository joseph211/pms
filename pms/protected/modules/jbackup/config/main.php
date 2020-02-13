<?php
$module_name = basename(dirname(dirname(__FILE__)));
$default_controller = 'default';
 
return array(
    'import' => array(
        'application.modules.' . $module_name . '.models.*',
    ),
    
    'modules' => array(
        $module_name => array(
            'defaultController' => $default_controller,
			'path' => __DIR__.'/../_backup/', //Directory where backups are saved
			'layout' => '//layouts/admin', //2-column layout to display the options
			'filter' => 'accessControl', //filter or filters to the controller
			'bootstrap' => false, //if you want the module use bootstrap components
			'download' => true, // if you want the option to download
			'restore' => true, // if you want the option to restore
			'database' => true, //whether to make backup of the database or not
			//directory to consider for backup, must be made array key => value array ($ alias => $ directory)
			'directoryBackup'=>array( 
			   'folder/'=> __DIR__.'/../../folder/',
			),
			//directory sebe not take into account when the backup
			'excludeDirectoryBackup'=>array(
			   __DIR__.'/../../folder/folder2/',
			),
			//files sebe not take into account when the backup
			'excludeFileBackup'=>array(
			   __DIR__.'/../../folder/folder1/cfile.png',
			),
			//directory where the backup should be done default Yii::getPathOfAlias('webroot')
			'directoryRestoreBackup'=>__DIR__.'/../../'
        ),
    ),
    
    'components' => array(
        'urlManager' => array(
            'rules' => array(
                $module_name . '/<action:\w+>/<id:\d+>' => $module_name . '/' . $default_controller . '/<action>',
                $module_name . '/<action:\w+>' => $module_name . '/' . $default_controller . '/<action>',
            ),
        ),
    ),
);

