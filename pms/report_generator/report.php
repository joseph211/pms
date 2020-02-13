<?php
require_once("dompdf_config.inc.php");
    $dsn = 'mysql:host=41.86.176.19;dbname=pms';
    $username = 'ibrah';
    $password = 'ibrah0991';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = "Technical Difficulties";
        include('error.php');
        exit();
    }
Class reportGenerator{
	public $db;
	
	
	function __construct($db){
		$this->db=$db;
	}
	public function get_table_header($name,$class){//the method that generates the name and class of <th></th>
	 return "<th class='$class'>$name</th>";
	}
	public function resolve_headers($headers){//method that takes the <th> array and returns the proper combination to add to viewer
		$content='';
		foreach($headers as $header){
		  $content.=$header;
		}
	 return $content;
	}
	public function get_table_view($sql,$headers,$caption){//method that displays the actual table
				$rowCount=count($headers);
				$results=$this->get_query_result($sql,true);
				$headers=$this->resolve_headers($headers);
				$content="
				    <div class='wrapper'>	
					  <div class='report_title'>
					       <h1 class='content_header'>UNIVERSITY OF DAR ES SALAAM</h1>
						    <img src='udsmlogo.png'>
                           <h1 class='content_header'>COLLEGE OF INFORMATION AND COMMUNICATION TECHNOLOGIES <br/>DEPARTMENT OF ELECTRONICS AND COMMUNICATIONS ENGINEERING</h1>
                           <h1 class='content_header'>$caption</h1>

					  </div>	
					
					  <div class='clear'></div>
					   <table id='data_table'>
						<thead>
						   <tr>$headers</tr>
					   </thead>
					   <tbody>";
					  
					  $count=0;
					  
					  

					  
					  foreach($results as $result)
					  {
					 
								$count++;
								if($count%2==0)
								{
									$class='class="even"';
								}else{
									$class='';
								}
								
								
								$content.="<tr $class><td>$count</td>";
								
								for($i=1;$i<$rowCount;$i++)
								{
									$content.="<td>$result[$i]</td>";
								}
							
								
					 }
				 
				  
				 $content.="</tr></tbody></table></div></div>";
			
	   return $content;
	}
	public function reports_generator($content){
	   $html =
			  '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>

			  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
			  
			  <style>
					body{
						background:#FFF;
						padding:0px;
						margin:0px;
						font-family:Segoe UI;
						font-size:.8em;
						text-align:center;
					}
				    
					.report_title{
						text-align:center;
					}
					.report_title{
						font-size:0.7em;
					}
					
					#data_table{
						margin: 0 auto;
						border-collapse:collapse;
					}
					
					#data_table th{
						background-color:#EEE;
						background-repeat:no-repeat;
						background-position:98% 50%;
						padding:10px;
						border:1px solid #efefef;
					}
					
					#data_table th.sorting_asc,#data_table th.sorting_desc{
					border-bottom:3px solid #D72A2A;
					}
					
					#data_table th.number{
					width:30px;
					}
					#data_table td.number{
					width:30px;
					}
					#data_table td.action{
					text-align:center;
					width:100px;
					}
					#data_table td.action_w{
					text-align:center;
					width:160px;
					}
					#data_table td{
					padding:10px;
					border:1px solid #efefef;
					}

					#data_table tr{
					background:#f9f9f9;
					}

					 #data_table tr{
					background:#FFF;
					}
					#data_table tr.even{
					background:#FCFCFC;
					}

				
	
			  </style>

			</head>

			<body>


				<div class="app_container">
					
					
					
					<div class="content_header">
					
						'.$content.'
					</div>	
					
				</div>

			</body>

			</html>
			';


			$dompdf = new DOMPDF(); 
			$dompdf->load_html($html);
			$dompdf->render();
			$dompdf->stream("myexport.pdf");	
	}
	public function get_report_content(){
		if(isset($_GET['report']))
		{
		$download=$_GET['report'];
		}else{
			$download=null;
		}
		switch($download)
		{
			case 'announcements':
								$sql="SELECT announcementID, title, content, publishTime FROM announcement ORDER BY publishTime DESC";
								$headers[0]=$this->get_table_header('No.','number');
								$headers[1]=$this->get_table_header('Title','default');
								$headers[2]=$this->get_table_header('Description','default');
								$headers[3]=$this->get_table_header('Date Published','default');
											   
								$caption='ANNOUNCEMENTS';
								$content= $this->get_table_view($sql,$headers,$caption);
								$this->reports_generator($content);
								header('location: ?menu=manage&view=announcements');
								break;
											 
			case 'attendances':					
								if(isset($_GET['id'])){
	                               $id=$_GET['id'];
                                }else {
								   $id=null;
								}								   
	                                    
								$semesterStart=$semesterEnd='';
								$sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
								$sql = $this->db->prepare($sql);
		                        $sql->execute();
								$results=$sql->fetchAll();
								foreach ($results as $result){
								    $semesterEnd = $result['endTime'];
									$semesterStart = $result['startTime'];
								} 
		                        $sql="SELECT studentLastName FROM students WHERE studentID='$id'";
								$sql = $this->db->prepare($sql);
		                        $sql->execute();
								$results=$sql->fetchAll();
                                foreach ($results as $result){
									$name=$result['studentLastName'];
                                }												
										 
								$sql="SELECT attendanceID, weekNo, description, comment, attendanceTime FROM attendances WHERE (studentID='$id') AND (attendanceTime>'$semesterStart') AND (attendanceTime<'$semesterEnd')";
								$headers[0]=$this->get_table_header('No.','number');
								$headers[1]=$this->get_table_header('Week No.','default');
								$headers[2]=$this->get_table_header('Work Description','default');
								$headers[3]=$this->get_table_header('Comment','default');
								$headers[4]=$this->get_table_header('Attendence Time','default');
							    $caption='Attendance Report of '.$name;
							    $content= $this->get_table_view($sql,$headers,$caption);
								$this->reports_generator($content);								 
								break;	
            
			case 'evaluation': 
								$endTime=$startTime='';
								$sql="SELECT endTime, startTime FROM  sessions WHERE title='Oral Presentation'";
								$sql = $this->db->prepare($sql);
		                        $sql->execute();
								$results=$sql->fetchAll();
								foreach ($results as $result){
									$endTime = $result['endTime'];
									$startTime = $result['startTime'];
								}
									//$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 3 days'));
								date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							    if (($today >= $startTime) && ($today <= $endTime)) {  
									if(isset($_GET['id'])){
	                                   $supervisorID=$_GET['id'];
                                    }else {
								       $supervisorID=null;
								    }; 
									 
                                    $sql="SELECT SupervisorLastName FROM supervisors WHERE supervisorID='$supervisorID'";
								    $sql = $this->db->prepare($sql);
		                            $sql->execute();
								    $results=$sql->fetchAll();
                                    foreach ($results as $result){
									 $name=$result['SupervisorLastName'];
                                    }			
									 
									 $sql="SELECT evaluationID, studentLastName, organisation_score, content_score,accomplishment_score, plan_score, delivery_score, multimedia_score, questions_score, total_score FROM prentationevaluations 
									        INNER JOIN students ON students.studentID = prentationevaluations.studentID
									        WHERE prentationevaluations.supervisorID='$supervisorID' AND prentationevaluations.time<'$endTime' AND prentationevaluations.time>'$startTime'
											ORDER BY studentLastName ASC";
									 $headers[0]=$this->get_table_header('No.','number');
									 $headers[1]=$this->get_table_header('Student Name','default');
									 $headers[2]=$this->get_table_header('Organisation','default');
									 $headers[3]=$this->get_table_header('Content','default');
									 $headers[4]=$this->get_table_header('Goals & Accomplishment','default');
									 $headers[5]=$this->get_table_header('Plan','default');
									 $headers[6]=$this->get_table_header('Delivery','default');
									 $headers[7]=$this->get_table_header('Multimedia Use','default');
									 $headers[8]=$this->get_table_header('Questions','default');
									 $headers[9]=$this->get_table_header('Total, 30','default');
									 $caption='Oral Presentation Marks by '.$name;
									 $content= $this->get_table_view($sql,$headers,$caption);
								     $this->reports_generator($content);
								}break;
    								
			case 'marking'	:				
			                    $endTime=$startTime='';
								$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
                                $sql = $this->db->prepare($sql);
		                        $sql->execute();
								$results=$sql->fetchAll();
								foreach ($results as $result){
									$endTime = $result['endTime'];
									$startTime = $result['startTime'];
								}								
								date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							    if (($today >= $startTime) && ($today <= $endTime)) {  
									if(isset($_GET['id'])){
	                                   $supervisorID=$_GET['id'];
                                    }else {
								       $supervisorID=null;
								    }; 
									 
                                    $sql="SELECT SupervisorLastName FROM supervisors WHERE supervisorID='$supervisorID'";
								    $sql = $this->db->prepare($sql);
		                            $sql->execute();
								    $results=$sql->fetchAll();
                                    foreach ($results as $result){
									 $name=$result['SupervisorLastName'];
                                    }				
									
									$sql="SELECT markingID, studentLastName, grammar_score, content_score, accomplishment_score, total_score FROM reportmarks 
									      INNER JOIN students ON students.studentID = reportmarks.studentID
										  WHERE reportmarks.markerID='$supervisorID' AND reportmarks.time<'$endTime' AND reportmarks.time>'$startTime'
									      ORDER BY studentLastName ASC"; 
									$headers[0]=$this->get_table_header('No.','number');
									$headers[1]=$this->get_table_header('Student Name','default');
									$headers[2]=$this->get_table_header('General Format, 10','default');
									$headers[3]=$this->get_table_header('Content, 40','default');
									$headers[4]=$this->get_table_header('Goals & Accomplishment, 10','default');
									$headers[5]=$this->get_table_header('Total, 60','default');
									$caption='Project Reports Marks by '.$name;
									$content= $this->get_table_view($sql,$headers,$caption);
								    $this->reports_generator($content);
								}break;
									
			case 'performance':
                                $endTime=$startTime='';
								$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
                                $sql = $this->db->prepare($sql);
		                        $sql->execute();
								$results=$sql->fetchAll();
								foreach ($results as $result){
									$endTime = $result['endTime'];
									$startTime = $result['startTime'];
								}								
								date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							    if (($today >= $startTime) && ($today <= $endTime)) {  
									if(isset($_GET['id'])){
	                                   $supervisorID=$_GET['id'];
                                    }else {
								       $supervisorID=null;
								    }; 
									 
                                    $sql="SELECT SupervisorLastName FROM supervisors WHERE supervisorID='$supervisorID'";
								    $sql = $this->db->prepare($sql);
		                            $sql->execute();
								    $results=$sql->fetchAll();
                                    foreach ($results as $result){
									 $name=$result['SupervisorLastName'];
                                    }				
							        
									$sql="SELECT performanceID, studentLastName, comment, performance_score FROM performance
									      INNER JOIN students ON students.studentID = performance.studentID
									      WHERE students.supervisorID='$supervisorID' AND performance.time<'$endTime' AND performance.time>'$startTime'
										  ORDER BY studentLastName ASC";
									$headers[0]=$this->get_table_header('No.','number');
									$headers[1]=$this->get_table_header('Student Name','default');
									$headers[2]=$this->get_table_header('General Comment','default');
									$headers[3]=$this->get_table_header('General Performance, 10','default');
			                        $caption='Performance Report by '.$name;
									$content= $this->get_table_view($sql,$headers,$caption);
								    $this->reports_generator($content);
								}break;
			
            case 'titles':
			                    date_default_timezone_set('Africa/Nairobi');
							    $year = date("Y");
									  
							    $sql="SELECT proposalID, title, studentLastName, supervisorLastName, supervisorComment, submissionTime, comment, panelApproval FROM titleproposal
									  INNER JOIN students ON students.studentID = titleproposal.studentID
									  INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
									  WHERE (supervisorApproval='Accepted') AND (DATE_FORMAT(submissionTime, '%Y')='$year') 
									  ORDER BY submissionTime ASC";
								$headers[0]=$this->get_table_header('No.','number');
							    $headers[1]=$this->get_table_header('Project Title','default');
						   	    $headers[2]=$this->get_table_header('Student Name','default');
								$headers[3]=$this->get_table_header('Supervisor Name','default');
								$headers[4]=$this->get_table_header('Supervisor Comment','default');
								$headers[5]=$this->get_table_header('Submission Time','default');
								$headers[6]=$this->get_table_header('Panel Comment','default');
								$headers[7]=$this->get_table_header('Status','default');
								$caption='Project Proposals';
			                    $content= $this->get_table_view($sql,$headers,$caption);
								$this->reports_generator($content);
								break;
			
			case 'progress':
			                   $sql="SELECT endTime, startTime FROM  sessions WHERE title='Progress Report Submission'";
							   $sql = $this->db->prepare($sql);
		                       $sql->execute();
							   $results=$sql->fetchAll();
							   foreach ($results as $result){
							        $endTime = $result['endTime'];
									$startTime = $result['startTime'];
							   } 
									  
							   $sql="SELECT reportID, studentLastName, title, submissionTime, supervisorLastName FROM progress_report
							         INNER JOIN students ON students.studentID = progress_report.studentID
					    		     INNER JOIN supervisors ON supervisors.supervisorID = progress_report.supervisorID
							         WHERE (progress_report.supervisorApproval='Accepted') AND (students.yearStudy=3) AND (progress_report.submissionTime>'$startTime') AND (progress_report.submissionTime<'$endTime') AND (progress_report.submissionTime>'$semesterStart') AND (progress_report.submissionTime<'$semesterEnd')
						             ORDER BY submissionTime ASC";
							   $headers[0]=$this->get_table_header('No.','number');
							   $headers[1]=$this->get_table_header('Student Name','default');
							   $headers[2]=$this->get_table_header('Project Title','default');
							   $headers[3]=$this->get_table_header('Submission Time','default');
							   $headers[4]=$this->get_table_header('Supervisor Name','default');
							   $caption='Progress Reports';
							   $content= $this->get_table_view($sql,$headers,$caption);
							   $this->reports_generator($content);
							   break;
			case 'reports':  
					        $semesterStart=$semesterEnd=$timeStart=$timeEnd='';
					                
						    $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
							$sql = $this->db->prepare($sql);
		                    $sql->execute();
							$results=$sql->fetchAll();
							foreach ($results as $result){
								$semesterEnd = $result['endTime'];
						        $semesterStart = $result['startTime'];
							} 
									 
							$sql="SELECT endTime, startTime FROM sessions WHERE title='Final Report Submission'";
							$sql = $this->db->prepare($sql);
		                    $sql->execute();
							$results=$sql->fetchAll();
							foreach ($results as $result){
								$timeEnd = $result['endTime'];
							    $timeStart = $result['startTime'];
							} 
									  
							$sql="SELECT reportID, studentLastName, title, submissionTime, supervisorLastName, examinerLastName FROM projectreport
								  INNER JOIN students ON students.studentID = projectreport.studentID
								  INNER JOIN supervisors ON supervisors.supervisorID = projectreport.supervisorID
								  INNER JOIN examiners ON examiners.examinerID = projectreport.independentExaminerID
								  WHERE (projectreport.supervisorApproval='Accepted') AND (students.yearStudy=3) AND (projectreport.submissionTime>'$semesterStart') AND (projectreport.submissionTime<'$semesterEnd') AND (projectreport.submissionTime>'$timeStart') AND (projectreport.submissionTime<'$timeEnd')
								  ORDER BY studentLastName ASC";
							$headers[0]=$this->get_table_header('No.','number');
							$headers[1]=$this->get_table_header('Student Name','default');
							$headers[2]=$this->get_table_header('Project Title','default');
							$headers[3]=$this->get_table_header('Submission Time','default');
							$headers[4]=$this->get_table_header('Supervisor Name','default');
							$headers[5]=$this->get_table_header('Independent Examiner','default');
							$caption='Project Reports';
							$content= $this->get_table_view($sql,$headers,$caption);
							$this->reports_generator($content);
							break;						  
							
			case 'presentation':				
                            $endTime=$startTime='';
							$sql="SELECT endTime, startTime FROM  sessions WHERE title='Oral Presentation'";
							$sql = $this->db->prepare($sql);
		                    $sql->execute();
							$results=$sql->fetchAll();
							foreach ($results as $result){
								$endTime = $result['endTime'];
							    $startTime = $result['startTime'];
							}
							$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 21 days'));
							date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							if (($today >= $startTime) && ($today <= $finalTime)) {  
							$sql="SELECT evaluationID, studentLastName, organisation_score, content_score,accomplishment_score, plan_score, delivery_score, multimedia_score, questions_score, total_score, SupervisorLastName FROM prentationevaluations 
								  INNER JOIN students ON students.studentID = prentationevaluations.studentID
								  INNER JOIN supervisors ON supervisors.supervisorID = prentationevaluations.supervisorID
								  ORDER BY studentLastName ASC";
							$headers[0]=$this->get_table_header('No.','number');
							$headers[1]=$this->get_table_header('Student','default');
							$headers[2]=$this->get_table_header('Organisation','default');
							$headers[3]=$this->get_table_header('Content','default');
							$headers[4]=$this->get_table_header('Accomplishment','default');
							$headers[5]=$this->get_table_header('Plan','default');
							$headers[6]=$this->get_table_header('Delivery','default');
							$headers[7]=$this->get_table_header('Multimedia','default');
							$headers[8]=$this->get_table_header('Questions','default');
							$headers[9]=$this->get_table_header('Total','default');
							$headers[10]=$this->get_table_header('Evaluator','default');
							$caption='Oral presentation marks';
							$content= $this->get_table_view($sql,$headers,$caption);
							$this->reports_generator($content);
							}break;					       
			
			case 'markingreport':
			                $endTime=$startTime='';
							$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
							$sql = $this->db->prepare($sql);
		                    $sql->execute();
							$results=$sql->fetchAll();
							foreach ($results as $result){
		    				   $endTime = $result['endTime'];
							   $startTime = $result['startTime'];
							}
							$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 21 days'));
							date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							if (($today >= $startTime) && ($today <= $finalTime)) { 
							$sql="SELECT markingID, studentLastName, grammar_score, content_score, accomplishment_score, total_score, examinerLastName FROM reportmarks 
								  INNER JOIN students ON students.studentID = reportmarks.studentID
								  INNER JOIN examiners ON examiners.examinerID = reportmarks.markerID
								  ORDER BY studentLastName ASC";
							$headers[0]=$this->get_table_header('No.','number');
							$headers[1]=$this->get_table_header('Student Name','default');
							$headers[2]=$this->get_table_header('General Format, 10','default');
							$headers[3]=$this->get_table_header('Content, 40','default');
							$headers[4]=$this->get_table_header('Goals & Accomplishment, 10','default');
							$headers[5]=$this->get_table_header('Total, 60','default');
							$headers[6]=$this->get_table_header('Marker','default');
							$caption='Project Reports Marks';
							$content= $this->get_table_view($sql,$headers,$caption);
							$this->reports_generator($content);
							}break;

            case 'studentperformance':
					        $endTime=$startTime='';
							$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
							$sql = $this->db->prepare($sql);
		                    $sql->execute();
							$results=$sql->fetchAll();
							foreach ($results as $result){
								$endTime = $result['endTime'];
								$startTime = $result['startTime'];
						    }
									
							$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 21 days'));
							date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
									
							if (($today >= $startTime) && ($today <= $finalTime)) { 
					        $sql="SELECT performanceID, studentLastName, comment, performance_score, supervisorLastName FROM performance
								  INNER JOIN students ON students.studentID = performance.studentID
								  INNER JOIN supervisors ON supervisors.supervisorID = performance.supervisorID
							      ORDER BY studentLastName ASC";
							$headers[0]=$this->get_table_header('No.','number');
						    $headers[1]=$this->get_table_header('Student Name','default');
						    $headers[2]=$this->get_table_header('General Comment','default');
							$headers[3]=$this->get_table_header('General Performance, 10','default');
							$headers[4]=$this->get_table_header('Supervisor Name','default');
							$caption='Students General Performance';
							$content= $this->get_table_view($sql,$headers,$caption);
							$this->reports_generator($content);
							}break;				
					
			
			case 'results':
							$semesterStart=$semesterEnd='';
							$sql="SELECT endTime, startTime FROM  sessions WHERE title='Semester duration'";
							$sql = $this->db->prepare($sql);
		                    $sql->execute();
							$results=$sql->fetchAll();
							foreach ($results as $result){
							   $semesterEnd = $result['endTime'];
							   $semesterStart = $result['startTime'];
							} 
			                
							$sql="SELECT resultID, studentLastName, studentPerformance, oralPresentation, projectReport, penalty, total, externalMarks FROM results 
								 INNER JOIN students ON (students.studentID = results.studentID AND students.yearStudy = 3)
								 ORDER BY studentLastName ASC";
							$headers[0]=$this->get_table_header('No.','number');
							$headers[1]=$this->get_table_header('Student Name','default');
							$headers[2]=$this->get_table_header('Student Performance','default');
							$headers[3]=$this->get_table_header('Oral Presentation','default');
							$headers[4]=$this->get_table_header('Project Report','default');
							$headers[5]=$this->get_table_header('Penalty','default');
							$headers[6]=$this->get_table_header('Total Marks','default');
							$headers[7]=$this->get_table_header('External Examiner','default');
							$caption='Students Results';
			                $content= $this->get_table_view($sql,$headers,$caption);
							$this->reports_generator($content);
							break;
			
			
		}
	
	
	}
	public function get_query_result($sql,$isloop){	/*method to return query result*/
		$sql = $this->db->prepare($sql);
		$sql->execute();
		if($isloop==true)
		{
			$result=$sql->fetchAll();
		}else $result=$sql->fetch();
		
		return $result;
	}
	public function get_query_result_parameter($sql,$parameter,$isloop){	/*method to return query result*/
		$sql = $this->db->prepare($sql);
		$sql->bindParam(':value', $parameter);
		$sql->execute();
		if($isloop){
	      $result=$sql->fetchAll();
	    }else $result=$sql->fetch();
		return $result;
	}

}

$x=new reportGenerator($db);

$x->get_report_content();



?>