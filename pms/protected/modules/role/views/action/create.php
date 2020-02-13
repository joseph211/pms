<?
$this->breadcrumbs=array(
	Yum::t('Actions')=>array('index'),
	Yum::t('Create'),
);

?>

<? echo $this->renderPartial('_form', array('model'=>$model)); ?>
