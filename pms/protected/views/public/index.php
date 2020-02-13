<?php
/* @var $this SiteController */
if(Yii::app()->user->isAdmin()) 
	{
	 $this->redirect(array('/admin'));
	}
$this->pageTitle=Yii::app()->name;

?>
<div class="center_left">
      <div class="title_welcome"><span class="red">CoICT</span> Services Hosting Control Panel</div>
      <div class="welcome_box">
        <p class="welcome"> <span class="orange">Welcome to CoICT Service Hosting Control Panel  </span><br />
            The  <b> College of Information and Communication Technilogies</b> has various systems running in its 
            daily operation. This Service Host control panel aim at collecting together the services and give a user 
            easy access to those Services being offered by the college. Welcome and Enjoy</p>
    </div>
	<?php 
	 $subsystems = Subsystem::model()->findAll();
	 
	 if (!$subsystems)
	 {
	 ?>
	  <div class="features">
       <div class="title">Currently No systems are available!</div>
	  </div>
	<?php
	}
	 else
	 {
	?>
      <div class="features">
        <div class="title">Available systems</div>
        <ul class="list">
		<?php if(Yii::app()->user->isGuest) 
		{
		 $SN =1;
		 foreach ( $subsystems as  $subsystem)
		 {
		?>
         <li><span><?php echo $SN; ?></span><a href="#" onClick="return confirm('You need to be logged in to Access the subsystems!')"><?php echo $subsystem->subsysName; ?></a></li>
		<?php 
		 $SN++;
		}
		} 
		else 
		{
		 $SN =1;
		 foreach ( $subsystems as  $subsystem)
		 {
		?>
		<li><span><?php echo $SN; ?></span><a href="<?php echo Yii::app()->createUrl('/'.$subsystem->url); ?>"><?php echo $subsystem->subsysName; ?></a></li>
		<?php 
		$SN++;
		}
		}
		?>
        </ul>
      </div>
	  <?php }?>
      <div class="features">
      </div>
    </div>
    <div class="center_right">
     <?php
         if (Yii::app()->user->isGuest){
    	 if(!isset($model)) 
		$model = new YumUserLogin();
		$module = Yum::module();
		if(isset($this->title))
		$this->title = Yum::t('Login');
		$this->breadcrumbs=array(Yum::t('Login'));

		Yum::renderFlash();
		
		echo CHtml::beginForm(array('//user/auth/login')); 
		if(isset($_GET['action']))
			echo CHtml::hiddenField('returnUrl', urldecode($_GET['action']));
    ?>
      <div class="text_box" style="margin-top:55px;">
        <div class="title">CoICT Login</div>
        <div class="login_form_row">
          <label class="login_label">Username:</label>
          <? echo CHtml::activeTextField($model,'username') ?>
        </div>
        <div class="login_form_row">
          <label class="login_label">Password:</label>
          <? echo CHtml::activePasswordField($model,'password'); ?>
        </div>
		<div class="login_form_row">
		<? echo CHtml::activeCheckBox($model,'rememberMe', array('style' => 'display: inline;')); ?>
		<? echo CHtml::activeLabelEx($model,'rememberMe', array('style' => 'display: inline;')); ?> <br />
		</div>
		<input type="image" src="<?php echo Yii::app()->baseUrl; ?>/images/public/login.gif" class="login" />
      </div>
	  <? echo CHtml::endForm(); ?>
	  <?php }  
	  else {
	  ?>
	  <div class="text_box" style="margin-top:55px;">
           <?php echo Yum::renderFlash(); ?>
	  <div class="title">User Menu</div>
	  <?php 
          $id = Yii::app()->user->id;
         $user = YumUser::model()->findByPk($id);
         $profile = $user->profile;
         
          $this->widget('YumMenu',array(
			'items'=>array(
				//array('label'=>'My profile', 'url'=>array('//profile/profile/view')),
				array('label'=>'Edit personal data', 'url'=>array('//profile/profile/update')),
				array('label'=>'Upload avatar image', 'url'=>array('/avatar/avatar/editAvatar'),'visible' => Yum::hasModule('avatar'),),
				//array('label'=>'Privacy settings', 'url'=>array('/profile/privacy/update')),
				array('label'=>'Change password', 'url'=>array('//user/user/changePassword')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.$profile->firstname.' '.$profile->lastname.')', 'url'=>array('//user/user/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	  </div>
	  <?php }?>
      <div class="testimonials">
        <div class="title">Comments / Feedback</div>
        <div class="text_box">
          <p class="testimonial"> If you have any comments about CoICT Service Hosting Control Panel i.e. Improvement, 
		  Simplicity, Difficulties and so on, please follow the link below <br />
            <strong><a href="<?php echo Yii::app()->baseUrl; ?>"> comment / feedback!</a></strong> </p>
        </div>
      </div>
    </div>