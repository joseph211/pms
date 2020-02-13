
<h1><?php echo JBackupTranslator::t('backup','Upload Backup'); ?></h1>

<div class="form">


<?php
    /**
     * @var $form CActiveForm 
     */
    $form = $this->beginWidget($this->module->bootstrap ? 'bootstrap.widgets.TbActiveForm': 'CActiveForm', array(
            'id' => 'install-form',
            'enableAjaxValidation' => false,
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    ));
    if($this->module->bootstrap)
        $form->type = 'horizontal';
?>
    <?php 
        if($this->module->bootstrap) {
            echo $form->fileFieldRow($model,'upload_file');
        }else{
    ?>
        <div class="row">
                <?php echo $form->labelEx($model,'upload_file'); ?>
                <?php echo $form->fileField($model,'upload_file'); ?>
                <?php echo $form->error($model,'upload_file'); ?>
        </div><!-- row -->
    <?php }?>
<?php
	echo CHtml::submitButton(JBackupTranslator::t('backup', 'Upload'));
	$this->endWidget();
?>
</div><!-- form -->