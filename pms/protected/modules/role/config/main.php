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
			'roleTable' => 'role',
			'userRoleTable' => 'user_role',
			'usergroupRoleTable'=> 'usergroup_role',
			'actionTable' => 'action',
			'permissionTable' => 'permission',
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

