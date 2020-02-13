<?php $baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('pms.assets')); 
	  $cs = Yii::app()->getClientScript(); 
?>
      
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
	<title>PROJECT MANAGEMENT SYSTEM</title>
                
	<!--home page interface -->
    <?php //$cs->registerCssFile($baseUrl.'/css/int.css'); ?>	
    <?php //$cs->registerCssFile($baseUrl.'/DateFormat/ui-lightness/jquery-ui-1.10.3.custom.min.css'); ?>		
	<?php //$cs->registerScriptFile($baseUrl.'/js/jquery-1.8.0.min.js'); ?>
	<?php //$cs->registerScriptFile($baseUrl.'/DateFormat/plugins/jquery-ui-1.10.3.custom.min.js'); ?>
	<?php //$cs->registerScriptFile($baseUrl.'/js/jquery.dataTables.js'); ?>
	<?php //$cs->registerScriptFile($baseUrl.'/js/jquery.form.wizard.js'); ?>
	<?php //$cs->registerScriptFile($baseUrl.'/js/jquery-ui-timepicker-addon.js'); ?>
	
	<link rel="stylesheet" rel="text/css" href="41.86.176.19/assets/18329e18/css/int.css" />
	<link href="41.86.176.19/assets/18329e18/DateFormat/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet"/>  
    <script src="41.86.176.19/assets/18329e18/js/jquery-1.8.0.min.js" type="text/javascript"></script>
    <script src="41.86.176.19/assets/18329e18/DateFormat/plugins/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="41.86.176.19/assets/18329e18/js/jquery.dataTables.js" type="text/javascript"></script>
	<script type="text/javascript" src="41.86.176.19/assets/18329e18/js/jquery.form.wizard.js"></script>
	<script src="41.86.176.19/assets/18329e18/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
	
	<!--[if lt IE 9]>
	<script src="41.86.176.19/assets/18329e18/js/excanvas.js" type="text/javascript"></script>
	<script src="41.86.176.19/assets/18329e18/js/html5shiv.min.js" type="text/javascript"></script>
	<script src="41.86.176.19/assets/18329e18/js/respond.min.js" type="text/javascript"></script>
	
	
	<![endif]-->
	
	
	
	
	
	
		<script type="text/javascript">
			$(function(){
					/*$("#input_form").formwizard({ 
						formPluginEnabled: true,
						validationEnabled: true,
						focusFirstInput : false	
					 }
					);*/
					$('#modern_table').dataTable();
			});
			
			/*$(function(){
					$("#inform_alt").formwizard({ 
						formPluginEnabled: true,
						validationEnabled: false,
						focusFirstInput : false	
					 }
					);
			});*/
	      </script>

	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {
		   $('.pp').datetimepicker();
		});
    </script>	
	
	<script>
		$(".delete").live("click",function(event){
     return confirm("Are you sure want to delete this record?");
     });
    </script>
	
	
	<!--AJAX BEGINS HERE-->
	<script type="text/javascript">
		$(document).ready(function(){
		
			timestamp = 0;
			updateMsg();
			
			$("#chatarea").submit(function(){
				$.post("41.86.176.19/protected/modules/ajax/views/layouts/ajax.php",{
							message: $("#msg").val(),
							receiverID: $("#receiverID").val(),
							userID: $("#userID").val(),
							time: timestamp
						}, function() {
						
						
					$("#msg").val(' ');
					
				});
				return false;
			});
			
			
		});
		function addMessages(xml) {
		if($("status",xml).text() == "2") return;
		else{
			timestamp = $("time",xml).text();
			$("message",xml).each(function(id) {
				message = $("message",xml).get(id);
				
				
				var time=$("date_time",message).text();
				time=time.replace(/\s+/g, '');
				var author=$("author",message).text();
				var identify=author+time;
				
				
				$('.comm').each(function() {
					if (this.id=='identify')
					alert('repeat');
				});
				
				var my_ID=$("author",message).text()+$("date_time",message).text();
			    my_ID = my_ID.replace(/\s+/g, '');
				my_ID='chat_msg';
				var response="<div class='message'id='"+my_ID+"'><div class='text'><p class='user'>"+$("author",message).text()+" <span class='timestamp'>"+$("date_time",message).text()+"</span></p><p>"+$("text",message).text()+"</p></div><div class='clear'></div></div>";
				
				
				$(response).hide().appendTo("#chat").fadeIn("slow");
				
				
				

				
			});
			}
		}
	
		
		function updateMsg() {
			$.post("41.86.176.19/protected/modules/ajax/views/layouts/ajax.php",{ time: timestamp, receiverID: $("#receiverID").val(),
							userID: $("#userID").val() }, function(xml) {
				
				addMessages(xml);
				
			});

			setTimeout('updateMsg()', 10000);
		}
		
	

		
	</script>
	
	
	
