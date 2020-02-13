<?php
/* @var $this AdminController */
$this->pageTitle=Yii::app()->name;
?>

<div style="width:840px; margin-left:25px; margin-bottom:20px; height: 50px; background-color: #F4F4F4; border-radius: 5px;">
<table width="820px" height="50px">
<tr>
<td width="80px"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-extension.png" /></td>
<td><h2 style="color: #146295; font-size: 1.2em; font-weight: bold; line-height: 48px; margin: 0; padding: 0">Subsystem Manager: View All</h2></td>
</tr>
</table>
</div>

<div style="width:840px; margin-left:25px; margin-bottom:20px; height: 30px; background-color: #F4F4F4; border-radius: 5px;">
<ul style="list-style-type:none">

<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/upload">Install  </a></li>&nbsp&nbsp&nbsp|
<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/remove">Uninstall </a></li>&nbsp&nbsp&nbsp|
<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/view">View All </a></li>&nbsp&nbsp&nbsp|
<li style="display:inline"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/update">Update   </a></li>&nbsp&nbsp&nbsp|

</ul>
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

<table height="350" width="900" class="">
<tr>
	<td>
	<fieldset style=" color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border-radius: 5px; margin-left:25px; width:820px;  float:left; background:#F4F4F4">
	<legend align="left">Installed Subsystem(s)</legend>
	<table>
	<tr>
		<td width="70%" valign="top">
			<table border=0>
				<tr>
				<?php 
				foreach ( $subsystems as  $subsystem)
				{
				?>
					<td><div class="frameP">
					<table style="border:0px; color:#CCCCCC" width="215" height="120"  >
					<tr>
					<td align="center"><a href="<?php echo $subsystem->url; ?>"><img src="<?php echo $subsystem->iconUrl; ?>"  border="0" /><br/><br/><div class="label"><?php echo $subsystem->subsysName; ?></div></a></td>
					</tr>
					</table></div>
					</td>
					<?php }?>		
				</tr>
				

				<tr>
		
                 </tr>
				</table>
				</td>
	</tr>
	</table>
	</fieldset>
	</td>
</tr>
</table>
<?php }?>