<?php
/* @var $this AdminController */
$this->pageTitle=Yii::app()->name;
?>
<table height="500" width="900" class="">
<tr>
	<td>
	<fieldset style=" color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; width:865px; height:495px; float:left; background:#FAF9F9"><legend align="left">Control panel</legend>
	<table>
	<tr>
		<td width="70%" valign="top">
		<table border=0>
		<tr>
			<td><div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120"  >
			<tr>
				<td align="center"> <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/upload"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-article-add.png"  border="0" /><br/><br/><div class="label">Add New Subsystem</div></a></td>
			</tr>
			</table></div>
			</td>
			<td width="35">&nbsp;</td>
			<td><div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120" >
			<tr>
				<td align="center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/view"> <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-static.png"  border="0" /><br/><br/><div class="label">View Subsystems</div></a></td>
			</tr>
			</table></div></td>
			<td width="35">&nbsp;</td>

			<td width="35" colspan='0'>&nbsp;</td>
			<td>
			<div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120"  >
			<tr>
				<td align="center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/user/user/admin"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-user.png"  border="0" /><br/><br/><div class="label">Users</div></a></td>
			</tr>
			</table></div>
			</td>
			<td width="35" colspan='2'>&nbsp;</td>
			
		</tr>
		<tr height='5'><td colspan='7'>&nbsp;</td></tr>
				
		</tr>
		</table>
		</td>
		<td align="right" valign="top">
		<fieldset style=" color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; width:340px; height:460px; float:left ; border-color:#FFFFFF"><legend align="center">Welcome to ETE Service Support</legend>
		<table align= "left">
		<tr>
		<td class="label">This is the main page which contains functions for managing the framework!<br/></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		<td class="label">Install Subsystem:<br />This enables you to install a new service to the system.</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		
		<tr>
		<td class="label">Subsystems :<br /> This link gives the list of all available subsysems to the framework.</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		<td class="label">User:<br />Here you can manage users using the system.</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
			<br />		
			
			<div class="pagelocator_active" align="right">LAST BACKUP DATE: </div> 
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr><!--
		<tr>
		<td class="label">Report:<br />by select one of dropdown menu you can generate sales, stock and customer reports .</td>
		</tr>-->
		</table>
		</fieldset>
		</td>
	</tr>
	</table>
	</fieldset>
	</td>
</tr>
</table>

