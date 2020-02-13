<div id="generalform" class="rounded">

<?php echo CHtml::beginForm(); ?>

<div class="field">
<h3><?php echo Yum::requiredFieldNote(); ?></h3>
</div>

<div class="field">
	<label for="name">Title*</label>
	<?php echo CHtml::activeTextField($model,'title',array('class'=>'input')); ?>
	<?php echo CHtml::error($model,'title'); ?>
</div>

<div class="field">
	<label for="message">Description</label>
	<?php echo CHtml::activeTextArea($model,'description',array('class'=>'input textarea')); ?>
	<?php echo CHtml::error($model,'description'); ?>
</div>


<?php 
// retrieve the models from db
Yii::import('application.modules.usergroup.models.*');
$models = YumUsergroup::model()->findAll();
$list = CHtml::listData($models,'id', 'title');
?>
<div class="field">
	<label for="message">Role to Group</label>
	<?php echo CHtml::dropDownList('id', $model, $list, array('empty' => 'Select a group &nbsp;&nbsp;&nbsp;','size'=>'')); ?>
</div>

<div class="field">
	<label for="message">Role to Users</label>
	<?php
    $this->widget('YumModule.components.Relation', array(
			'model' => $model,
			'relation' => 'users',
			'style' => 'dropdownlist',
			'fields' => 'username',
			'htmlOptions' => array(
				'checkAll' => Yum::t('Choose All'),
				'template' => '<div style="float:left;margin-right:5px;">{input}</div>{label}'),
			'showAddButton' => false
			));  
   ?>
</div>

<div class="row buttons">
<? echo CHtml::submitButton($model->isNewRecord? Yum::t('Create role'): Yum::t('Save role'),array( 'class'=>'button')); ?>
</div>

<? echo CHtml::endForm(); ?>
</div><!-- form -->

