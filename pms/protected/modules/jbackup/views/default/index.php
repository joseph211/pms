<?php /** @var DefaultController $this */?>
<?php
Yii::app()->clientScript->registerScript(
   'HideAlert',
   '$(".alert-success, .alert-error").animate({opacity: 1.0}, 10000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>
<h1><?php echo JBackupTranslator::t('backup', 'Manage Backup')?></h1>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="alert-success" style="text-align: center; margin: 10px 0 10px 0; padding: 10px;">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php elseif(Yii::app()->user->hasFlash('error')):?>
    <div class="alert-error" style="text-align: center; margin: 10px 0 10px 0; padding: 10px;">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php
    $cs = Yii::app()->clientscript;
    $afterAjax = '';
    if($this->module->bootstrap){
        $cs->registerScript('backup','
            $(function (){
                $(".bdownload").html("<i class=\'icon-arrow-down\'></i>");
                $(".brestore").html("<i class=\'icon-repeat\'></i>");
            });
        ',CClientScript::POS_HEAD);
        $afterAjax = '$(".bdownload").html("<i class=\'icon-arrow-down\'></i>"); $(".brestore").html("<i class=\'icon-repeat\'></i>");';
    }else{
        $cs->registerScript('backup','
            $(function (){
                $(".download").text("");
                $(".restore").html("");
            });
        ',CClientScript::POS_HEAD);
        $cs->registerCss('backup','
            .delete{
                margin: 1px;
                float:left;
            }
        ');
        $afterAjax = '$(".download").text(""); $(".restore").html("");';
    }
    $this->widget($this->gridViewClass, array(
            'id' => 'backup-grid',
            'afterAjaxUpdate' => 'function(id, data){'.$afterAjax.'}',
            'dataProvider' => $dataProvider,
            'columns' => array(
                    array(
                        'name'=>'name',
                        'header'=>JBackupTranslator::t('backup', 'Name'),
                    ),
                    array(
                        'name'=>'size',
                        'header'=>JBackupTranslator::t('backup', 'Size'),
                    ),
                    array(
                        'name'=>'create_time',
                        'header'=>JBackupTranslator::t('backup', 'Create Time'),
                    ),
                    array(
                            'class' => $this->CButtonColumnClass,
                            'deleteButtonUrl' =>'Yii::app()->createUrl("/backup/default/delete", array("file"=>$data["name"]))',
                            'template' => '{download} {restore} {delete}',
                            'htmlOptions'=>array('style'=>'width: 60px;'),
                            'buttons'=>array(
                                    'download' => array(
                                        'label'=>JBackupTranslator::t('backup', 'Download'),
                                        'options'=>array('class'=>$this->module->bootstrap ?'bdownload': 'download'),
                                        'url'=>'Yii::app()->createUrl("/backup/default/download", array("file"=>$data["name"]))',
                                        'visible'=>'Yii::app()->getModule("'.$this->module->id.'")->download'
                                    ),
                                    'restore' => array(
                                        'label'=>JBackupTranslator::t('backup', 'Restore'),
                                        'options'=>array('class'=>$this->module->bootstrap ?'brestore':'restore'),
                                        'url'=>'Yii::app()->createUrl("/backup/default/restore", array("file"=>$data["name"]))',
                                        'visible'=>'Yii::app()->getModule("'.$this->module->id.'")->restore'
                                    ),
                             ),		
                    ),
            ),
    )); 
?>
