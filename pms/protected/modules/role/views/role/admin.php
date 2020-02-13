<?

$this->breadcrumbs=array(
	Yum::t('Roles')=>array('index'),
	Yum::t('Manage'),
);

?>
<h1> <? echo Yum::t('Manage roles'); ?> </h1>

<? $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'title',
			'type' => 'raw',
			'value'=> 'CHtml::link(CHtml::encode($data->title),
				array("//role/role/view","id"=>$data->id))',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