</head>


<body>	
<?php
   $connect=Yii::app()->db;
   //$connection=Yii::app()->db2;
   
   $userId=Yii::app()->user->id; 
   $year='';
   
   $sql="SELECT lastname, firstname FROM profile WHERE user_id='$userId'";
   $results=$connect->createCommand($sql)->query();
   foreach ($results as $result){
      $data=(array) $result;
      $new_result=  array_values($data);
      $lastname=$new_result[0];
      $firstname=$new_result[1];
   } 
	  
   $sql="SELECT username, student, staff FROM user WHERE id='$userId'";
   $results=$connect->createCommand($sql)->query();
   foreach ($results as $result){
      $username=$result['username'];
      $student=$result['student'];
      $staff=$result['staff'];
   } 
   
   $sql="SELECT * FROM students WHERE userID='$userId'";
   $results=$connect->createCommand($sql)->query();
   foreach ($results as $result){
      $year=$result['yearStudy'];
   } 
   $rows=count($results);	  
   if (($username=='PMScoordinator' && $staff==1)||($username=='coordinator2' && $staff==1)){	  
       $user_role=1;
   }else if ($staff==1){
       $user_role=2;
   }else if(($student==1)&&($year==3)){
       $user_role=3;
   }elseif (($student==1)&&($rows==0)){
       $user_role=4;
   }else if(($student==1)&&($year==2)){
       $user_role=5;
   }
	   
   //$Functions->set_user_role($user_role);
   $path=new Functions($user_role);
   
   $path->set_position();
   $path->set_sub_position();
   $position=$path->get_position();
   $sub_position=$path->get_sub_position();
   $action=$path->get_action();

?>
	  
<div class='app_container'>
	<div class='banner'>
		<div class='container_w'>
		<img src='<?php echo $baseUrl; ?>/images/logo/default.png' class='banner_logo'>
		<div class='account'><a href='41.86.176.19/index.php/user/user/logout'><?php echo strtoupper($firstname.' '.$lastname) ; ?> <i>[Logout]</i></a></div>
	   </div>
	</div>
	<div class='bar'>
		<div class='container_w'><h1 class='condensed'><i><?php echo strtolower($position) ?></i></h1></div>
		<div style='text-align: right; color: white; margin-right: 50px;'><?php date_default_timezone_set('Africa/Nairobi'); echo $today = date("F j, Y, g:i a") ?></div>
	</div>

	
	<div class="menu">
		<?php 
		  $function =new Functions($user_role);
		  echo $function->get_side_menu();
		?>
	</div>
	
	<div class="content">
		 <?php   
		  echo $function->switch_system($position,$sub_position,$action);
		 ?> 
	</div>
	
	<div class='clear'></div>
	<div class='footer'>
			<div class='container_w'><p>&copy; <?php echo $today=date('Y')?>. CoICT, UDSM.</br>By Mwammenywa, Ibrahim A.</p></div>
	</div>
</div>

	
</body>
</html>