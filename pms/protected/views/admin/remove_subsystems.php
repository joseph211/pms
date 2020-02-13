<?
echo Yum::renderFlash();
 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subremove-form',
	'enableAjaxValidation'=>false,
)); 
?>

<div style="width:840px; margin-left:25px; margin-bottom:20px; height: 50px; background-color: #F4F4F4; border-radius: 5px;">
<table width="820px" height="50px">
<tr>
<td width="80px"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-extension.png" /></td>
<td><h2 style="color: #146295; font-size: 1.2em; font-weight: bold; line-height: 48px; margin: 0; padding: 0">Subsystem Manager: Uninstall</h2></td>
</tr>
</table>
</div>

<div style="width:840px; margin-left:25px; margin-bottom:20px; height: 30px; background-color: #F4F4F4; border-radius: 5px;">
<ul style="list-style-type:none">

<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/upload">Install  </a></li>&nbsp&nbsp&nbsp|
<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/remove">Uninstall </a></li>&nbsp&nbsp&nbsp|
<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/view">View All </a></li>&nbsp&nbsp&nbsp|
<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/update">Update   </a></li>&nbsp&nbsp&nbsp|

</ul>
</div>

<?
$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'filter' => $model,
	'selectableRows' => 2,
		'columns'=>array(
			array(
            'id' => 'selectedIds',
            'class' => 'CCheckBoxColumn'
        ),
			array(
				'id'=>'subsysName',
				'name'=>'subsysName',
				'type'=>'raw',
				'value'=>'$data->subsysName',
			),
			array(
				'id' => 'url',
				'name'=>'Url',
				'filter' => false,
				'value'=>'$data->url',
			),

			
))); 
echo CHtml::submitButton('Uninstall', array('name' => 'UninstallButton'));
$this->endWidget(); 
?>

