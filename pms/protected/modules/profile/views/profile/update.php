<? 
$this->pageTitle = Yum::t( "Profile");
$this->breadcrumbs=array(
		Yum::t('Edit profile'));
$this->title = Yum::t('Edit profile');
?>

<div class="form">

<? echo CHtml::beginForm(); ?>

<? echo Yum::requiredFieldNote(); ?>

<? echo CHtml::errorSummary(array($profile)); ?>

<? if(isset($profile) && is_object($profile)) 
	$this->renderPartial('/profile/_form', array('profile' => $profile)); ?>

	<div class="row buttons">
	<?

	//if(Yum::module('profile')->enablePrivacySetting)
	//	echo CHtml::button(Yum::t('Privacy settings'), array(
					//'submit' => array('/profile/privacy/update'))); ?>

	<? 
		if(Yum::hasModule('avatar'))
			echo CHtml::button(Yum::t('Upload avatar Image'), array(
				'submit' => array('/avatar/avatar/editAvatar'))); ?>

	<? echo CHtml::submitButton($user->isNewRecord 
			? Yum::t('Create my profile') 
			: Yum::t('Save profile changes')); ?>
            
        <?php echo CHtml::Button('Cancel', array('submit' => '/ete/public/index')); ?>
	</div>

	<? echo CHtml::endForm(); ?>

	</div><!-- form -->
