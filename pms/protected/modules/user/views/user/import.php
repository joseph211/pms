<div id="generalform" class="rounded">
<h3>Choose an excel file (97-03) to import</h3>
<?php echo Yum::renderFlash(); ?>
<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'import_students',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<?php echo $form->errorSummary($model); ?>

<div class="field">
<label for="install_directory">Degree Program</label>
<?php echo $form->dropDownList($degree,'degreeName', CHtml::listData(Degree::model()->findAll(), 'id', 'degreeName'), 
		  array('empty'=>'Select a degree  Program','data-rel'=>'chosen'));?>
</div>		  

<div class="field">		  
<label for="install_directory">Import File</label>
<?php echo $form->fileField($model, 'list',array('size'=>'59'))?>
</div>

<div class="row buttons">
<?php echo CHtml::submitButton('Import', array('name'=>'Upload','class'=>'button'))?>
</div>

<?php $this->endWidget(); ?>

<?php if($uploaded):?>
<p>List of students was successful uploaded!.</p>
<?php endif ?>


</div>
<div style="clear:both;"></div>
