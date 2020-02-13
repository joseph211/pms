<div id="generalform" class="rounded">
<? 

$form = $this->beginWidget('CActiveForm', array(
			'id'=>'user-form',
			'enableAjaxValidation'=>false));
?>
<div class="field">
<h3><?php echo Yum::requiredFieldNote(); ?></h3>
<?php
$models = array($model, $passwordform);
if(isset($profile) && $profile !== false)
	$models[] = $profile;
	?>
</div>

<div style="float: right; margin: 10px;">

<div class="field">
<?php echo $form->labelEx($model,'superuser',array());
echo $form->dropDownList($model,'superuser',YumUser::itemAlias('AdminStatus'));
echo $form->error($model,'superuser'); ?>
</div>

<div class="field">
<?php echo $form->labelEx($model,'status',array());
echo $form->dropDownList($model,'status',YumUser::itemAlias('UserStatus'));
echo $form->error($model,'status'); ?>
</div>

<?php if(Yum::hasModule('role')) { 
	Yii::import('application.modules.role.models.*');
?>
<div class="field">
<label for="name"><?php echo Yum::t('User roles'); ?> </label>

	<?php $this->widget('YumModule.components.Relation', array(
				'model' => $model,
				'relation' => 'roles',
				'style' => 'dropdownlist',
				'fields' => 'title',
				'showAddButton' => false,
				)); ?>
</div>
<?php } ?>

</div>


<div class="field">
<?php echo $form->labelEx($model, 'username',array());
echo $form->textField($model, 'username',array());
echo $form->error($model, 'username'); ?>
</div>


<div class="field">
<?php $this->renderPartial('/user/passwordfields', array(
			'form'=>$passwordform)); ?>
</div>
<?php if(Yum::hasModule('profile')) 
$this->renderPartial('application.modules.profile.views.profile._form', array(
			'profile' => $profile)); ?>

<div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord? Yum::t('Create'): Yum::t('Save'),array('class'=>'button')); ?>
</div>

<?php $this->endWidget(); ?>
</div>
<div style="clear:both;"></div>

