<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/form-site.css" />
<?php

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>
<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>
<?php else: ?>

<div id="contactform" class="rounded">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
<div class="title">Contact US</div>

<div class="field">
	<label for="name">Name*</label>
	<?php echo $form->textField($model,'name',array('class'=>'input')); ?>
	<?php echo $form->error($model,'name'); ?>
	<p class="hint">Enter your name.</p>
</div>

<div class="field">
	<label for="email">Email*</label>
  	<?php echo $form->textField($model,'email',array('class'=>'input')); ?>
    <?php echo $form->error($model,'email'); ?>
	<p class="hint">Enter your email.</p>
</div>

<div class="field">
	<label for="email">Subject(Title)*</label>
  	<?php echo $form->textField($model,'subject',array('class'=>'input','size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'subject'); ?>
	<p class="hint">Enter your subject.</p>
</div>

<div class="field">
	<label for="message">Body*</label>
	<?php echo $form->textArea($model,'body',array('class'=>'input textarea')); ?>
	<?php echo $form->error($model,'body'); ?>
	<p class="hint">Write your message body.</p>
</div>

<div class="field">
	<label for="email">Captcha</label>
  	<?php $this->widget('CCaptcha'); ?>
</div>

<div class="field">
	<label for="email">Verify Captcha*</label>
	<?php echo $form->textField($model,'verifyCode',array('class'=>'input')); ?>
	<?php echo $form->error($model,'verifyCode'); ?>
	<p class="hint">Enter the letters as shown in captcha.</p>
</div>

<input type="submit" name="Submit"  class="button" value="Submit" />
<?php $this->endWidget(); ?>
</div>
<?php endif; ?>