<div id="generalform" class="rounded">
<? $form=$this->beginWidget('CActiveForm', array(
	'id'=>'action-form',
	'enableAjaxValidation'=>false,
)); 
?>
<div class="field">
<h3><?php echo Yum::requiredFieldNote(); ?></h3>
</div>

    <div class="field">
	<label for="name">Title*</label>
	<?php echo $form->textField($model,'title',array('class'=>'input')); ?>
	<?php echo $form->error($model,'title'); ?>
    </div>
	
	<div class="field">
	<label for="name">Comment</label>
	<?php echo $form->textArea($model,'comment',array('class'=>'input textarea')); ?>
	<?php echo $form->error($model,'comment'); ?>
    </div>

	
   <div class="field">
	<label for="name">Subject</label>
	<?php echo $form->textField($model,'subject',array('class'=>'input')); ?>
	<?php echo $form->error($model,'subject'); ?>
    </div>
	
	<div class="row buttons">
	<? echo CHtml::submitButton($model->isNewRecord? Yum::t('Create Action'): Yum::t('Save Action'),array('class'=>'button')); ?>
	</div>

<? $this->endWidget(); ?>

</div><!-- form -->
