<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/public.css" />
</head>
<body>
<div id="main_container">
  <div id="header">
    <div class="logo"><img src="<?php echo Yii::app()->baseUrl; ?>/images/public/logo.png" border="0" alt="" /></div>
  </div>
  <div class="menu">
    <ul>
      <li><a href="<?php echo Yii::app()->baseUrl; ?>">Home</a></li>
      <li><a href="<?php echo Yii::app()->baseUrl; ?>/public/contact">Contact Us</a></li>
    </ul>
  </div>
  <div class="center_content">
    <?php echo $content; ?>
    <div class="clear"></div>
  </div>
  <div id="footer">
    <div class="left_footer">&copy;<?php echo date('Y'); ?> College of Information and Communication Technologies(CoICT)</div>
  </div>
</div>
<!-- end of main_container -->
</body>
</html>
