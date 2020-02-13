<?php
/* @var $this SiteController */
$this->pageTitle=Yii::app()->name;
?>

<?
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<table height="500" width="900" class="">
<tr>
	<td>
	<fieldset style=" color:#000000; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; width:865px; height:495px; float:left; background:#FAF9F9"><legend align="left">Control panel</legend>
	<table>
	<? if($msg == 'okay'){?>
	<tr class="errorMessage">
	<td colspan="2">Page Updated successful</td>
	</tr>
	<?}?>
	<tr>
		<td width="70%" valign="top">
		<table border=0>
		<tr>
			<td><div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120"  >
			<tr>
				<td align="center"><a href="index.php?q=<?php echo MD5('addjob'); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-article-add.png"  border="0" /><br/><br/><div class="label">Add New Module</div></a></td>
			</tr>
			</table></div>
			</td>
			<td width="35">&nbsp;</td>
			<td><div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120" >
			<tr>
				<td align="center"><a href="index.php?q=<?php echo MD5('upcv'); ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-static.png"  border="0" /><br/><br/><div class="label">View Modules</div></a></td>
			</tr>
			</table></div></td>
			<td width="35">&nbsp;</td>
			<td>
			<div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120"  >
			<tr>
				<td align="center"><a href="index.php?q=<?php echo MD5('enableuser');?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-generic.png"  border="0" /><br/><br/><div class="label">Report</div></a></td>
			</tr>
			</table></div>
			</td>
		</tr>
		<tr height='5'><td colspan='7'>&nbsp;</td></tr>
		<?php ?>
		<tr>
			<td><div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120"  >
			<tr>
				<td align="center"><a href="index.php?q=<?php echo MD5('log');?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-stats.png"  border="0" /><br/><br/><div class="label">Log history</div></a></td>
			</tr>
			</table></div>
			</td>
			<td width="35" colspan='0'>&nbsp;</td>
			<td>
			<div class="frameP">
			<table style="border:solid 1px; color:#CCCCCC" width="150" height="120"  >
			<tr>
				<td align="center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/public/index"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon-48-user.png"  border="0" /><br/><br/><div class="label">Users</div></a></td>
			</tr>
			</table></div>
			</td>
			<td width="35" colspan='2'>&nbsp;</td>
		<?php  if (@$_SESSION['enrich_user_id'] != 1){?>	
			<td colspan='5'>&nbsp;</td>
		<?php }?>
		</tr>
			
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
		<tr>
		<td class="label">Report:<br />Through this link you can add new Jobs </td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		<td class="label">Install module:<br />This enables you to install a new service to the system.</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		
		<tr>
		<td class="label">Modules :<br /> This link gives the list of all available modules to the system.</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
		<td class="label">User:<br />Here you can manage users using the system.</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
			<td>
			<br />		
			<?php
			$con = mysql_connect("localhost","root", "");
			mysql_select_db("ete");
			$resultdb = mysql_query("SELECT backupDate FROM tbl_database_autobackup ORDER BY backupId DESC");
			$rowdb	= mysql_fetch_array($resultdb);
			($rowdb)? $dated = $rowdb['backupDate'] : $dated = '0000-00-00';
			?>
			<div class="pagelocator_active" align="right">LAST BACKUP DATE: <? echo $dated; ?></div> 
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

