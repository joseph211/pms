<?php
class Upload extends CFormModel
{
	public $file;
	public $dir;
	
	public function rules()
	{
		return array(
		array('file', 'file', 'types'=>'zip'),
		);
	}
	
	
	public function registerSubsystem($name, $url, $iconUrl)
	{
		$sql = "INSERT INTO subsystem (subsysName, url,iconUrl) VALUES (:subsysName, :url, :iconUrl)";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":subsysName", $name, PDO::PARAM_STR);
		$command->bindValue(":url", $url, PDO::PARAM_STR);
		$command->bindValue(":iconUrl", $iconUrl, PDO::PARAM_STR);
		return $command->execute();
               
	}
}