<div id="generalform" class="rounded">
<?php
/* @var $this AdminController */
$this->pageTitle=Yii::app()->name;
?>

<?php echo CHtml::beginForm('','post',array())?>
<div class="field">
<label for="install_directory">Academic Year</label>
<?php echo CHtml::activetextField($model,'academic_year',array('placeholder'=>'e.g 2013/2014','class'=>'input'))?>
<?php echo CHtml::error($model,'academic_year'); ?>
</div>

<div class="row buttons">
<?php echo CHtml::submitButton('Save', array('name'=>'Save','class'=>'button'))?>
</div>

<?php echo CHtml::endForm()?>

<?php if($ac):?>
<p>Academic Year has been saved!.</p>
<?php endif ?>

</div>