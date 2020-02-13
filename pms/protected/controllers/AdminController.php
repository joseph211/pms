<?php

class AdminController extends Controller
{
     
		public $layout = '//layouts/admin';
	/**
	 * @var mixed tooltip for the permission menagement
	 */
	public static $_permissionControl = array(
					'write'=>'can invite other users.',
					'admin'=>'can edit other users, ban them and approve their registrations.',
					);

	/**
	 * This is the action to display the adminstrator dashbord. renders the default page for the admin.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	 
	 
	 /** 
	 * return array action filters 
	 */
	 public function filters() 
	 { 
	 
		return array( 'AccessControl', // perform access control for CRUD operations 
					);
	 }
	 
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	/**
	 * This is the action handles the logic for uploading the files into the system.
	 */
	 
	public function actionUpload()
	{
		$dir = Yii::getPathOfAlias('application.uploads');
		$extract = Yii::getPathOfAlias('application.modules');
		$filename=null;

		$module_name = '';
		$uploaded = false;
		$model= new Upload();
		
		if(isset($_POST['Upload']))
		{
			$model->attributes=$_POST['Upload'];
			$file=CUploadedFile::getInstance($model,'file');
			if($model->validate())
			{
				$target_path = $dir.'/'.$file;
				$file->saveAs($dir.'/'.$file->getName());
				$zip = new ZipArchive();
				$x = $zip->open($target_path);
				
				if ($x === true) 
				{
				$zip->extractTo($extract); // extraction  location.
				
				 // get the location of the module and the url of the thumbnail for front page display.
				$name  = explode(".", $file);
				$module_name = $name[0];
                $url = $module_name;
				$iconUrl = Yii::app()->request->baseUrl.'/images/sample.png';
				if (isset(Yii::app()->params['system_name']))
                                {
				 $sys = strtoupper(Yii::app()->params['system_name']);
				}
				else
				{
				 $sys =  strtoupper($module_name);
				}
				
				 $message = "ok";
				 $filenames = glob($extract.'/'.$module_name.'/data/*.sql');
					foreach ($filenames as $sqlFile) 
					{
					if ( file_exists($sqlFile))
						{
							$sqlArray = file_get_contents($sqlFile);

							$cmd = Yii::app()->db->createCommand($sqlArray);
							try
							{
								$cmd->execute();
							}
							catch(CDbException $e)
							{
								$message = $e->getMessage();
							}

						}
					}
                        unset($cmd);
					
				$uploaded = $model->registerSubsystem($sys, $url, $iconUrl);
				
				$zip->close();
				unlink($target_path);
				}
			}
		}
		
		$this->render('form', array(
		'model' => $model,
		'uploaded' => $uploaded,
		'dir' => $dir,
		));
	}
	
	/**
	 * Deletes the installed subsytem from the platform
	 */
	
	public function actionRemove()
	{
		$model = new Subsystem('search');
		
		if (isset($_POST['UninstallButton']))
		{
		   $model->attributes=$_POST['Subsystem'];
		   
		   if (isset($_POST['selectedIds']))
		   {
		     // loop throughout the checkboxes and delete the chosen subsystems.
			 foreach ($_POST['selectedIds'] as $subID)
			 {
				$del = $this->loadModel('Subsystem',$subID);
			    $name = $del->subsysName;
			    $str = Yii::getPathOfAlias('application.modules.').'/'.$name;
				$this->deleteDir( $str);
				$del->delete();
			 }
			 
		   }
		}
		
		$this->render('remove_subsystems',array('model'=>$model,));
	}
	
	/**
	 * Updates the subsystem installed into the platfrm.
	 */
	
	public function actionUpdate()
	{
	 $this->render('index');
	}
	
	public function actionView()
	{
		$this->render('view_subsystems');
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionAcademicYear()
	{
		$model = new Academic;
		$ac = false;
		if (isset($_POST['Save']))
		{
		 $model->attributes = $_POST['Academic'];
		 $model->date_inserted = date('Y-m-d');
		 $model->status = 1;
		 
		 $previous  = Academic::model()->findByAttributes(array('status'=>1));
		 $previous->status = 0;
		 $previous->save();
        
		 $today = date('Y-m-d');
		 $date1 = new DateTime($previous->date_inserted);
		 $date2 = new DateTime($today);
		 $interval = $date1->diff($date2);
		 
		 if ($interval->y >= 1)
		 {
		 
		 $students = YumProfile::model()->findAll(array('condition'=>'user_id IN (SELECT id FROM user WHERE student=:student)','params'=>array(':student'=>1)));
		 foreach ($students as $student)
		 {
		  $degree = Degree::model()->findByPk($student->degreeID);
		  if ($student->year_of_study != $degree->duration)
		  {
				$year_of_study = $student->year_of_study + 1;
				$sql = "UPDATE profile SET year_of_study=:year_of_study WHERE user_id=:user_id";
				$command = Yii::app()->db->createCommand($sql);
				$command->bindValue(":user_id", $student->user_id, PDO::PARAM_INT);
				$command->bindValue(":year_of_study",$year_of_study, PDO::PARAM_INT);
			    $command->execute();
		  }
		 }
		 if ($model->save())
		 {
		  $ac = true;
		 } 
		 
		 }
		 
		}
		
		$this->render('academic_year',array('model'=>$model,'ac'=>$ac));
	}
	
	public function loadModel($type, $id, $errorMessage='The chosen subsytem does not exist', $errorNum=404)
	{
			eval( '$model = '.$type.'::model()->findByPk($id);' );
			if ($model === null)
					throw new CHttpException($errorNum, $errorMessage);
		   
			return $model;
	}
	
	public function deleteDir($str)
	{
		
		if(is_file($str))
		{
            return unlink($str);
        }
        else if(is_dir($str))
		{
            $scan = glob($str.'/*');
            foreach($scan as $index=>$path)
			{
                $this->deleteDir($path);
            }
            return rmdir($str);
        }
	}
	
}