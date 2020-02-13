<html>
<head>
<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="<?php echo Yii::app()->baseUrl; ?>/images/favicon.gif" type="image/x-icon" />
<link href="<? echo Yii::app()->baseUrl;?>/css/admin.css" rel="stylesheet" type="text/css" />
<link href="<? echo Yii::app()->baseUrl;?>/css/form-admin.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" type="text/javascript" src="<? echo Yii::app()->baseUrl; ?>/assets/common.js"></script>
<script type="text/javascript" src="<? echo Yii::app()->baseUrl; ?>/assets/calendarDateInput.js"></script>

<script language="JavaScript" type="text/javascript" src="<? echo Yii::app()->baseUrl; ?>/assets/menu.js"></script>

<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->

function enable(Id,pg)
{
	window.location.href = 'index.php?q=<?php echo MD5('progress')?>&action=enabled&id=' + Id + '&pg='+pg;
}

function disable(Id,pg)
{
	window.location.href = 'index.php?q=<?php echo MD5('progress')?>&action=disabled&id=' + Id + '&pg='+pg;
}

function fucClose()
{
	alert("Hello there ");
}
</script>
</head>
<body  onload="MM_preloadImages('../images/favicon.png','../images/right_bg.jpg','../images/left_bg.jpg','../images/left_corner.jpg','../images/right_corner.gif','../images/bottom_bg.jpg','../images/adminbanner.jpg')">
<table width="908" border="0" align="center" cellpadding="0" cellspacing="0" class= "whitebox">
<tr>
    <td width="4" class="left_bg">
	</td>
    <td width="900" class="main_td" height="400" valign="top">
	<table width="900">
	<!------------banner------------->
	<tr>
		<td><img src="<? echo Yii::app()->request->baseUrl;?>/images/adminbanner.jpg" width="900" height="50" border="0" /></td>
	</tr>
	<!------------Menu--------------->
	<tr>
		<td>
		<div id="menu"> 
		<ul id="sddm">
		<li valign="center"><a href="<?php echo Yii::app()->request->baseUrl; ?>/admin"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/house.png" border="0" /> Home</a></li>
		<li>
		<a href="#" 
        onmouseover="mopen('m8')" 
        onmouseout="mclosetime()"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/report.png" border="0" /> Authorization </a>
        <div id="m8" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/role/role/admin">Roles</a>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/role/role/create">Create Role</a>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/role/permission/admin"> Permissions</a>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/role/permission/create"> Grant permission</a>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/role/action/admin"> Actions</a>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/role/action/create"> Create Action</a>
        </div>
		</li>
        <li><a href="#" 
        onmouseover="mopen('m3')" 
        onmouseout="mclosetime()"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/package.png" border="0" /> Sub-Systems</a>
        <div id="m3" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/upload">Install &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/view"> View All</a>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/remove">Unistall</a>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/admin/update">Update</a>
        </div>
		</li>
		<?php ?>
		<li><a href="#" 
        onmouseover="mopen('m4')" 
        onmouseout="mclosetime()"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/date_edit.png" border="0" /> Backup</a>
        <div id="m4" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()" width=10>
        <a href="<?php echo Yii::app()->baseUrl; ?>/jbackup" >List Backups&nbsp;&nbsp;&nbsp;</a>
		<a href="<?php echo Yii::app()->baseUrl; ?>/jbackup/default/create" >Create Backup&nbsp;&nbsp;&nbsp;</a>
		<a href="<?php echo Yii::app()->baseUrl; ?>/jbackup/default/upload" >Upload Backup&nbsp;&nbsp;&nbsp;</a>
		<!------------<a href="<?php //echo Yii::app()->baseUrl; ?>/backup/default/restore" >Restore Backups&nbsp;&nbsp;&nbsp;</a>------------->
		<!------------<a href="<?php //echo Yii::app()->baseUrl; ?>/backup/default/clean" >Clean Database&nbsp;&nbsp;&nbsp;</a>------------->
        </div>
		</li>
		<li><a href="#" 
        onmouseover="mopen('m5')" 
        onmouseout="mclosetime()"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/package.png" border="0" /> Settings</a>
        <div id="m5" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
		<a href="<?php echo Yii::app()->baseUrl; ?>/admin/academicYear"> Set New Academic Year</a>
        <a href="#"> Check for updates </a>
        <a href="#">Install themes</a>
        <a href="#">Unistall</a>
        </div>
		</li>
		<li valign="center"><a href="#" onmouseover="mopen('m7')" 
        onmouseout="mclosetime()"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/note.png" border="0" />Users</a>
		<div id="m7" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/user/admin"> List of Users &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/user/create?action=2"> New Student user &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/user/user/create?action=1"> New staff user</a>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/user/user/import"> Import Students</a>
        </div>
		</li>
        <li>
		<a href="#" 
        onmouseover="mopen('m6')" 
        onmouseout="mclosetime()"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/report.png" border="0" /> Group </a>
        <div id="m6" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/usergroup/groups/browse">List of Groups</a>
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/usergroup/groups/create">New Group</a>
		<a href="<?php echo Yii::app()->request->baseUrl; ?>/usergroup/groups/assign"> Assign users to Group</a>
        </div>
		</li>
		<li class="log"><a href="<?php echo Yii::app()->baseUrl;?>/user/auth/logout"><img src = "<?php echo Yii::app()->request->baseUrl; ?>/images/door_out.png" border="0" /> log out</a></li>
		</ul>
		
		<div style="clear:both"></div>
		</div>
		</td>
	</tr>
	<!------------content ------------->
	<tr>
		<td valign="top" height="400" width="880" >
		
		<?php echo $content; ?>
		
		</td>
	</tr>
	</table>
	</td>
	<td width="4" class="right_bg">&nbsp;</td>
</tr>
<tr>
    <td height="4"><img src="<? echo Yii::app()->request->baseUrl;?>/images/left_corner.jpg" width="4" height="4" border="0" /></td>
    <td height="4" class="bottom_bg"></td>
    <td height="4" ><img src="<? echo Yii::app()->request->baseUrl;?>/images/right_corner.gif" width="4" height="4" border="0" /></td>
</tr>
</table>
<table width="870" align="center">
<!-----------foooter--------------->
	<tr>
		<td align="center" class="footer">&copy;<?php echo date('Y'); ?> College of Information and Communication Technologies(CoICT)</td>
	</tr>
</table>

</body>
</html>
