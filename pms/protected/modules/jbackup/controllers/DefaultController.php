<?php
/**
 * Backup
 *
 * Yii module to backup, restore databse adn files
 *
 * @author Juan David Rodriguez R. <jdrodriguez429@gmail.com.com> @juanda1015
 * @copyright 2013 - Juan David Rodriguez Ramirez
 * @license New BSD License
 */
class DefaultController extends Controller
{
	public $layout = '//layouts/admin';
    
    private $tables = array();
	private $fp ;
	private $file_name;
	private $file_db_name;
	private $_path = null;
	private $back_temp_file = 'backup_';
	private $back_bd_temp_file = 'database.sql';
        protected  $gridViewClass;
        protected  $CButtonColumnClass;

	public function init(){
            $this->layout = $this->module->layout;
            $this->pageTitle = Yii::app()->name.' - '.JBackupTranslator::t('backup','Backup');
            $this->gridViewClass = $this->module->bootstrap ? 'bootstrap.widgets.TbGridView' : 'zii.widgets.grid.CGridView';
            $this->CButtonColumnClass = $this->module->bootstrap ? 'bootstrap.widgets.TbButtonColumn' : 'CButtonColumn';
            parent::init();
        }

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array($this->module->filter);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
            if($this->module->filter === 'accessControl'){
                return array(
                    array('allow', 
                        'actions'=>array('admin','delete','index','create','upload', 'download','restore'),
                        'users'=>array('admin'),
                    ),
		);
            }else{
                return array();
            }
		
	}
        /**
         * Path where you store backups
         * @return string  $this->_path
         */
	protected function getPath()
	{
		if ( isset ($this->module->path )) $this->_path = $this->module->path;
		else $this->_path = Yii::app()->basePath .'/../_backup/';

		if ( !file_exists($this->_path ))
		{
			mkdir($this->_path );
			chmod($this->_path, '777');
		}
		return $this->_path;
	}
        
        /**
         * Structuring method manager columns of the table and return
         * @param string $tableName
         * @return string query with sentences in the table 
         */
	private function getColumns($tableName)
	{
		$sql = 'SHOW CREATE TABLE '.$tableName;
		$cmd = Yii::app()->db->createCommand($sql);
		$table = $cmd->queryRow();

		$create_query = $table['Create Table'] . '~';

		$create_query  = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
		//$create_query = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $create_query);
		if ( $this->fp)
		{
			$this->writeComment('TABLE `'. addslashes ($tableName) .'`');
			$final = 'DROP TABLE IF EXISTS `' .addslashes($tableName) . '`~'.PHP_EOL. $create_query .PHP_EOL.PHP_EOL;
			fwrite ( $this->fp, $final );
		}
		else
		{
			$this->tables[$tableName]['create'] = $create_query;
			return $create_query;
		}
	}
        /**
         * Method of structuring data manager table and return
         * @param type $tableName
         * @return null|string query with sentences in the table 
         */
	private function getData($tableName)
	{
		$sql = 'SELECT * FROM '.$tableName;
		$cmd = Yii::app()->db->createCommand($sql);
		$dataReader = $cmd->query();

		$data_string = '';

		foreach($dataReader as $data)
		{
			$itemNames = array_keys($data);
			$itemNames = array_map("addslashes", $itemNames);
			$items = join('`,`', $itemNames);
			$itemValues = array_values($data);
			$itemValues = array_map("addslashes", $itemValues);
			$valueString = join("','", $itemValues);
			$valueString = "('" . $valueString . "'),";
			$values ="\n" . $valueString;
			if ($values != "")
			{
				$data_string .= "INSERT INTO `$tableName` (`$items`) VALUES" . rtrim($values, ",") . "~" . PHP_EOL;
			}
		}

		if ( $data_string == '')
		return null;
			
		if ( $this->fp)
		{
			$this->writeComment('TABLE DATA '.$tableName);
			$final = $data_string.PHP_EOL.PHP_EOL.PHP_EOL;
			fwrite ( $this->fp, $final );
		}
		else
		{
			$this->tables[$tableName]['data'] = $data_string;
			return $data_string;
		}
	}
        /**
         * Method manager tables list the database
         * @param string $dbName
         * @return array $tables with table names
         */
	private function getTables($dbName = null)
	{
		$sql = 'SHOW TABLES';
		$cmd = Yii::app()->db->createCommand($sql);
		$tables = $cmd->queryColumn();
		return $tables;
	}
        /**
         * Method to start the backup
         * @param boolean $addcheck
         * @return boolean
         */
	private function StartBackup($addcheck = true)
	{
		$this->file_db_name =  $this->path . $this->back_bd_temp_file;

		$this->fp = fopen( $this->file_db_name, 'w+');

		if ( $this->fp == null )
		return false;
		fwrite ( $this->fp, '-- -------------------------------------------~'.PHP_EOL );
		if ( $addcheck )
		{
			/*fwrite ( $this->fp,  'SET AUTOCOMMIT=0~' .PHP_EOL );
			fwrite ( $this->fp,  'START TRANSACTION~' .PHP_EOL );*/
			fwrite ( $this->fp,  'SET SQL_QUOTE_SHOW_CREATE = 1~'  .PHP_EOL );
		}
		fwrite ( $this->fp, 'SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0~'.PHP_EOL );
		fwrite ( $this->fp, 'SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0~'.PHP_EOL );
		fwrite ( $this->fp, '-- -------------------------------------------~'.PHP_EOL );
		$this->writeComment('START BACKUP');
		return true;
	}
        /**
         * Method to end the backup
         * @param boolean $addcheck
         */
	private function EndBackup($addcheck = true)
	{
		fwrite ( $this->fp, '-- -------------------------------------------~'.PHP_EOL );
		fwrite ( $this->fp, 'SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS~'.PHP_EOL );
		fwrite ( $this->fp, 'SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS~'.PHP_EOL );

		if ( $addcheck )
		{
			fwrite ( $this->fp,  'COMMIT~' .PHP_EOL );
		}
		fwrite ( $this->fp, '-- -------------------------------------------~'.PHP_EOL );
		$this->writeComment('END BACKUP');
		fclose($this->fp);
		$this->fp = null;
	}
        /**
         * Method to write comments in the sql file
         * @param string $string
         */
	private function writeComment($string)
	{
		fwrite ( $this->fp, '-- -------------------------------------------~'.PHP_EOL );
		fwrite ( $this->fp, '-- '.$string.'~' .PHP_EOL );
		fwrite ( $this->fp, '-- -------------------------------------------~'.PHP_EOL );
	}
        /**
         * Method responsible for backing up database
         * @param array $tables
         */
        private function createBackupDb($tables){
            if(!$this->StartBackup()){
                    //render error
                    $this->render('create');
                    return;
            }

            foreach($tables as $tableName)
                    $this->getColumns($tableName);
            
            foreach($tables as $tableName)
                    $this->getData($tableName);
            
            $this->EndBackup(false);
        }
        /**
         * Method responsible for reading a directory and add them to the zip
         * @param ZipArchive $zip
         * @param string $alias
         * @param string $directory
         */
        private function zipDirectory($zip,$alias,$directory){
            if($handle = opendir($directory)){
                while (($file = readdir($handle)) !== false){ 
                    if (is_dir($directory.$file) && $file!="." && $file!=".." && !in_array($directory.$file.'/', $this->module->excludeDirectoryBackup))
                        $this->zipDirectory ($zip,$alias.$file.'/',$directory.$file.'/');
                    
                    if(is_file($directory.$file) && !in_array($directory.$file, $this->module->excludeFileBackup)){
                         $zip->addFile($directory.$file,$alias.$file);
                    }
                }
                closedir($handle);
            }
        }
        /**
         * Charge method to backup and create a zip with this
         */
        private function createZipBackup(){
            set_time_limit(3600);
            $zip = new ZipArchive;       
            if ($zip->open($this->file_name,ZIPARCHIVE::CREATE) === TRUE){
                    if($this->module->database)
                            $zip->addFile($this->file_db_name,$this->back_bd_temp_file);
                    
                    foreach($this->module->directoryBackup as $alias=>$directory){
                            if(is_dir($directory) && !in_array($directory, $this->module->excludeDirectoryBackup))
                                $this->zipDirectory ($zip,$alias,$directory);
                            if(is_file($directory) && !in_array($directory, $this->module->excludeFileBackup))
                                $zip->addFile($directory,$alias);
                    }
                    $zip->close();
                    if($this->module->database)
                        $this->actionDelete($this->back_bd_temp_file);
            }
        }
        /**
         * Create the backup
         */
        public function actionCreate()
	{
                if($this->module->database){
                    $tables = $this->getTables(); 
                    $this->createBackupDb($tables);
                }
                $this->back_temp_file = $this->back_temp_file . date('Y.m.d_H.i.s') . '.zip';
                $this->file_name = $this->path . $this->back_temp_file;
                try{
                    $this->createZipBackup();
                    Yii::app()->user->setFlash('success',JBackupTranslator::t('backup','Successfully Create the backup file:',array('{backup}'=>$this->back_temp_file)));
                }catch(Exception $e){
                    $this->actionDelete($this->back_temp_file);
                    if($this->module->database)
                        $this->actionDelete($this->back_bd_temp_file);
                    Yii::app()->user->setFlash('success',JBackupTranslator::t('backup','Failed to create the backup:',array('{backup}'=>$this->back_temp_file)));
                }
                
		$this->redirect(array('index'));
	}
        /**
         * Delete the backup
         * @param string $file Backup file name 
         * @throws CHttpException If the file does not exist
         */
	public function actionDelete($file = null)
	{
		if ( isset($file)){
			$zipFile = $this->getPath() . basename($file);
			if ( file_exists($zipFile))
                            unlink($zipFile);
		}
		else throw new CHttpException(404,JBackupTranslator::t('backup', 'File not found'));
		$this->actionIndex();
	}
        /**
         * Download the backup
         * @param string $file Backup file name 
         * @throws CHttpException If the file does not exist
         */
	public function actionDownload($file = null)
	{
		$this->updateMenuItems();
		if ( isset($file))
		{
			$ziplFile = $this->getPath() . basename($file);
			if ( file_exists($ziplFile))
			{
				$request = Yii::app()->getRequest();
				$request->sendFile(basename($file),file_get_contents($ziplFile));
			}
		}
		throw new CHttpException(404,JBackupTranslator::t('backup', 'File not found'));
	}
        /**
         * lists the available backups
         */
	public function actionIndex()
	{
		$this->updateMenuItems();
		$path = $this->path;
		
		$dataArray = array();
		
		$list_files = glob($path .'*.zip');
		if ($list_files )
		{
			$list = array_map('basename',$list_files);
			sort($list);

	
			foreach ( $list as $id=>$filename )
			{
				$columns = array();
				$columns['id'] = $id;
				$columns['name'] = basename ( $filename);
				$columns['size'] = floor(filesize ( $path. $filename)/ 1024) .' KB';
				$columns['create_time'] = JBackupTranslator::t('backup',date('F',filectime($path .$filename))).'-'.date('d-Y g:i A', filectime($path .$filename) );
				$dataArray[] = $columns;
			}
		}
		$dataProvider = new CArrayDataProvider($dataArray);
		$this->render('index', array(
			'dataProvider' => $dataProvider,
                        'keyAttribute'=>'id'
		));
	}
        /**
         * Sql file execution
         * @param string $sqlFile Name of file sql
         */
	private function execSqlFile($sqlFile)
	{
		if (file_exists($sqlFile)){
                      $querys = explode('~',file_get_contents($sqlFile));
                      $connection = Yii::app()->db;
                      $transaction=$connection->beginTransaction();
                      try
                      {
                        foreach($querys as $query)
                            $connection->createCommand($query)->execute();
                        
                        $transaction->commit();
                      }
                      catch(Exception $e) 
                      {
                        $transaction->rollback();
                      }
                      

		}else{
                    throw new CHttpException(404,JBackupTranslator::t('backup', 'File not found'));
                }
	}
        /**
         * Zip file execution
         * @param string $zipFile Name of file zip
         */
	private function execZipFile($zipFile)
	{
                $zip = new ZipArchive;
                $res = $zip->open($zipFile);
                if ($res === TRUE){
                    $zip->extractTo($this->module->directoryRestoreBackup);
                    $zip->close();
                    $this->execSqlFile(basename($this->module->directoryRestoreBackup.'/database.sql'));
                    $this->actionDelete(basename($this->module->directoryRestoreBackup.'/database.sql'));
                }
	}
        /**
         * Restore a backup
         * @param string $file Backup file name 
         */
	public function actionRestore($file = null)
	{
                set_time_limit(36000);
		if(isset($file)){
                    try{
                        $this->execZipFile($this->getPath() . basename($file));
                        Yii::app()->user->setFlash('success', JBackupTranslator::t('backup','Successfully restored the backup file:',array('{backup}'=>basename($file))));
                    }catch(Exception $e){
                        Yii::app()->user->setFlash('error',$e() /*JBackupTranslator::t('backup','Unable to restore backup correctly:',array('{backup}'=>basename($file)))*/);
                    }
                }
		$this->redirect(array('index'));
	}
        /**
         * Upload backup
         */
	public function actionUpload()
	{
                $this->updateMenuItems();
		$model= new UploadForm('upload');
                if(isset($_POST['ajax']) && $_POST['ajax']==='install-form')
		{
                        echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['UploadForm']))
		{
			$model->attributes = $_POST['UploadForm'];
			$model->upload_file = CUploadedFile::getInstance($model,'upload_file');
			if($model->validate() && $model->upload_file->saveAs($this->path . $model->upload_file)){
                            
				Yii::app()->user->setFlash('success',JBackupTranslator::t('backup','Uploaded the file is successfully'));
				$this->redirect(array('index'));
			}
		}

		$this->render('upload',array('model'=>$model));
	}
        /**
         * Updates the menu items for options
         */
	protected function updateMenuItems(){

		switch( $this->action->id){
			case 'upload':
				{
					$this->menu[] = array('label'=>JBackupTranslator::t('backup', 'List Backup'), 'url'=>array('index'));
					$this->menu[] = array('label'=>JBackupTranslator::t('backup', 'Create Backup'), 'url'=>array('create'));
				}
				break;
			default:
				{
					$this->menu[] = array('label'=>JBackupTranslator::t('backup', 'List Backup'), 'url'=>array('index'));
					$this->menu[] = array('label'=>JBackupTranslator::t('backup', 'Create Backup'), 'url'=>array('create'));
					$this->menu[] = array('label'=>JBackupTranslator::t('backup', 'Upload Backup'), 'url'=>array('upload'));
				}
				break;
		}
	}
}
