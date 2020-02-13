<?
if(!isset($model)) 
	$model = new YumUserLogin();

$module = Yum::module();

$this->pageTitle = Yum::t('Login');
if(isset($this->title))
$this->title = Yum::t('ETE Login');
$this->breadcrumbs=array(Yum::t('Login'));

Yum::renderFlash();
?>

<?
 if ($model->hasErrors())
 {
  echo '<div class="text_box" style="float:right;">';
  echo CHtml::errorSummary($model); 
  echo '</div>';
 }
 
?>

<div class="text_box">

<? echo CHtml::beginForm(array('//user/auth/login'));  ?>

<?
if(isset($_GET['action']))
	echo CHtml::hiddenField('returnUrl', urldecode($_GET['action']));
?>

	
	<div class="row">
		<? 
		if($module->loginType & UserModule::LOGIN_BY_USERNAME 
				|| $module->loginType & UserModule::LOGIN_BY_LDAP)
		//echo CHtml::activeLabelEx($model,'username'); 
		echo '<label class="login_label">Username:</label>';
		if($module->loginType & UserModule::LOGIN_BY_EMAIL)
			printf ('<label for="YumUserLogin_username">%s <span class="required">*</span></label>', Yum::t('E-Mail address')); 
		if($module->loginType & UserModule::LOGIN_BY_OPENID)
			printf ('<label for="YumUserLogin_username">%s <span class="required">*</span></label>', Yum::t('OpenID username'));  ?>

		<? echo CHtml::activeTextField($model,'username') ?>
	</div>
	
	<div class="row">
		<? //echo CHtml::activeLabelEx($model,'password'); 
		    echo '<label class="login_label">Password:</label>';
		?>
		<? echo CHtml::activePasswordField($model,'password');
		if($module->loginType & UserModule::LOGIN_BY_OPENID)
			echo '<br />'. Yum::t('When logging in with OpenID, password can be omitted');
 ?>
		
	</div>
	
	<div class="row">
	<p class="hint">
	<?
	/*
	if(Yum::hasModule('registration') && Yum::module('registration')->enableRegistration)
	echo CHtml::link(Yum::t("Registration"),
			Yum::module('registration')->registrationUrl);
	if(Yum::hasModule('registration') 
			&& Yum::module('registration')->enableRegistration
			&& Yum::module('registration')->enableRecovery)
	echo ' | ';*/
	if(Yum::hasModule('registration') 
			&& Yum::module('registration')->enableRecovery) 
	echo CHtml::link(Yum::t("Lost password?"),
			Yum::module('registration')->recoveryUrl);
	?>
</p>
	</div>

<div class="row rememberMe">
<? echo CHtml::activeCheckBox($model,'rememberMe', array('style' => 'display: inline;')); ?>
<? echo CHtml::activeLabelEx($model,'rememberMe', array('style' => 'display: inline;')); ?>
</div>

<div class="row submit">
<? //echo CHtml::submitButton(Yum::t('Login')); ?>
<input type="image" src="<?php echo Yii::app()->baseUrl; ?>/images/public/login.gif" class="login" />
</div>

<? echo CHtml::endForm(); ?>
</div><!-- form -->

<?
$form = new CForm(array(
			'elements'=>array(
				'username'=>array(
					'type'=>'text',
					'maxlength'=>32,
					),
				'password'=>array(
					'type'=>'password',
					'maxlength'=>32,
					),
				'rememberMe'=>array(
					'type'=>'checkbox',
					)
				),

			'buttons'=>array(
				'login'=>array(
					'type'=>'submit',
					'label'=>'Login',
					),
				),
			), $model);
?>

