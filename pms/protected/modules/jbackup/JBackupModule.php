<?php
/**
 * Backup
 * 
 * Yii module to backup, restore databse and files
 * 
 * @author Juan David Rodriguez R. <jdrodriguez429@gmail.com.com> @juanda1015
 * @copyright 2013 - Juan David Rodriguez Ramirez
 * @license New BSD License
 */
class JBackupModule extends CWebModule
{
	public $path = null;
	public $filter = 'accessControl';
	public $bootstrap = false;
	public $database = true;
	public $download = true;
	public $restore = true;
	public $directoryBackup = array();
	public $excludeDirectoryBackup=array();
	public $excludeFileBackup=array();
	public $directoryRestoreBackup;
        private $_assets;
	public function init(){
                if($this->directoryRestoreBackup == '')
                    $this->directoryRestoreBackup = Yii::getPathOfAlias('webroot');
                $this->registerScripts();
		$this->setImport(array(
			'jbackup.components.*',
			'jbackup.models.*',
		));
	}
        private function registerScripts(){
            
            $cs = Yii::app()->clientScript;
            
            $this->_assets = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
            $cs->registerCoreScript('jquery');
            $cs->registerCssFile($this->_assets .'/css/backup.css');
        }
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
