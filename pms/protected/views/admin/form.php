<?php
/* @var $this AdminController */
$this->pageTitle=Yii::app()->name;
?>

<div style="width:840px; margin-left:25px; margin-bottom:20px; height: 50px; background-color: #F4F4F4; border-radius: 5px;">
<table width="820px" height="50px">
<tr>
<td width="80px"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-extension.png" /></td>
<td><h2 style="color: #146295; font-size: 1.2em; font-weight: bold; line-height: 48px; margin: 0; padding: 0">Subsystem Manager: Install</h2></td>
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

<div style="width:840px; margin-left:25px; margin-bottom:20px; background-color: #F4F4F4; border-radius: 5px;">

<fieldset style="min-width: 100px; margin-bottom: 30px; border-radius: 5px; margin-top: 20px; clear: left">
<legend>Upload Package File</legend>
<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data'))?>
<?php echo CHtml::error($model, 'file')?>
<label for="install_directory">Install Package</label>
<?php echo CHtml::activeFileField($model, 'file',array('size'=>'59'))?>
<?php echo CHtml::submitButton('Install', array('name'=>'Upload'))?>
<?php echo CHtml::endForm()?>

<?php if($uploaded):?>
<p>The subsystem was successiful installed!!.</p>
<?php endif ?>
</fieldset>

<fieldset style="min-width: 100px; border-radius: 5px; margin-bottom: 30px; clear: left">
<legend>Install from Directory</legend>
<?php echo CHtml::beginForm('../admin/directory','post')?>
<?php echo CHtml::error($model, 'dir')?>
<label for="install_directory">Install Directory</label>
<?php echo CHtml::activeTextField($model, 'dir', array('size'=>'71', 'value'=>'/protected/uploads/'))?>
<?php echo CHtml::submitButton('Install',  array('name'=>'Dir')); ?>
<?php echo CHtml::endForm()?>

</fieldset>

<fieldset style="min-width: 100px; border-radius: 5px; margin-bottom: 30px; clear: left">
<legend>Install from URL</legend>
<?php echo CHtml::beginForm('../admin/directory','post')?>
<?php echo CHtml::error($model, 'dir')?>
<label for="install_url">Install URL</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo CHtml::activeTextField($model, 'dir', array('size'=>'70', 'value'=>'http://'))?>
<?php echo CHtml::submitButton('Install',  array('name'=>'Dir')); ?>
<?php echo CHtml::endForm()?>
</fieldset>

</div>