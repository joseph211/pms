<?php

    //the class that handles the navigation menu
class Functions extends CModel{
	private $position=null;      //the main menu selected e.g add,view,delete...
	private $sub_position=null;  //the child menu selected e.g announcement...
	private $action=null;        //the action based upon the child menu selected
	private $role;   	//user role for displaying different types of menu
	
	protected $connect;
	protected $user_ID;
    protected $fullname;  
	//protected $role;	
	protected $salt='011235813';
	protected $instance;
	
	function __construct($role){
			$this->role=$role;
			$this->connect = Yii::app()->db;
	}
	
	/* public static function model($className=__CLASS__)
	{
		return parent::model($className);
	} */
	
	Public function  attributeNames () 
	{
	 throw New  Exception ( 'error' );
	}
	
	public function set_position(){
		if(isset($_GET['menu'])){
		  $position=$_GET['menu'];
		}else{
		   $position='home';
		}
	 $this->position=$position;
	}
	
	
	public function set_sub_position(){
		if(isset($_GET['view']) && !isset($_GET['action'])){
			$this->sub_position=$_GET['view'];
			$this->action='view';
		}elseif(isset($_GET['add'])){
			$this->sub_position=$_GET['add'];
			$this->action='add';
		}elseif(isset($_GET['action'])){
			$this->sub_position=$_GET['view'];
			$this->action=$_GET['action'];
		}else{
			$this->action='default';
		}
	}
	
	
	public function position_guide($place){
		if($place==$this->position)
		echo "class='selected'";
	}
	
	
	      //method for menus
	public function get_side_menu(){
       if($this->role=='1'){
	   
		    $menu="<ul id='system_menu'><li><a href='41.86.176.19/index.php/pms'>HOME</a></li>";
			
			$userID=Yii::app()->user->id;
			$sql="SELECT COUNT(*) FROM chat_room 
			      INNER JOIN supervisors ON supervisors.userID=chat_room.source 
			      WHERE (receiver='$userID' AND receiver_seen='0')";
			$results=$this->connect->createCommand($sql)->query();
            foreach ($results as $result){
			  if ($result['COUNT(*)']!=0){
			      $supervisors="<span class='notification'>".$result['COUNT(*)']."</span>";
			  }else{
			      $supervisors='';
			  }
			}
			
			$sql="SELECT COUNT(*) FROM chat_room 
			      INNER JOIN students ON students.userID=chat_room.source 
			      WHERE (receiver='$userID' AND receiver_seen='0')";
			$results=$this->connect->createCommand($sql)->query();
            foreach ($results as $result){
			  if ($result['COUNT(*)']!=0){
			     $students="<span class='notification'>".$result['COUNT(*)']."</span>";
			  }else{
			      $students='';
			  }
			}
			
			//adding children menus in a general group
			$child=null;
			$child['announcements'] = "Announcements";
			$child['sessions'] = "Project Sessions";
			$child['previous_projects'] = "Previous Projects";
			$child['titles'] = "Project Proposals";
			$child['progress'] = "Progress Reports"; //new added
			$child['reports'] = "Final Reports"; //new added
			$child['attendances'] = "Attendances Reports";
			$child['presentation'] = "Oral Presentation Results";
			$child['markingreport'] = "Report Marks";
			$child['studentperformance'] = "General Performance";
			$child['results'] = "Students Results";
			$menu.=$this->generate_link_group('MANAGE',$child);
			
			$child=null;
			$child['supervisors'] = "Supervisors".$supervisors;
			$child['students'] = "Students".$students;
			$menu.=$this->generate_link_group('CHAT',$child);
			
			$menu.='</ul>';
	
		}else if($this->role=='2'){
		
			$menu="<ul id='system_menu'><li><a href='41.86.176.19/index.php/pms'>HOME</a></li>";
			
			$userID=Yii::app()->user->id;
			$sql="SELECT COUNT(*) FROM chat_room 
			      INNER JOIN coordinator ON coordinator.userID=chat_room.source 
			      WHERE (receiver='$userID' AND receiver_seen='0')";
			$results=$this->connect->createCommand($sql)->query();
            foreach ($results as $result){
			  if ($result['COUNT(*)']!=0){
			      $coordinators="<span class='notification'>".$result['COUNT(*)']."</span>";
			  }else{
			      $coordinators='';
			  }
			}
			
			$sql="SELECT COUNT(*) FROM chat_room 
			      INNER JOIN students ON students.userID=chat_room.source 
			      WHERE (receiver='$userID' AND receiver_seen='0')";
			$results=$this->connect->createCommand($sql)->query();
            foreach ($results as $result){
			  if ($result['COUNT(*)']!=0){
			     $students="<span class='notification'>".$result['COUNT(*)']."</span>";
			  }else{
			      $students='';
			  }
			}
			
			
			//adding children menus in a general group
			$child=null;
			$child['ideas'] = "Project Ideas";
			$child['titlesSupervisor'] = "Title Proposals";
			$child['titlesToSupervisors'] = "Other Title Proposals";
			$child['progressSupervisor'] = "Progress Reports"; //new added
			$child['reportsSupervisor'] = "Final Reports";  //new added
			$child['attendances'] = "Attendances";
			$child['evaluation'] = "Oral Presentation Evaluation";
			$child['marking'] = "Reports Marking";
			$child['performance'] = "Student Performances";
			$menu.=$this->generate_link_group('MANAGE',$child);
			
			$child=null;
			$child['coordinator'] = "Coordinator".$coordinators;
			$child['supervisor_students'] = "Students".$students;
			$menu.=$this->generate_link_group('CHAT',$child);
			
			$menu.='</ul>';
			
		}else if($this->role=='3'){
		
			$menu="<ul id='system_menu'><li><a href='41.86.176.19/index.php/pms'>HOME</a></li>";
			
			$userID=Yii::app()->user->id;
			$sql="SELECT COUNT(*) FROM chat_room 
			      INNER JOIN coordinator ON coordinator.userID=chat_room.source 
			      WHERE (receiver='$userID' AND receiver_seen='0')";
			$results=$this->connect->createCommand($sql)->query();
            foreach ($results as $result){
			  if ($result['COUNT(*)']!=0){
			      $coordinators="<span class='notification'>".$result['COUNT(*)']."</span>";
			  }else{
			      $coordinators='';
			  }
			}
			
			$sql="SELECT COUNT(*) FROM chat_room 
			      INNER JOIN supervisors ON supervisors.userID=chat_room.source 
			      WHERE (receiver='$userID' AND receiver_seen='0')";
			$results=$this->connect->createCommand($sql)->query();
            foreach ($results as $result){
			  if ($result['COUNT(*)']!=0){
			      $supervisors="<span class='notification'>".$result['COUNT(*)']."</span>";
			  }else{
			      $supervisors='';
			  }
			}
			
			//adding children menus in a general group
			$child=null;
			$child['proposals'] = "Title Proposals";
			$child['progress_reports'] = "Progress Report";//new added.
			$child['project_reports'] = "Final Report"; //new added
			$menu.=$this->generate_link_group('MANAGE',$child);
			
			$child=null;
			$child['coordinator'] = "Coordinator".$coordinators;
			$child['student_supervisor'] = "Supervisor".$supervisors;
			$menu.=$this->generate_link_group('CHAT',$child);
			
			$menu.='</ul>';
		}else if($this->role=='4'){
		
			$menu="<ul id='system_menu'><li><a href='41.86.176.19/index.php/pms'>HOME</a></li>";
		}else if($this->role=='5'){
		
			$menu="<ul id='system_menu'><li><a href='41.86.176.19/index.php/pms'>HOME</a></li>";
			
			//adding children menus in a general group
			$child=null;
			$child['proposals'] = "Title Proposals";
			$menu.=$this->generate_link_group('MANAGE',$child);
			
			$menu.='</ul>';
		}		
	return $menu;
	}
	
	
	public function generate_link_group($name,$children){
	    $child=null;
		foreach($children as $key => $value){
			$child.=$this->generate_link($value,$key,strtolower($name));
		}
		return "<li class='parent'><a href='#'>$name</a><ul>$child</ul></li>";
	}
	
	
	public function generate_link($label,$link,$parent){
		   return "<li><a href='41.86.176.19/index.php/pms?menu=$parent&amp;view=$link'>$label</a></li>";
	}
	
	
	public function get_position(){
	 return $this->position;
	}
	
	
	public function get_sub_position(){
	 return $this->sub_position;
	}
	
	
	public function get_action(){
	 return $this->action;
	}	
	



    //the class that will check the user rolesclass user{

	//constructor 
	

	
	
	
	/*
	
	*/
	
	
	//method to determine system user role
	public function set_user_role($user){
		$this->role=$user;
	}
	
	/**
	
	**/
	
	public function get_user_role(){
	return $this->role;
	}
	
	/***
	
	***/
	
	/****
	
    ****/
	
	
	
	//dealing with user contents based on roles
	public function get_manage_one($position,$sub_position,$action){
		$extra=false;
		 if($action=='view'){	
        
					switch($sub_position){
					case 'dash_announcements':
					                  if(isset($_GET['id'])){
	                                     $id=$_GET['id'];
		                                 $sql="SELECT * FROM announcement WHERE announcementID='$id'";
	                                     $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
	                                        $content= "<div class='wrapper'>
                                                          <h1 class='content_header'>Announcement Details</h1>
					
			                                              <div class='clear'></div>
					                                      <div class='step' id='first'>      
		                                                        <p><h1 class='content_header'><u>TITLE:</u> ".$result['title']."<h1/><p/>
						                                        <p><h1 class='content_header'><u>DESCRIPTION:</u> ".$result['content']."<h1/><p/>
						                                        <p><h1 class='content_header'><u>ATTACHED FILE:</u> <a href='41.86.176.19/files/".$result['file']."' style='text-decoration:none; color:orange'>".$result['file']."</a><h1/></p>
		                                                  </div>
					                                   </div>";
											}
		  
	                                  }else{
	                                     $sql="SELECT announcementID, title, content, publishTime FROM announcement ORDER BY publishTime DESC";
		                                 $headers[0]=$this->get_table_header('No.','number');
		                                 $headers[1]=$this->get_table_header('Title','default');
										 $headers[2]=$this->get_table_header('Description','default');
		                                 $headers[3]=$this->get_table_header('Date Published','default');
		                                 $caption='Announcements';
		                                 $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
	                                 }break;
					
					case 'dash_pastprojects': 
					                  if(isset($_GET['id'])){
	                                     $id=$_GET['id'];
		                                 $sql="SELECT * FROM pastprojects WHERE projectID='$id'";
	                                     $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
	                                        $content= "<div class='wrapper'>
                                                         <h1 class='content_header'>Project Details</h1>
					
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>      
		                                                  <p><h1 class='content_header'><u>TITLE:</u> ".$result['title']."<h1/><p/>
							                              <p><h1 class='content_header'><u>STUDENT NAME:</u> ".$result['studentName']."<h1/><p/>
							                              <p><h1 class='content_header'><u>SUPERVISOR:</u> ".$result['supervisorName']."<h1/><p/>
						                                  <p><h1 class='content_header'><u>YEAR:</u> ".$result['year']."<h1/><p/>
							                              <p><h1 class='content_header'><u>REMARKS:</u> ".$result['remarks']."<h1/><p/>
						                                  <p><h1 class='content_header'><u>ATTACHED FILE:</u> <a href='41.86.176.19/files/".$result['content_file']."' style='text-decoration:none; color:orange'>".$result['content_file']."</a><h1/></p>
		                                                 </div>
					                                   </div>";
										 }
		 
	                                  }else{
	                                     $sql="SELECT projectID, title, studentName, supervisorName, year FROM pastprojects ORDER BY year DESC";
		                                 $headers[0]=$this->get_table_header('No.','number');
		                                 $headers[1]=$this->get_table_header('Project Title','default');
		                                 $headers[2]=$this->get_table_header('Student Name','default');
		                                 $headers[3]=$this->get_table_header('Supervisor Name','default');
		                                 $headers[4]=$this->get_table_header('Year','default');  
		                                 $caption='Previous Projects';
		                                 $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
		                              }break;
					
					case 'dash_titleideas':	
					                  $sql="SELECT titleID, title, content, supervisorLastName, publishTime FROM titleideas 
			                                INNER JOIN supervisors ON supervisors.supervisorID = titleideas.supervisorID
				                            ORDER BY publishTime DESC";
		                              $headers[0]=$this->get_table_header('No.','number');
		                              $headers[1]=$this->get_table_header('Project Title','default');
		                              $headers[2]=$this->get_table_header('Description','default');
		                              $headers[3]=$this->get_table_header('Supervisor Name','default');
		                              $headers[4]=$this->get_table_header('Date Published','default');
		                              $caption='Title Ideas';
		                              $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',false,false,false);break;
									  
					case 'dash_titleproposal':	
                                      date_default_timezone_set('Africa/Nairobi');
									  $year = date("Y");                                      
									  
									  $sql="SELECT proposalID, title, studentLastName, supervisorLastName, submissionTime, comment, panelApproval FROM titleproposal
				                            INNER JOIN students ON students.studentID = titleproposal.studentID
				                            INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
				                            WHERE (supervisorApproval='Accepted') AND (panelApproval != 'NULL') AND (DATE_FORMAT(submissionTime, '%Y')='$year')
			                                ORDER BY submissionTime DESC";
		                              $headers[0]=$this->get_table_header('No.','number');
		                              $headers[1]=$this->get_table_header('Project Title','default');
		                              $headers[2]=$this->get_table_header('Student Name','default');
		                              $headers[3]=$this->get_table_header('Supervisor Name','default');
		                              $headers[4]=$this->get_table_header('Submission Time','default');
		                              $headers[5]=$this->get_table_header('Comment','default');
		                              $headers[6]=$this->get_table_header('Status','default');
		                              $caption='Project Titles';
		                              $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',false,false,false);break;
					
					case 'announcements':
									  $sql="SELECT announcementID, title, content, publishTime FROM announcement ORDER BY publishTime DESC";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Title','default');
									  $headers[2]=$this->get_table_header('Description','default');
									  $headers[3]=$this->get_table_header('Date Published','default');
									  $headers[4]=$this->get_table_header('Action','action'); 
									  $caption='Announcements';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Action',false,false,false);break;
		                              
					
					case 'sessions':  
									  $sql="SELECT sessionID,title,startTime,endTime FROM sessions ORDER BY title ASC";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Session Name','default');
									  $headers[2]=$this->get_table_header('Start','default');
									  $headers[3]=$this->get_table_header('End','default');
									  $headers[4]=$this->get_table_header('Set time','action');
									  $caption='Sessions';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',false,false,false);break;
					
					
					case 'previous_projects':
									  $sql="SELECT projectID, title, studentName, supervisorName, year FROM pastprojects ORDER BY year DESC";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Project Title','default');
									  $headers[2]=$this->get_table_header('Student Name','default');
									  $headers[3]=$this->get_table_header('Supervisor Name','default');
									  $headers[4]=$this->get_table_header('Year','default'); 
									  $headers[5]=$this->get_table_header('Action','action');
									  $caption='Previous Projects';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Action',false,false,false);break;
									  
									  
					case 'titles':    
					                  date_default_timezone_set('Africa/Nairobi');
									  $year = date("Y");
									  
									  $sql="SELECT proposalID, title, studentLastName, supervisorLastName, supervisorComment, supervisorApproval, submissionTime, comment, panelApproval FROM titleproposal
									        INNER JOIN students ON students.studentID = titleproposal.studentID
									        INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
									        WHERE (supervisorApproval='Accepted') AND (DATE_FORMAT(submissionTime, '%Y')='$year') 
									        ORDER BY submissionTime ASC";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Project Title','default');
									  $headers[2]=$this->get_table_header('Student Name','default');
									  $headers[3]=$this->get_table_header('Supervisor Name','default');
									  $headers[4]=$this->get_table_header('Supervisor Comment','default');
									  $headers[5]=$this->get_table_header('Signature','default');
									  $headers[6]=$this->get_table_header('Submission Time','default');
									  $headers[7]=$this->get_table_header('Comment','default');
									  $headers[8]=$this->get_table_header('Status','default');
									  $headers[9]=$this->get_table_header('Approval','action');
									  $caption='Project Proposals';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',false,false,true);break;
									  
					case 'reports':  
					                 $semesterStart=$semesterEnd=$timeStart=$timeEnd='';
					                
									 $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									 $results=$this->connect->createCommand($sql)->query();
									 foreach ($results as $result){
									   $semesterEnd = $result['endTime'];
									   $semesterStart = $result['startTime'];
									 } 
									 
									 $sql="SELECT endTime, startTime FROM sessions WHERE title='Final Report Submission'";
									 $results=$this->connect->createCommand($sql)->query();
									 foreach ($results as $result){
									   $timeEnd = $result['endTime'];
									   $timeStart = $result['startTime'];
									 } 
									  
									  $sql="SELECT reportID, studentLastName, title, submissionTime, supervisorLastName, examinerLastName FROM projectreport
									        INNER JOIN students ON students.studentID = projectreport.studentID
									        INNER JOIN supervisors ON supervisors.supervisorID = projectreport.supervisorID
									        INNER JOIN examiners ON examiners.examinerID = projectreport.independentExaminerID
									        WHERE (projectreport.supervisorApproval='Accepted') AND (students.yearStudy=3) AND (projectreport.submissionTime>'$semesterStart') AND (projectreport.submissionTime<'$semesterEnd') AND (projectreport.submissionTime>'$timeStart') AND (projectreport.submissionTime<'$timeEnd')
									        ORDER BY submissionTime ASC";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Student Name','default');
									  $headers[2]=$this->get_table_header('Project Title','default');
									  $headers[3]=$this->get_table_header('Submission Time','default');
									  $headers[4]=$this->get_table_header('Supervisor Name','default');
									  $headers[5]=$this->get_table_header('Independent Examiner','default');
									  $headers[6]=$this->get_table_header('Action','action');
									  $caption='Project Reports';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',false,false,true);break;

					case 'progress':				  
                                      $semesterStart=$semesterEnd=$timeStart=$timeEnd='';
					                
									  $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									  $results=$this->connect->createCommand($sql)->query();
									  foreach ($results as $result){
									    $semesterEnd = $result['endTime'];
									    $semesterStart = $result['startTime'];
									  } 
									 
									  $sql="SELECT endTime, startTime FROM  sessions WHERE title='Progress Report Submission'";
									  $results=$this->connect->createCommand($sql)->query();
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
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,true);break;
 
		            case 'attendances': 
					                  $semesterStart=$semesterEnd='';
									  $sql="SELECT endTime, startTime FROM  sessions WHERE title='Semester duration'";
									  $results=$this->connect->createCommand($sql)->query();
									  foreach ($results as $result){
									   $semesterEnd = $result['endTime'];
									   $semesterStart = $result['startTime'];
									  } 
					
					                  if(isset($_GET['id'])){
	                                      $id=$_GET['id']; 
										 
		                                  $sql="SELECT studentLastName FROM students WHERE studentID='$id'";
										  $results=$this->connect->createCommand($sql)->query();
                                          foreach ($results as $result){
										     $name=$result['studentLastName'];
                                          }											 
										 
										  $sql="SELECT attendanceID, weekNo, description, comment, attendanceTime FROM attendances 
										        WHERE (studentID='$id') AND (attendanceTime>'$semesterStart') AND (attendanceTime<'$semesterEnd')";
										  $headers[0]=$this->get_table_header('No.','number');
									      $headers[1]=$this->get_table_header('Week No.','default');
									      $headers[2]=$this->get_table_header('Work Description','default');
										  $headers[3]=$this->get_table_header('Comment','default');
										  $headers[4]=$this->get_table_header('Attendence Time','default');
									      $caption='Attendance Report of '.$name;
									      $content= $this->get_table_view_attendances($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,true,$id);
										  
	                                  }else{
									      $sql="SELECT DISTINCT students.studentID,  studentLastName, title, supervisorLastName FROM students
									            INNER JOIN supervisors ON supervisors.supervisorID = students.supervisorID
									            INNER JOIN titleproposal ON titleproposal.studentID = students.studentID
												WHERE students.yearStudy=3
												ORDER BY studentLastName ASC";
									      $headers[0]=$this->get_table_header('No.','number');
									      $headers[1]=$this->get_table_header('Student Name','default');
									      $headers[2]=$this->get_table_header('Title','default');
									      $headers[3]=$this->get_table_header('Supervisor Name','default');
									      $caption='Attendances Reports';
									      $content= $this->get_table_attendance($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',true);
									  }break;	 
					
					
					case 'presentation':
					                $endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Oral Presentation'";
									$results=$this->connect->createCommand($sql)->query();
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
									  $headers[1]=$this->get_table_header('Student Name','default');
									  $headers[2]=$this->get_table_header('Organisation','default');
									  $headers[3]=$this->get_table_header('Content','default');
									  $headers[4]=$this->get_table_header('Goals & Accomplishment','default');
									  $headers[5]=$this->get_table_header('Plan','default');
									  $headers[6]=$this->get_table_header('Delivery','default');
									  $headers[7]=$this->get_table_header('Multimedia Use','default');
									  $headers[8]=$this->get_table_header('Questions','default');
									  $headers[9]=$this->get_table_header('Total, 30','default');
									  $headers[10]=$this->get_table_header('Evaluator','default');
									  $headers[11]=$this->get_table_header('Edit','action'); //'Approval'
									  $caption='Oral presentation marks';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Approval',false,false,true);
									}else {
									  $content= "<div class='wrapper'>
                                                 <h1 class='content_header'>oral Presentation Evaluation window is currently <u>closed</u>!</h1>
											     </div>";
									}break;
					
					case 'markingreport':
					                
									$endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
									$results=$this->connect->createCommand($sql)->query();
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
										  $headers[7]=$this->get_table_header('Edit','action');
									      $caption='Project Reports Marks';
									      $content.= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Approval',false,false,true);
									}else {
									  $content= "<div class='wrapper'>
                                                 <h1 class='content_header'>Report Marking window is currently <u>closed</u>!</h1>
											     </div>";
									}break;
					
					case 'studentperformance':
					                $endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
									$results=$this->connect->createCommand($sql)->query();
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
									      $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,true);
                                    }else{
									  $content= "<div class='wrapper'>
                                                 <h1 class='content_header'>Marking window is currently <u>closed</u>!</h1>
											     </div>";
									}break;					
					
					
					case 'results':
									$semesterStart='';
					                $semesterEnd='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Semester duration'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									   $semesterEnd = $result['endTime'];
									   $semesterStart = $result['startTime'];
									} 

									$endTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Final Report Submission'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									   $endTime = $result['endTime'];
									}
									
									$sql="SELECT * FROM students 
                 						  INNER JOIN titleproposal ON titleproposal.studentID=students.studentID AND students.yearStudy=3";
                                    $results=$this->connect->createCommand($sql)->query();
                                    foreach ($results as $result){
								      $studentID=$result['studentID'];
									  $oralPresentation='';
									  $sql="SELECT AVG(total_score) FROM prentationevaluations WHERE (studentID='$studentID') AND (time>'$semesterStart') AND (time<'$semesterEnd')";
									  $results=$this->connect->createCommand($sql)->query();
									  foreach ($results as $result){
									     $oralPresentation = $result['AVG(total_score)'];
									  }
									  $projectReport='';
									  $sql="SELECT AVG(total_score) FROM reportmarks WHERE (studentID='$studentID') AND (time>'$semesterStart') AND (time<'$semesterEnd')";
									  $results=$this->connect->createCommand($sql)->query();
									  foreach ($results as $result){
									     $projectReport = $result['AVG(total_score)'];
									  }
									  $studentPerformance='';
									  $sql="SELECT performance_score FROM performance WHERE (studentID='$studentID') AND (time>'$semesterStart') AND (time<'$semesterEnd')";
									  $results=$this->connect->createCommand($sql)->query();
									  foreach ($results as $result){
									     $studentPerformance = $result['performance_score'];
									  }
									  $submissionTime='';
									  $sql="SELECT submissionTime FROM projectreport
                                            INNER JOIN reportmarks ON reportmarks.studentID=projectreport.studentID
		                                    WHERE (projectreport.studentID='$studentID') AND (projectreport.supervisorApproval='Accepted')";
									  $results=$this->connect->createCommand($sql)->query();
									  foreach ($results as $result){
									     $submissionTime = $result['submissionTime'];
									  }
									  
									  $d = date('d', strtotime($submissionTime)) - date('d', strtotime($endTime)); 
                                      $h = date('h', strtotime($submissionTime)) - date('h', strtotime($endTime)); 
                                      $i = date('i', strtotime($submissionTime)) - date('i', strtotime($endTime));
                                      $penalty=0.00;
                                      if ($d > 1){
                                         $penalty=30.00;
                                      }else if ($d > 0){
                                         $penalty=20.00;
                                      }else if ($d == 0){
                                          if ($i > 0){
	                                          $penalty=10.00;   
	                                      }
                                      } else{
                                         $penalty=0.00;
                                      } 
                                      $total=$studentPerformance+$oralPresentation+$projectReport-$penalty;
                                    
									  $sql="SELECT studentID FROM results WHERE studentID='$studentID'";
									  $results=$this->connect->createCommand($sql)->query();
									  $rows=count($results);
									  if ($rows==0){
	                                      $sql="INSERT INTO results SET studentID='$studentID', studentPerformance='$studentPerformance', oralPresentation='$oralPresentation', projectReport='$projectReport', penalty='$penalty', total='$total' ";
                                          $results=$this->connect->createCommand($sql)->query();
                                      }else {
	                                      $sql="UPDATE results SET studentPerformance='$studentPerformance', oralPresentation='$oralPresentation', projectReport='$projectReport', penalty='$penalty', total='$total' WHERE studentID='$studentID' ";
                                          $results=$this->connect->createCommand($sql)->query();
	                                  }			  
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
									  $headers[8]=$this->get_table_header('Action','action');
									  $caption='Students Results';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',false,false,true);break;	
									  
					}							               
					
		
		}else if($action=='add') {			  
			  switch($sub_position){
					case 'announcements':      
									   $sql="SELECT title, content, file, publishTime  FROM announcement WHERE announcementID=:value";
									   $values=$this->get_form_fields(3,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text');
			                           $inputs_step_1.=$this->get_input_text_area('content',$values[1],'Content',false); 
			                           $inputs_step_1.=$this->get_input_file('file',$values[2],'File',false); 
									  						
									   $content= $this->form_builder('Announcement Details','add',$inputs_step_1,'','add');break;
									   
									   
					/*case 'sessions':      
									   $sql="SELECT title,startTime,endTime FROM sessions WHERE sessionID=:value";
									   $values=$this->get_form_fields(3,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Session Name',true,null,'session');
			                           $inputs_step_1.=$this->get_input_date('startTime',$values[1],'Starting Date',true,null); 
			                           $inputs_step_1.=$this->get_input_date('endTime',$values[2],'Ending Date',true,null);  
									  						
									   $content= $this->form_builder('Session Details','add',$inputs_step_1,'','add');break;*/				   
					
					case 'previous_projects':      
									   $sql="SELECT title, studentName, supervisorName, year, remarks, content_file FROM pastprojects WHERE projectID=:value";
									   $values=$this->get_form_fields(6,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text');
			                           $inputs_step_1.=$this->get_input_text('studentName',$values[1],'Student Name',true,null,'text'); 
			                           $inputs_step_1.=$this->get_input_text('supervisorName',$values[2],'Supervisor',true,null,'text');
									   $inputs_step_1.=$this->get_input_numbers('year',$values[3],'Completion Year',true,null, 'years');
									   $inputs_step_1.=$this->get_input_text_area('remarks',$values[4],'Remarks',true); 
									   $inputs_step_1.=$this->get_input_file('content_file',$values[5],'File',true);
									  						
									   $content= $this->form_builder('Project Details','add',$inputs_step_1,'','add');break;
					
					}
					
		}else if($action=='edit') {			  
			  switch($sub_position){
					case 'announcements':      
									   $sql="SELECT title, content, file, publishTime  FROM announcement WHERE announcementID=:value";
									   $values=$this->get_form_fields(3,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text');
			                           $inputs_step_1.=$this->get_input_text_area('content',$values[1],'Content',false); 
			                           $inputs_step_1.=$this->get_input_file('file',$values[2],'File',false); 					
									   
									   $content= $this->form_builder('Announcement Details','add',$inputs_step_1,'','edit');break;
									   
									   
					case 'sessions':      
									   $sql="SELECT title,startTime,endTime FROM sessions WHERE sessionID=:value";
									   $values=$this->get_form_fields(3,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   //$inputs_step_1=$this->get_input_text('title',$values[0],'Session Name',true,null,'session');
			                           $inputs_step_1=$this->get_input_date('startTime',$values[1],'Starting Date',true,null); 
			                           $inputs_step_1.=$this->get_input_date('endTime',$values[2],'Ending Date',true,null);  
									  						
									   $content= $this->form_builder('Session Details','add',$inputs_step_1,'','edit');break;				   
					
					case 'previous_projects':      
									   $sql="SELECT title, studentName, supervisorName, year, remarks, content_file FROM pastprojects WHERE projectID=:value";
									   $values=$this->get_form_fields(6,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text');
			                           $inputs_step_1.=$this->get_input_text('studentName',$values[1],'Student Name',true,null,'text'); 
			                           $inputs_step_1.=$this->get_input_text('supervisorName',$values[2],'Supervisor',true,null,'text');
									   $inputs_step_1.=$this->get_input_numbers('year',$values[3],'Completion Year',true,null,'years');
									   $inputs_step_1.=$this->get_input_text_area('remarks',$values[4],'Remarks',true);
									   $inputs_step_1.=$this->get_input_file('content_file',$values[5],'File',false);
									  						
									   $content= $this->form_builder('Project Details','add',$inputs_step_1,'','edit');break;
					
					case 'titles':      
									   $sql="SELECT title, supervisorLastName, comment, panelApproval FROM titleproposal
									         INNER JOIN students ON students.studentID = titleproposal.studentID
									         INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
									         WHERE proposalID=:value";
									   $values=$this->get_form_fields(4,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text'); 
			                           $inputs_step_1.=$this->get_input_text('supervisorLastName',$values[1],'Supervisor',true,null,'supervisor');
									   $inputs_step_1.=$this->get_input_text_area('comment',$values[2],'Comment',false);
									   $inputs_step_1.=$this->get_input_text('panelApproval',$values[3],'Approval',true,null,'approval');
									  						
									   $content= $this->form_builder('Title Proposals','add',$inputs_step_1,'','edit');break;
									   
					case 'reports':
                                       $sql="SELECT independentExaminerID FROM projectreport WHERE reportID=:value";				
									   $values=$this->get_form_fields(1,$sql,$sub_position,$action,$position);
									   
									   $inputs_step_1=$this->get_input_text('independentExaminer',$values[0],'Examiner',true,null,'supervisor');
									   
									   $content= $this->form_builder('Assign Independent Examiner','add',$inputs_step_1,'','edit');break;
					
                    case 'presentation':
					                   $sql="SELECT studentID, organisation_score, content_score, accomplishment_score, plan_score, delivery_score, multimedia_score, questions_score FROM prentationevaluations WHERE evaluationID=:value";
									   $values=$this->get_form_fields(8,$sql,$sub_position,$action,$position);
									   
									   $inputs_step_1=$this->get_input_text('studentID',$values[0],'Student Name',true,null,'student');
									   $inputs_step_1.=$this->get_input_numbers('organisation_score',$values[1],'Organisation',true,null,'five');
									   $inputs_step_1.=$this->get_input_numbers('content_score',$values[2],'Content',true,null,'six');
									   $inputs_step_1.=$this->get_input_numbers('accomplishment_score',$values[3],'Accomplishment',true,null,'five');
									   $inputs_step_1.=$this->get_input_numbers('plan_score',$values[4],'Plan',true,null,'four');
									   $inputs_step_1.=$this->get_input_numbers('delivery_score',$values[5],'Delivery',true,null,'four');
									   $inputs_step_1.=$this->get_input_numbers('multimedia_score',$values[6],'Multimedia',true,null,'three');
									   $inputs_step_1.=$this->get_input_numbers('questions_score',$values[7],'Question',true,null,'three');
									   
									   $content= $this->form_builder('Oral Presentation Evaluation','add',$inputs_step_1,'','edit');break;
					
					case 'markingreport':
					                    $sql="SELECT studentID, grammar_score, content_score, accomplishment_score FROM reportmarks WHERE markingID=:value";
                                        $values=$this->get_form_fields(4,$sql,$sub_position,$action,$position);
										
										$inputs_step_1=$this->get_input_numbers('grammar_score',$values[1],'Grammar',true,null,'ten');
										$inputs_step_1.=$this->get_input_numbers('content_score',$values[2],'Content',true,null,'forty');
										$inputs_step_1.=$this->get_input_numbers('accomplishment_score',$values[3],'Accomplishment',true,null,'ten');
										
										$content= $this->form_builder('Marking Report','add',$inputs_step_1,'','edit');break;
					
					case 'results':	
                                       $sql="SELECT externalMarks FROM results WHERE resultID=:value";				
									   $values=$this->get_form_fields(1,$sql,$sub_position,$action,$position);
									   
									   $inputs_step_1=$this->get_input_numbers('externalMarks',$values[0],'External Marks',true,null,'marks');
									   
									   $content= $this->form_builder('Assign Independent Examiner','add',$inputs_step_1,'','edit');break;
									   
									   
					}			
		
		}else if($action=='delete') {
		      switch($sub_position){
					 case 'announcements': 					
					                   $id=$_GET['value'];
					                   $sql="SELECT file FROM announcement WHERE announcementID=$id"; //deleting attachment file from saving folder
                                       $results=$this->connect->createCommand($sql)->query();			
					                   foreach ($results as $result){
                                         $data=(array) $result;					
                                         if(!empty($data['file'])){
                       		                @unlink($data['file']);
									     }
                                       }
                  
				                         //deleting data in the database
					                   $sql="DELETE FROM announcement WHERE announcementID=$id";				  
				                       $sql=$this->connect->createCommand($sql)->query();
			
		
					                     //view after deleting								   
									   $content= $this->get_manage_one($position,$sub_position,'view');break;

                     /*case 'sessions':
					                   $id=$_GET['value'];
					                 
									   $sql="DELETE FROM sessions WHERE sessionID=$id";				  
				                       $sql=$this->connect->createCommand($sql)->query();
					                 
									   $content= $this->get_manage_one($position,$sub_position,'view');break;*/
					                  
					 case 'previous_projects': 					
					                   $id=$_GET['value'];
					                   $sql="SELECT content_file FROM pastprojects WHERE projectID=$id"; //deleting attachment file from saving folder
                                       $results=$this->connect->createCommand($sql)->query();			
					                   foreach ($results as $result){
                                         $data=(array) $result;						
                                         if(!empty($data['file'])){
                       		                @unlink($data['file']); 
                                         }
									   }
                  
				                         //deleting data in the database
					                   $sql="DELETE FROM pastprojects WHERE projectID=$id";				  
				                       $sql=$this->connect->createCommand($sql)->query();
									   
									   $content= $this->get_manage_one($position,$sub_position,'view');break;
					 
					}					
		
		}
		
	return $content;
	}
	
	
	public function get_manage_two($position,$sub_position,$action){
		$extra=false;
		 if($action=='view'){		
				switch($sub_position){
					case 'dash_announcements':
					                  if(isset($_GET['id'])){
									     $id=$_GET['id'];
		                                 $sql="SELECT * FROM announcement WHERE announcementID='$id'";
	                                     $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
	                                        $content= "<div class='wrapper'>
                                                          <h1 class='content_header'>Announcement Details</h1>
					
			                                              <div class='clear'></div>
					                                      <div class='step' id='first'>      
		                                                        <p><h1 class='content_header'><u>TITLE:</u> ".$result['title']."<h1/><p/>
						                                        <p><h1 class='content_header'><u>DESCRIPTION:</u> ".$result['content']."<h1/><p/>
						                                        <p><h1 class='content_header'><u>ATTACHED FILE:</u> <a href='41.86.176.19/files/".$result['file']."' style='text-decoration:none; color:orange'>".$result['file']."</a><h1/></p>
		                                                  </div>
					                                   </div>";
											}
		  
	                                  }else{
	                                     $sql="SELECT announcementID, title, content, publishTime FROM announcement ORDER BY publishTime DESC";
		                                 $headers[0]=$this->get_table_header('No.','number');
		                                 $headers[1]=$this->get_table_header('Title','default');
										 $headers[2]=$this->get_table_header('Description','default');
		                                 $headers[3]=$this->get_table_header('Date Published','default');
		                                 $caption='Announcements';
		                                 $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
	                                 }break;
					
					case 'dash_pastprojects':
					                  if(isset($_GET['id'])){
								         $id=$_GET['id'];
		                                 $sql="SELECT * FROM pastprojects WHERE projectID='$id'";
	                                     $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
	                                        $content= "<div class='wrapper'>
                                                         <h1 class='content_header'>Project Details</h1>
					
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>      
		                                                  <p><h1 class='content_header'><u>TITLE:</u> ".$result['title']."<h1/><p/>
							                              <p><h1 class='content_header'><u>STUDENT NAME:</u> ".$result['studentName']."<h1/><p/>
							                              <p><h1 class='content_header'><u>SUPERVISOR:</u> ".$result['supervisorName']."<h1/><p/>
						                                  <p><h1 class='content_header'><u>YEAR:</u> ".$result['year']."<h1/><p/>
							                              <p><h1 class='content_header'><u>REMARKS:</u> ".$result['remarks']."<h1/><p/>
						                                  <p><h1 class='content_header'><u>ATTACHED FILE:</u> <a href='41.86.176.19/files/".$result['content_file']."' style='text-decoration:none; color:orange'>".$result['content_file']."</a><h1/></p>
		                                                 </div>
					                                   </div>";
										 }
		 
	                                  }else{
	                                     $sql="SELECT projectID, title, studentName, supervisorName, year FROM pastprojects ORDER BY year DESC";
		                                 $headers[0]=$this->get_table_header('No.','number');
		                                 $headers[1]=$this->get_table_header('Project Title','default');
		                                 $headers[2]=$this->get_table_header('Student Name','default');
		                                 $headers[3]=$this->get_table_header('Supervisor Name','default');
		                                 $headers[4]=$this->get_table_header('Year','default'); 
		                                 $caption='Previous Projects';
		                                 $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
		                              }break;
					
					case 'dash_titleideas':	
					                  $sql="SELECT titleID, title, content, supervisorLastName, publishTime FROM titleideas 
			                                INNER JOIN supervisors ON supervisors.supervisorID = titleideas.supervisorID
				                            ORDER BY publishTime DESC";
		                              $headers[0]=$this->get_table_header('No.','number');
		                              $headers[1]=$this->get_table_header('Project Title','default');
		                              $headers[2]=$this->get_table_header('Description','default');
		                              $headers[3]=$this->get_table_header('Supervisor Name','default');
		                              $headers[4]=$this->get_table_header('Date Published','default');
		                              $caption='Title Ideas';
		                              $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',false,false,false);break;
									  
					case 'dash_titleproposal':				  
									  date_default_timezone_set('Africa/Nairobi');
									  $year = date("Y");                                      
									  
									  $sql="SELECT proposalID, title, studentLastName, supervisorLastName, submissionTime, comment, panelApproval FROM titleproposal
				                            INNER JOIN students ON students.studentID = titleproposal.studentID
				                            INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
				                            WHERE (supervisorApproval='Accepted') AND (panelApproval != 'NULL') AND (DATE_FORMAT(submissionTime, '%Y')='$year')
			                                ORDER BY submissionTime DESC";
		                              $headers[0]=$this->get_table_header('No.','number');
		                              $headers[1]=$this->get_table_header('Project Title','default');
		                              $headers[2]=$this->get_table_header('Student Name','default');
		                              $headers[3]=$this->get_table_header('Supervisor Name','default');
		                              $headers[4]=$this->get_table_header('Submission Time','default');
		                              $headers[5]=$this->get_table_header('Comment','default');
		                              $headers[6]=$this->get_table_header('Status','default');
		                              $caption='Project Titles';
		                              $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',false,false,false);break;				  
					
					case 'ideas':
									  $userId=Yii::app()->user->id; 
									  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                      $results=$this->connect->createCommand($sql)->query();
                                      foreach ($results as $result){
                                         $supervisorID=$result['supervisorID'];
                                      }
									  
									  $sql="SELECT titleID, title, content, publishTime FROM titleideas 
									        WHERE supervisorID='$supervisorID'
									        ORDER BY publishTime DESC";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Project Title','default');
									  $headers[2]=$this->get_table_header('Project Description','default');
									  $headers[3]=$this->get_table_header('Publish Time','default');
									  $headers[4]=$this->get_table_header('Action','action'); 
									  $caption='Title Ideas';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Action',false,false,false);break;
		                              
					
					case 'titlesSupervisor':  
					                  date_default_timezone_set('Africa/Nairobi');
									  $year = date("Y");
									  
									  $userId=Yii::app()->user->id; 
									  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                      $results=$this->connect->createCommand($sql)->query();
                                      foreach ($results as $result){
                                         $supervisorID=$result['supervisorID'];
                                      }
									  
									  $sql="SELECT proposalID, studentLastName, title, content, supervisorComment, supervisorApproval FROM titleproposal
									        INNER JOIN students ON students.studentID = titleproposal.studentID
											INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
									        WHERE (titleproposal.supervisorID='$supervisorID') AND (DATE_FORMAT(proposedTime, '%Y')='$year')";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Student Name','default');
									  $headers[2]=$this->get_table_header('Project Title','default');
									  $headers[3]=$this->get_table_header('Description','default');
									  $headers[4]=$this->get_table_header('Comment','default');
									  $headers[5]=$this->get_table_header('Status','default');
									  $headers[6]=$this->get_table_header('Acceptance','action');
									  $caption='Project Proposals';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',false,false,false);break;
					
					case 'titlesToSupervisors':
					                  date_default_timezone_set('Africa/Nairobi');
									  $year = date("Y");
									  
									  $userId=Yii::app()->user->id; 
									  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                      $results=$this->connect->createCommand($sql)->query();
                                      foreach ($results as $result){
                                         $supervisorID=$result['supervisorID'];
                                      }
									  
					                  $sql="SELECT proposalID, studentLastName, title, content, SupervisorLastName, supervisorComment, supervisorApproval FROM titleproposal
									        INNER JOIN students ON students.studentID = titleproposal.studentID
											INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
											WHERE DATE_FORMAT(proposedTime, '%Y')='$year' AND titleproposal.supervisorID<>'$supervisorID'";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Student Name','default');
									  $headers[2]=$this->get_table_header('Project Title','default');
									  $headers[3]=$this->get_table_header('Description','default');
									  $headers[4]=$this->get_table_header('Supervisor Name','default');
									  $headers[5]=$this->get_table_header('Supervisor Comment','default');
									  $headers[6]=$this->get_table_header('Status','default');
									  $caption='Project Proposals';
									  $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,false);break;
					
					case 'progressSupervisor':	//new added
                                      if(isset($_GET['id'])){
									      $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									      $results=$this->connect->createCommand($sql)->query();
									      foreach ($results as $result){
									        $semesterEnd = $result['endTime'];
									        $semesterStart = $result['startTime'];
									      } 
										 
										  $string=strtotime($semesterStart);
									  
	                                      $id=$_GET['id']; 
										 
		                                  $sql="SELECT * FROM progress_report 
										        INNER JOIN students ON students.studentID=progress_report.studentID
												WHERE progress_report.reportID='$id'";
										  $results=$this->connect->createCommand($sql)->query();
                                          foreach ($results as $result){
										      $name=$result['studentLastName'];
                                              $name=$result['title'];	
										      $file=$result['content_file'];
										  }
										 
										  $content= "<div class='wrapper'>
                                                       <h1 class='content_header'>Report Details</h1>
					
			                                         <div class='clear'></div>
					                                 <div class='step' id='first'>      
		                                               <p><h1 class='content_header'>STUDENT NAME: ".$name."<h1/><p/>
						                               <p><h1 class='content_header'>PROJECT TITLE: ".$name."<h1/><p/>
						                               <p><h1 class='content_header'>REPORT FILE: <a href='pms.tanzanianguru.com/files/".$string.$file."' style='text-decoration:none; color:orange'>".$file."</a><h1/></p>
		                                             </div>
					                                 </div>";
										  
	                                  }else{
									       $userId=Yii::app()->user->id; 
									       $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                           $results=$this->connect->createCommand($sql)->query();
                                           foreach ($results as $result){
                                              $supervisorID=$result['supervisorID'];
                                           }
										   
										   $semesterStart=$semesterEnd=$timeStart=$timeEnd='';
					                       $now=date('Y-m-d H:m:s');
										   
									       $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									       $results=$this->connect->createCommand($sql)->query();
									       foreach ($results as $result){
									          $semesterEnd = $result['endTime'];
									          $semesterStart = $result['startTime'];
									       } 
										   
										   $sql="SELECT reportID, studentLastName, title, supervisorApproval FROM progress_report
									             INNER JOIN students ON students.studentID = progress_report.studentID
										         WHERE (progress_report.supervisorID='$supervisorID') AND (submissionTime<'$semesterEnd') AND (submissionTime>'$semesterStart')";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Student Name','default');
									       $headers[2]=$this->get_table_header('Project Title','default');
									       $headers[3]=$this->get_table_header('Status','default');
									       $headers[4]=$this->get_table_header('Acceptance','action');
									       $caption='Progress Reports';
									       $content= $this->get_table_progressReports($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',true,false,false);
									  }break;
					
					case 'reportsSupervisor':  
									  if(isset($_GET['id'])){
	                                      $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									      $results=$this->connect->createCommand($sql)->query();
									      foreach ($results as $result){
									        $semesterEnd = $result['endTime'];
									        $semesterStart = $result['startTime'];
									      } 
										 
										  $string=strtotime($semesterStart);
										  
										  $id=$_GET['id']; 
										 
		                                  $sql="SELECT * FROM projectreport 
										        INNER JOIN students ON students.studentID=projectreport.studentID
												WHERE projectreport.reportID='$id'";
										  $results=$this->connect->createCommand($sql)->query();
                                          foreach ($results as $result){
										      $name=$result['studentLastName'];
                                              $name=$result['title'];	
										      $file=$result['content_file'];
										  }
										 
										  $content= "<div class='wrapper'>
                                                       <h1 class='content_header'>Report Details</h1>
					
			                                         <div class='clear'></div>
					                                 <div class='step' id='first'>      
		                                               <p><h1 class='content_header'>STUDENT NAME: ".$name."<h1/><p/>
						                               <p><h1 class='content_header'>PROJECT TITLE: ".$name."<h1/><p/>
						                               <p><h1 class='content_header'>REPORT FILE: <a href='pms.tanzanianguru.com/files/".$string.$file."' style='text-decoration:none; color:orange'>".$file."</a><h1/></p>
		                                             </div>
					                                 </div>";
										  
	                                  }else{
									       $userId=Yii::app()->user->id; 
									       $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                           $results=$this->connect->createCommand($sql)->query();
                                           foreach ($results as $result){
                                              $supervisorID=$result['supervisorID'];
                                           }
										   
										   $semesterStart=$semesterEnd=$timeStart=$timeEnd='';
					                       $now=date('Y-m-d H:m:s');
										   
									       $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									       $results=$this->connect->createCommand($sql)->query();
									       foreach ($results as $result){
									          $semesterEnd = $result['endTime'];
									          $semesterStart = $result['startTime'];
									       } 
										   
										   $sql="SELECT reportID, studentLastName, title, supervisorApproval FROM projectreport
									             INNER JOIN students ON students.studentID = projectreport.studentID
										         WHERE (projectreport.supervisorID='$supervisorID') AND (submissionTime<'$semesterEnd') AND (submissionTime>'$semesterStart')";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Student Name','default');
									       $headers[2]=$this->get_table_header('Project Title','default');
									       $headers[3]=$this->get_table_header('Status','default');
									       $headers[4]=$this->get_table_header('Acceptance','action');
									       $caption='Final Reports';
									       $content= $this->get_table_reports($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',true,false,false);
									  }break;


		            case 'attendances':					
									  if(isset($_GET['id'])){
	                                      $id=$_GET['id']; 
										  $semesterStart=$semesterEnd='';
									      $sql="SELECT endTime, startTime FROM  sessions WHERE title='Semester duration'";
									      $results=$this->connect->createCommand($sql)->query();
									      foreach ($results as $result){
									        $semesterEnd = $result['endTime'];
									        $semesterStart = $result['startTime'];
									      } 
		                                  $sql="SELECT studentLastName FROM students WHERE studentID='$id'";
										  $results=$this->connect->createCommand($sql)->query();
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
									      $content= $this->get_table_view_attendances($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,true,$id);
										  
	                                }else{
									       $userId=Yii::app()->user->id; 
									       $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                           $results=$this->connect->createCommand($sql)->query();
                                           foreach ($results as $result){
                                              $supervisorID=$result['supervisorID'];
                                           }
										  
										  $sql="SELECT DISTINCT students.studentID, studentLastName, title FROM students
										        INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
										        WHERE (students.supervisorID='$supervisorID') AND (yearStudy=3)
												ORDER BY studentLastName ASC";
									      $headers[0]=$this->get_table_header('No.','number');
									      $headers[1]=$this->get_table_header('Student Name','default');
									      $headers[2]=$this->get_table_header('Project Title','default');
									      $caption='Attendances Reports';
									      $content= $this->get_table_attendance($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'NoAction',true);
									}break;	 
					
					
					case 'evaluation': 
									$endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Oral Presentation'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									   $endTime = $result['endTime'];
									   $startTime = $result['startTime'];
									}
									//$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 3 days'));
								    date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							        if (($today >= $startTime) && ($today <= $endTime)) {  
									  $userId=Yii::app()->user->id; 
									  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                      $results=$this->connect->createCommand($sql)->query();
                                      foreach ($results as $result){
                                         $supervisorID=$result['supervisorID'];
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
									  $headers[10]=$this->get_table_header('Edit','action'); //'Approval'
									  $caption='Oral presentation marks';
									  $content= $this->get_table_view_attendances($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Approval',false,false,true,$supervisorID);
									}else {
									  $content= "<div class='wrapper'>
                                                 <h1 class='content_header'>oral Presentation Evaluation window is currently <u>closed</u>!</h1>
											     </div>";
									}break;
					
					case 'marking':	
                                    $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									    $semesterEnd = $result['endTime'];
									    $semesterStart = $result['startTime'];
									} 
										 
								    $string=strtotime($semesterStart);
									
									$endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									   $endTime = $result['endTime'];
									   $startTime = $result['startTime'];
									}
									//$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 3 days'));
								    date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							        if (($today >= $startTime) && ($today <= $endTime)) { 
                                      $content= "<div class='wrapper'>
                                                      <h1 class='content_header'><u>Important Reminder:</u> Deadline for final reports marking is on <u>".date('l jS \of F Y h:i a', strtotime($endTime))."</u></h1>
													  </div>";									
									  if(isset($_GET['id'])){
	                                      $id=$_GET['id']; 
										 
		                                  $sql="SELECT * FROM projectreport 
										        INNER JOIN students ON students.studentID=projectreport.studentID
												WHERE projectreport.reportID='$id'";
										  $results=$this->connect->createCommand($sql)->query();
                                          foreach ($results as $result){
										       $name=$result['studentLastName'];
                                               $title=$result['title'];	
										       $file=$result['content_file'];
										  }
										 
										  $content.= "<div class='wrapper'>
                                                       <h1 class='content_header'>Report Details</h1>
					
			                                         <div class='clear'></div>
					                                 <div class='step' id='first'>      
		                                               <p><h1 class='content_header'>STUDENT NAME: ".$name."<h1/><p/>
						                               <p><h1 class='content_header'>PROJECT TITLE: ".$title."<h1/><p/>
						                               <p><h1 class='content_header'>REPORT FILE: <a href='41.86.176.19/files/".$string.$file."' style='text-decoration:none; color:orange'>".$file."</a><h1/></p>
		                                             </div>
					                                 </div>";
										  
	                                  }else{
									      $userId=Yii::app()->user->id; 
									      $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                          $results=$this->connect->createCommand($sql)->query();
                                          foreach ($results as $result){
                                            $supervisorID=$result['supervisorID'];
                                          }
										  
										  $sql="SELECT reportID,  studentLastName, title FROM projectreport
										        INNER JOIN students ON students.studentID=projectreport.studentID
										        WHERE (projectreport.supervisorID='$supervisorID') OR (projectreport.independentExaminerID='$supervisorID')
												ORDER BY studentLastName ASC";
									      $headers[0]=$this->get_table_header('No.','number');
									      $headers[1]=$this->get_table_header('Student Name','default');
										  $headers[2]=$this->get_table_header('Title','default');
									      $caption='Project Reports';
									      $content.= $this->get_table_marking($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',true,false,false);
								
								     	  $sql="SELECT markingID, studentLastName, grammar_score, content_score, accomplishment_score, total_score FROM reportmarks 
									            INNER JOIN students ON students.studentID = reportmarks.studentID
												WHERE reportmarks.markerID='$supervisorID'
									            ORDER BY studentLastName ASC"; 
									      $headers[0]=$this->get_table_header('No.','number');
									      $headers[1]=$this->get_table_header('Student Name','default');
									      $headers[2]=$this->get_table_header('General Format, 10','default');
									      $headers[3]=$this->get_table_header('Content, 40','default');
									      $headers[4]=$this->get_table_header('Goals & Accomplishment, 10','default');
									      $headers[5]=$this->get_table_header('Total, 60','default');
										  $headers[6]=$this->get_table_header('Edit','action');
									      $caption='Project Reports Marks';
									      $content.= $this->get_table_view_attendances($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Approval',false,false,true,$supervisorID);
									  }
									}else {
									  $content= "<div class='wrapper'>
                                                 <h1 class='content_header'>Report Marking window is currently <u>closed</u>!</h1>
											     </div>";
									}break;
									
					case 'performance':
                                    $endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Report Marking'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									   $endTime = $result['endTime'];
									   $startTime = $result['startTime'];
									}
									//$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 3 days'));
								    date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							        if (($today >= $startTime) && ($today <= $endTime)) {  
									  $content= "<div class='wrapper'>
                                                      <h1 class='content_header'><u>Important Reminder:</u> Deadline for students performance evaluation is on <u>".date('l jS \of F Y h:i a', strtotime($endTime))."</u></h1>
													  </div>";
									  if(isset($_GET['id'])){
	                                      $id=$_GET['id']; 
										 
		                                  $sql="SELECT studentLastName FROM students WHERE studentID='$id'";
										  $results=$this->connect->createCommand($sql)->query();
                                          foreach ($results as $result){
										     $name=$fetch['studentLastName'];
                                          } 											 
										 
										  $sql="SELECT attendanceID, weekNo, description, comment, attendanceTime FROM attendances WHERE studentID='$id'";
										  $headers[0]=$this->get_table_header('No.','number');
									      $headers[1]=$this->get_table_header('Week No.','default');
									      $headers[2]=$this->get_table_header('Work Description','default');
										  $headers[3]=$this->get_table_header('Comment','default');
										  $headers[4]=$this->get_table_header('Attendence Time','default');
									      $caption='Attendance Report of '.$name;
									      $content.= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction');
										  
	                                  }else{
									      $userId=Yii::app()->user->id; 
									      $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                          $results=$this->connect->createCommand($sql)->query();
                                          foreach ($results as $result){
                                            $supervisorID=$result['supervisorID'];
                                          }
										  
										  $sql="SELECT DISTINCT students.studentID, studentLastName, title FROM students
										        INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
										        WHERE (students.supervisorID='$supervisorID') AND (yearStudy=3)
												ORDER BY studentLastName ASC";
									      $headers[0]=$this->get_table_header('No.','number');
									      $headers[1]=$this->get_table_header('Student Name','default');
									      $headers[2]=$this->get_table_header('Project Title','default');
									      $caption='Attendances Reports';
									      $content.= $this->get_table_attendance($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',true);
									  }
									  $userId=Yii::app()->user->id; 
									  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                      $results=$this->connect->createCommand($sql)->query();
                                      foreach ($results as $result){
                                        $supervisorID=$result['supervisorID'];
                                      }
									  
									  $sql="SELECT performanceID, studentLastName, comment, performance_score FROM performance
									        INNER JOIN students ON students.studentID = performance.studentID
									        WHERE students.supervisorID='$supervisorID'
											ORDER BY studentLastName ASC";
									  $headers[0]=$this->get_table_header('No.','number');
									  $headers[1]=$this->get_table_header('Student Name','default');
									  $headers[2]=$this->get_table_header('General Comment','default');
									  $headers[3]=$this->get_table_header('General Performance, 10','default');
									  $headers[4]=$this->get_table_header('Edit','action');
									  $caption='Students General Performance';
									  $content.= $this->get_table_view_attendances($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'Approval',false,false,true,$supervisorID);
								    }else {
									  $content= "<div class='wrapper'>
                                                 <h1 class='content_header'>Students performance evaluation window is currently <u>closed</u>!</h1>
											     </div>";
								    }break;
					
				}							        
       
					
		
		}else if($action=='edit') {			  
			  switch($sub_position){
					case 'ideas':      
									   $sql="SELECT title, content FROM titleideas WHERE titleID=:value";
									   $values=$this->get_form_fields(2,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text');
			                           $inputs_step_1.=$this->get_input_text_area('content',$values[1],'Description',false);  
									  						
									   $content= $this->form_builder('Announcement Details','add',$inputs_step_1,'','edit');break;
					
					case 'titlesSupervisor': 
					                    $sql="SELECT supervisorComment FROM titleproposal WHERE proposalID=:value";
										$values=$this->get_form_fields(1,$sql,$sub_position,$action,$position);
										
					                    $inputs_step_1=$this->get_input_text_area('supervisorComment',$values[0],'Comment',true);
					                    $inputs_step_1.=$this->get_input_text('supervisorApproval',$values[1],'Approval',true,null,'approval');
										
					                    $content= $this->form_builder('Approval Title','add',$inputs_step_1,'','edit');break;
										
					case 'reportsSupervisor':					
										$sql="SELECT supervisorApproval FROM projectreport WHERE reportID=:value";
									    $values=$this->get_form_fields(1,$sql,$sub_position,$action,$position);
										
					                    $inputs_step_1=$this->get_input_text('supervisorApproval',$values[0],'Approval',true,null,'approval');
										
					                    $content= $this->form_builder('Approval Report','add',$inputs_step_1,'','edit');break;
					
                    case 'progressSupervisor':	//new added				
										$sql="SELECT supervisorApproval FROM progress_report WHERE reportID=:value";
									    $values=$this->get_form_fields(1,$sql,$sub_position,$action,$position);
										
					                    $inputs_step_1=$this->get_input_text('supervisorApproval',$values[0],'Approval',true,null,'approval');
										
					                    $content= $this->form_builder('Approval Report','add',$inputs_step_1,'','edit');break;
					
					case 'evaluation': 
					                   $sql="SELECT studentID, organisation_score, content_score, accomplishment_score, plan_score, delivery_score, multimedia_score, questions_score FROM prentationevaluations WHERE evaluationID=:value";
									   $values=$this->get_form_fields(8,$sql,$sub_position,$action,$position);
									   
									   $inputs_step_1=$this->get_input_text('studentID',$values[0],'Student Name',true,null,'student');
									   $inputs_step_1.=$this->get_input_numbers('organisation_score',$values[1],'Organisation',true,null,'five');
									   $inputs_step_1.=$this->get_input_numbers('content_score',$values[2],'Content',true,null,'six');
									   $inputs_step_1.=$this->get_input_numbers('accomplishment_score',$values[3],'Accomplishment',true,null,'five');
									   $inputs_step_1.=$this->get_input_numbers('plan_score',$values[4],'Plan',true,null,'four');
									   $inputs_step_1.=$this->get_input_numbers('delivery_score',$values[5],'Delivery',true,null,'four');
									   $inputs_step_1.=$this->get_input_numbers('multimedia_score',$values[6],'Multimedia',true,null,'three');
									   $inputs_step_1.=$this->get_input_numbers('questions_score',$values[7],'Question',true,null,'three');
									   
									   $content= $this->form_builder('Oral Presentation Evaluation','add',$inputs_step_1,'','edit');break;
					
					case 'marking':
					                    $sql="SELECT studentID, grammar_score, content_score, accomplishment_score FROM reportmarks WHERE markingID=:value";
                                        $values=$this->get_form_fields(4,$sql,$sub_position,$action,$position);
										
										$inputs_step_1=$this->get_input_numbers('grammar_score',$values[1],'Grammar',true,null,'ten');
										$inputs_step_1.=$this->get_input_numbers('content_score',$values[2],'Content',true,null,'forty');
										$inputs_step_1.=$this->get_input_numbers('accomplishment_score',$values[3],'Accomplishment',true,null,'ten');
										
										$content= $this->form_builder('Marking Report','add',$inputs_step_1,'','edit');break;
					
					case 'performance':
										$sql="SELECT comment, performance_score FROM performance WHERE performanceID=:value";
                                        $values=$this->get_form_fields(2,$sql,$sub_position,$action,$position);
										
										$inputs_step_1=$this->get_input_text_area('comment',$values[0],'General Comment',true);
										$inputs_step_1.=$this->get_input_numbers('performance_score',$values[1],'Performance',true,null,'ten');
										
										$content= $this->form_builder('Student Performance','add',$inputs_step_1,'','edit');break;
					
					}
		
		
		}else if($action=='add'){
		      switch($sub_position){
					case 'ideas':      
									   $sql="SELECT title, content FROM titleideas WHERE titleID=:value";
									   $values=$this->get_form_fields(2,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text');
			                           $inputs_step_1.=$this->get_input_text_area('content',$values[1],'Content',false);  
									  						
									   $content= $this->form_builder('Project Idea Details','add',$inputs_step_1,'','add');break;
					
					case 'attendances':
					                   $sql="SELECT studentID, weekNo, description, comment FROM attendances WHERE titleID=:value";
									   $values=$this->get_form_fields(4,$sql,$sub_position,$action,$position);
                    					
                                       $inputs_step_1=$this->get_input_text('studentID',$values[0],'Student Name',true,null,'studentSupervisor');
									   $inputs_step_1.=$this->get_input_numbers('weekNo',$values[1],'Week No.',true,null,'weeks');
									   $inputs_step_1.=$this->get_input_text_area('description',$values[2],'Description',true);
									   $inputs_step_1.=$this->get_input_text_area('comment',$values[3],'Comment',true);
									   
									   $content= $this->form_builder('Attendance Details','add',$inputs_step_1,'','add');break;
					
					case 'evaluation': 
					                   $sql="SELECT studentID, organisation_score, content_score, accomplishment_score, plan_score, delivery_score, multimedia_score, questions_score FROM prentationevaluations WHERE evaluationID=:value";
									   $values=$this->get_form_fields(8,$sql,$sub_position,$action,$position);
									   
									   $inputs_step_1=$this->get_input_text('studentID',$values[0],'Student Name',true,null,'student');
									   $inputs_step_1.=$this->get_input_numbers('organisation_score',$values[1],'Organisation',true,null,'five');
									   $inputs_step_1.=$this->get_input_numbers('content_score',$values[2],'Content',true,null,'six');
									   $inputs_step_1.=$this->get_input_numbers('accomplishment_score',$values[3],'Accomplishment',true,null,'five');
									   $inputs_step_1.=$this->get_input_numbers('plan_score',$values[4],'Plan',true,null,'four');
									   $inputs_step_1.=$this->get_input_numbers('delivery_score',$values[5],'Delivery',true,null,'four');
									   $inputs_step_1.=$this->get_input_numbers('multimedia_score',$values[6],'Multimedia',true,null,'three');
									   $inputs_step_1.=$this->get_input_numbers('questions_score',$values[7],'Question',true,null,'three');
									   
									   $content= $this->form_builder('Oral Presentation Evaluation','add',$inputs_step_1,'','add');break;
									   
					case 'marking':
					                    $sql="SELECT studentID, grammar_score, content_score, accomplishment_score FROM reportmarks WHERE markingID=:value";
                                        $values=$this->get_form_fields(4,$sql,$sub_position,$action,$position);
										
										$inputs_step_1=$this->get_input_text('studentID',$values[0],'Student Name',true,null,'studentMarking');
										$inputs_step_1.=$this->get_input_numbers('grammar_score',$values[1],'Grammar',true,null,'ten');
										$inputs_step_1.=$this->get_input_numbers('content_score',$values[2],'Content',true,null,'forty');
										$inputs_step_1.=$this->get_input_numbers('accomplishment_score',$values[3],'Accomplishment',true,null,'ten');
										
										$content= $this->form_builder('Marking Report','add',$inputs_step_1,'','add');break;

                    case 'performance':
										$sql="SELECT studentID, comment, performance_score FROM performance WHERE performanceID=:value";
                                        $values=$this->get_form_fields(3,$sql,$sub_position,$action,$position);
										
										$inputs_step_1=$this->get_input_text('studentID',$values[0],'Student Name',true,null,'studentSupervisor');										
										$inputs_step_1.=$this->get_input_text_area('comment',$values[1],'General Comment',true);
										$inputs_step_1.=$this->get_input_numbers('performance_score',$values[2],'Performance',true,null,'ten');
										
										$content= $this->form_builder('Student Performance','add',$inputs_step_1,'','add');break;										
									   
					}
					
		}else if($action=='delete'){
		      switch($sub_position){
			        case 'ideas':
					                  $id=$_GET['value'];
					                 
									  $sql="DELETE FROM titleideas WHERE titleID=$id";				  
				                      $sql=$this->connect->createCommand($sql)->query();
									  
									  $content= $this->get_manage_two($position,$sub_position,'view');break;
									  
			  }
        }
		
	return $content;
	}
	
	public function get_manage_three($position,$sub_position,$action){
		$extra=false;
		 if($action=='view'){		
					switch($sub_position){ 
					case 'dash_announcements':
					                  if(isset($_GET['id'])){
	                                     $id=$_GET['id'];
		                                 $sql="SELECT * FROM announcement WHERE announcementID='$id'";
	                                     $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
	                                        $content= "<div class='wrapper'>
                                                          <h1 class='content_header'>Announcement Details</h1>
					
			                                              <div class='clear'></div>
					                                      <div class='step' id='first'>      
		                                                        <p><h1 class='content_header'><u>TITLE:</u> ".$result['title']."<h1/><p/>
						                                        <p><h1 class='content_header'><u>DESCRIPTION:</u> ".$result['content']."<h1/><p/>
						                                        <p><h1 class='content_header'><u>ATTACHED FILE:</u> <a href='41.86.176.19/files/".$result['file']."' style='text-decoration:none; color:orange'>".$result['file']."</a><h1/></p>
		                                                  </div>
					                                   </div>";
											}
		  
	                                  }else{
	                                     $sql="SELECT announcementID, title, content, publishTime FROM announcement ORDER BY publishTime DESC";
		                                 $headers[0]=$this->get_table_header('No.','number');
		                                 $headers[1]=$this->get_table_header('Title','default');
										 $headers[2]=$this->get_table_header('Description','default');
		                                 $headers[3]=$this->get_table_header('Date Published','default');
		                                 $caption='Announcements';
		                                 $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
	                                  }break;
									 
					case 'dash_pastprojects':
					                  if(isset($_GET['id'])){
	                                     $id=$_GET['id'];
		                                 $sql="SELECT * FROM pastprojects WHERE projectID='$id'";
	                                     $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
	                                        $content= "<div class='wrapper'>
                                                         <h1 class='content_header'>Project Details</h1>
					
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>      
		                                                  <p><h1 class='content_header'><u>TITLE:</u> ".$result['title']."<h1/><p/>
							                              <p><h1 class='content_header'><u>STUDENT NAME:</u> ".$result['studentName']."<h1/><p/>
							                              <p><h1 class='content_header'><u>SUPERVISOR:</u> ".$result['supervisorName']."<h1/><p/>
						                                  <p><h1 class='content_header'><u>YEAR:</u> ".$result['year']."<h1/><p/>
							                              <p><h1 class='content_header'><u>REMARKS:</u> ".$result['remarks']."<h1/><p/>
						                                  <p><h1 class='content_header'><u>ATTACHED FILE:</u> <a href='41.86.176.19/files/".$result['content_file']."' style='text-decoration:none; color:orange'>".$result['content_file']."</a><h1/></p>
		                                                 </div>
					                                   </div>";
										 }
		 
	                                  }else{
	                                     $sql="SELECT projectID, title, studentName, supervisorName, year FROM pastprojects ORDER BY year DESC";
		                                 $headers[0]=$this->get_table_header('No.','number');
		                                 $headers[1]=$this->get_table_header('Project Title','default');
		                                 $headers[2]=$this->get_table_header('Student Name','default');
		                                 $headers[3]=$this->get_table_header('Supervisor Name','default');
		                                 $headers[4]=$this->get_table_header('Year','default'); 
		                                 $caption='Previous Projects';
		                                 $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
		                              }break;
					
					
					case 'dash_titleideas':	
					                  $sql="SELECT titleID, title, content, supervisorLastName, publishTime FROM titleideas 
			                                INNER JOIN supervisors ON supervisors.supervisorID = titleideas.supervisorID
				                            ORDER BY publishTime DESC";
		                              $headers[0]=$this->get_table_header('No.','number');
		                              $headers[1]=$this->get_table_header('Project Title','default');
		                              $headers[2]=$this->get_table_header('Description','default');
		                              $headers[3]=$this->get_table_header('Supervisor Name','default');
		                              $headers[4]=$this->get_table_header('Date Published','default');
		                              $caption='Title Ideas';
		                              $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',false,false,false);break;
									  
					case 'dash_titleproposal':				  
									  date_default_timezone_set('Africa/Nairobi');
									  $year = date("Y");                                      
									  
									  $sql="SELECT proposalID, title, studentLastName, supervisorLastName, submissionTime, comment, panelApproval FROM titleproposal
				                            INNER JOIN students ON students.studentID = titleproposal.studentID
				                            INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
				                            WHERE (supervisorApproval='Accepted') AND (panelApproval != 'NULL') AND (DATE_FORMAT(submissionTime, '%Y')='$year')
			                                ORDER BY submissionTime DESC";
		                              $headers[0]=$this->get_table_header('No.','number');
		                              $headers[1]=$this->get_table_header('Project Title','default');
		                              $headers[2]=$this->get_table_header('Student Name','default');
		                              $headers[3]=$this->get_table_header('Supervisor Name','default');
		                              $headers[4]=$this->get_table_header('Submission Time','default');
		                              $headers[5]=$this->get_table_header('Comment','default');
		                              $headers[6]=$this->get_table_header('Status','default');
		                              $caption='Project Titles';
		                              $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',false,false,false);break;				  
                                       					
					case 'proposals':
									  $userId=Yii::app()->user->id; 
									  $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                      $results=$this->connect->createCommand($sql)->query();
                                      foreach ($results as $result){
                                         $studentID=$result['studentID'];
                                      }
									  
									  $title=$time=$approval='';
                                      $sql="SELECT title,submissionTime, panelApproval FROM titleproposal WHERE (studentID='$studentID') AND (panelApproval<>'')";
									  $results=$this->connect->createCommand($sql)->query();
                                      foreach ($results as $fetch){
										   $title=$fetch['title'];
										   $time=$fetch['submissionTime']; 
										   $approval=$fetch['panelApproval']; 
									  }
									  
                                      if (($approval=='Accepted')&&($time!='')){
									     $sql="SELECT proposalID, title, content, supervisorLastName, supervisorComment, supervisorApproval, comment FROM titleproposal 
									           INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
											   WHERE titleproposal.studentID='$studentID'
									           ORDER BY proposalID DESC";
									     $headers[0]=$this->get_table_header('No.','number');
									     $headers[1]=$this->get_table_header('Title','default');
									     $headers[2]=$this->get_table_header('Content','default');
									     $headers[3]=$this->get_table_header('Supervisor Name','default');
									     $headers[4]=$this->get_table_header('Supervisor Comment','default');
									     $headers[5]=$this->get_table_header('Supervisor Approval','default'); 
									     $headers[6]=$this->get_table_header('Panel Comment','default'); 
									     $caption='Title Proposals';
									     $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,false);
									  
									     $content.= $this->get_manage_three($position,$sub_position,'edit');
									  }else{									  
									     $sql="SELECT proposalID, title, content, supervisorLastName, supervisorComment, supervisorApproval, comment FROM titleproposal 
									           INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
											   WHERE titleproposal.studentID='$studentID'
									           ORDER BY proposalID DESC";
									     $headers[0]=$this->get_table_header('No.','number');
									     $headers[1]=$this->get_table_header('Title','default');
									     $headers[2]=$this->get_table_header('Content','default');
									     $headers[3]=$this->get_table_header('Supervisor Name','default');
									     $headers[4]=$this->get_table_header('Supervisor Comment','default');
									     $headers[5]=$this->get_table_header('Supervisor Approval','default'); 
									     $headers[6]=$this->get_table_header('Panel Comment','default'); 
									     $caption='Title Proposals';
									     $content= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'NoAction',false,false,false);
									  
									     $content.= $this->get_manage_three($position,$sub_position,'edit');
									  }break;
									  
					
					case 'progress_reports':   //new added
					                $endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Progress Report Submission'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									   $finalTime=$endTime = $result['endTime']; //no room for late submission
									   $startTime = $result['startTime'];
									}
									
									$semesterStart=$semesterEnd=$timeStart=$timeEnd='';
					            	$sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									    $semesterEnd = $result['endTime'];
									    $semesterStart = $result['startTime'];
									} 
									
									//$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 3 days'));
								    date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							        if (($today >= $startTime) && ($today <= $finalTime)) {
									   $content= "<div class='wrapper'>
                                                      <h1 class='content_header'><u>Important Reminder:</u> Deadline for final report submission is on <u>".date('l jS \of F Y h:i a', strtotime($endTime))."</u></h1>
													  </div>";
                                       $userId=Yii::app()->user->id; 
									   $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                       $results=$this->connect->createCommand($sql)->query();
                                       foreach ($results as $result){
                                         $studentID=$result['studentID'];
                                       }
									   
									   $sql="SELECT title, supervisorApproval, COUNT(*) FROM progress_report WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')";
                                       $results=$this->connect->createCommand($sql)->query();
                                       foreach ($results as $fetch){
									     $count=$fetch['COUNT(*)'];
                                         $approval=$fetch['supervisorApproval'];	
									     $title=$fetch['title'];
                                       } 
                                       if ($approval=='Accepted'){
									       $content= "<div class='wrapper'>
                                                      <h1 class='content_header'>your project report on <u>'".$title."'</u> has been <u>accepted</u> by your supervisor. it is ready for marking</h1>
													  </div>";
													  
										   $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM progress_report 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,false);			  
									   
									   }else if ($approval=='Rejected'){
									       $content.= "<div class='wrapper'>
                                                      <h1 class='content_header'>your project report on <u>'".$title."'</u> has been <u>rejected</u> by your supervisor. please edit and upload an improved project report.</h1>
													  </div>";
													  
										   $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM progress_report 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $headers[5]=$this->get_table_header('Edit','action'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',false,false,false);			  
													
									   }else if ($count==0){
									       $content.= "<div class='wrapper'>
                                                      <h1 class='content_header'>you have <u>not yet</u> submitted your project report. please, <u>submit</u> it down here.</h1>
													  </div>";

									       $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM progress_report 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'NoAction',false,false,false);
										   
									   }else if ($count!=0){
									       $content.= "<div class='wrapper'>
                                                      <h1 class='content_header'>you have <u>already</u> submitted your project report. Pending For Supervisor Approval</h1>
													  </div>";
										   $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM progress_report 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,false);			  
									   }								   
							        }else {
									       $content= "<div class='wrapper'>
                                                      <h1 class='content_header'>Report submission window is currently <u>closed</u>!</h1>
													  </div>"; 
									}break;
					
					case 'project_reports':    
									$endTime=$startTime='';
									$sql="SELECT endTime, startTime FROM  sessions WHERE title='Final Report Submission'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									   $finalTime=$endTime = $result['endTime']; //no room for late submission
									   $startTime = $result['startTime'];
									}
									
									$semesterStart=$semesterEnd=$timeStart=$timeEnd='';
					            	$sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									$results=$this->connect->createCommand($sql)->query();
									foreach ($results as $result){
									    $semesterEnd = $result['endTime'];
									    $semesterStart = $result['startTime'];
									} 
									
									//$finalTime=date('Y-m-d H:i:s', strtotime($endTime . ' + 3 days'));
								    date_default_timezone_set('Africa/Nairobi'); $today = date("Y-m-d H:i:s");
							        if (($today >= $startTime) && ($today <= $finalTime)) {
									   $content= "<div class='wrapper'>
                                                      <h1 class='content_header'><u>Important Reminder:</u> Deadline for final report submission is on <u>".date('l jS \of F Y h:i a', strtotime($endTime))."</u></h1>
													  </div>";
                                       $userId=Yii::app()->user->id; 
									   $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                       $results=$this->connect->createCommand($sql)->query();
                                       foreach ($results as $result){
                                         $studentID=$result['studentID'];
                                       }
									   
									   $sql="SELECT title, supervisorApproval, COUNT(*) FROM projectreport WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')";
                                       $results=$this->connect->createCommand($sql)->query();
                                       foreach ($results as $fetch){
									     $count=$fetch['COUNT(*)'];
                                         $approval=$fetch['supervisorApproval'];	
									     $title=$fetch['title'];
                                       } 
                                       if ($approval=='Accepted'){
									       $content= "<div class='wrapper'>
                                                      <h1 class='content_header'>your project report on <u>'".$title."'</u> has been <u>accepted</u> by your supervisor. it is ready for marking</h1>
													  </div>";
													  
										   $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM projectreport 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,false);			  
									   
									   }else if ($approval=='Rejected'){
									       $content.= "<div class='wrapper'>
                                                      <h1 class='content_header'>your project report on <u>'".$title."'</u> has been <u>rejected</u> by your supervisor. please edit and upload an improved project report.</h1>
													  </div>";
													  
										   $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM projectreport 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $headers[5]=$this->get_table_header('Edit','action'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'Approval',false,false,false);			  
													
									   }else if ($count==0){
									       $content.= "<div class='wrapper'>
                                                      <h1 class='content_header'>you have <u>not yet</u> submitted your project report. please, <u>submit</u> it down here.</h1>
													  </div>";

									       $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM projectreport 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,true,true,$extra,$caption,'NoAction',false,false,false);
										   
									   }else if ($count!=0){
									       $content.= "<div class='wrapper'>
                                                      <h1 class='content_header'>you have <u>already</u> submitted your project report. Pending For Supervisor Approval</h1>
													  </div>";
										   $sql="SELECT reportID, title, content_file, supervisorApproval, submissionTime FROM projectreport 
											     WHERE (studentID='$studentID') AND (submissionTime>'$semesterStart') AND (submissionTime<'$semesterEnd')
									             ORDER BY reportID DESC";
									       $headers[0]=$this->get_table_header('No.','number');
									       $headers[1]=$this->get_table_header('Title','default');
									       $headers[2]=$this->get_table_header('Content','default');
									       $headers[3]=$this->get_table_header('Supervisor Approval','default');
									       $headers[4]=$this->get_table_header('Submission Time','default'); 
									       $caption='Project Report';
									       $content.= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,$extra,$caption,'NoAction',false,false,false);			  
									   }								   
							        }else {
									       $content= "<div class='wrapper'>
                                                      <h1 class='content_header'>Report submission window is currently <u>closed</u>!</h1>
													  </div>"; 
									}break;
									  
					}							               
					
		
		}else if($action=='add') {			  
			      switch($sub_position){
					case 'proposals':      
									   $sql="SELECT title, content, supervisorID  FROM titleproposal WHERE proposalID=:value";
									   $values=$this->get_form_fields(3,$sql,$sub_position,$action,$position);
									   
									   //first input page items
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Title',true,null,'text');
			                           $inputs_step_1.=$this->get_input_text_area('content',$values[1],'Content',true); 
			                           $inputs_step_1.=$this->get_input_text('supervisorID',$values[2],'Supervisor',true,null,'supervisor'); 
									  						
									   $content= $this->form_builder('Project Proposal','add',$inputs_step_1,'','add');break;
					
					case 'progress_reports':	
                                       $sql="SELECT title, content_file FROM progress_report";
                                       $values=$this->get_form_fields(2,$sql,$sub_position,$action,$position);									   
						                   
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Project Title',true,null,'text');
									   $inputs_step_1.=$this->get_input_file('content_file',$values[1],'Attachment File',true);
									   
									   $content= $this->form_builder('Project Report Submission','add',$inputs_step_1,'','add');break;
					
					case 'project_reports':	
                                       $sql="SELECT title, content_file FROM projectreport";
                                       $values=$this->get_form_fields(2,$sql,$sub_position,$action,$position);									   
						                   
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Project Title',true,null,'text');
									   $inputs_step_1.=$this->get_input_file('content_file',$values[1],'Attachment File',true);
									   
									   $content= $this->form_builder('Project Report Submission','add',$inputs_step_1,'','add');break;
					
					}

		}else if($action=='edit') {			  
			      switch($sub_position){
					case 'proposals':
                                       $userId=Yii::app()->user->id; 
									   $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                       $results=$this->connect->createCommand($sql)->query();
                                       foreach ($results as $result){
                                         $studentID=$result['studentID'];
                                       }
									   
									   $title=$time=$approval=$count='';
                                       $sql="SELECT title,submissionTime, panelApproval FROM titleproposal WHERE (studentID='$studentID') AND (submissionTime<>'')";
									   $results=$this->connect->createCommand($sql)->query();
                                       foreach ($results as $fetch){
										   $title=$fetch['title'];
										   $time=$fetch['submissionTime']; 
										   $approval=$fetch['panelApproval']; 
									   }
									   
									   $sql="SELECT title,submissionTime, panelApproval FROM titleproposal WHERE studentID='$studentID' ";
									   $results=$this->connect->createCommand($sql)->query();
									   $rows=count($results);
									   
									   $sql="SELECT title,submissionTime, panelApproval FROM titleproposal WHERE (studentID='$studentID') AND (supervisorApproval='Accepted') ";
									   $results=$this->connect->createCommand($sql)->query();
									   $counts=count($results);
									  
									   if ($rows==0){
									          $content= "<div class='wrapper'>
                                                    <h1 class='content_header'>you have <u>not</u> proposed any project title to supervisors.</h1>
													</div>";
									   
									   }else if (($approval=='Accepted') && ($time!='')){
									          $content= "<div class='wrapper'>
                                                    <h1 class='content_header'>your title, <u>'".$title."'</u> has been <u>accepted</u> by the panel. you can start your project.</h1>
													</div>";
									   
									   }else if ($approval=='Rejected'){
									          $content= "<div class='wrapper'>
                                                    <h1 class='content_header'>your title, <u>'".$title."'</u> has been <u>rejected</u> by the panel. please find another project title</h1>
													</div>";				
									   
									   }else if($time!=''){
										      $content= "<div class='wrapper'>
                                                    <h1 class='content_header'>you have already submitted project title, <u>'".$title."'</u>. it is currently <u>Pending for the panel approval.</u></h1>
													</div>";
									   
									   }else if ($counts!=0){
										      $sql="SELECT title FROM titleproposal";
									          $values=$this->get_form_fields(1,$sql,$sub_position,$action,$position);
									   
									          $inputs_step_1=$this->get_input_text('title',$values[0],'Project Title',true,null,'proposal'); 
									  						
									          $content= $this->form_builder('Submit project proposal','add',$inputs_step_1,'','edit');
											  
									   }else if ($counts==0){
									          $content= "<div class='wrapper'>
                                                    <h1 class='content_header'>your project title(s) have been <u>rejected or not yet approved</u> by supervisors. Please find other supervisors and/or new titles</h1>
													</div>";
									   }break;
					
                     case 'progress_reports':
                                       $sql="SELECT title, content_file FROM progress_report";
                                       $values=$this->get_form_fields(2,$sql,$sub_position,$action,$position);									   
						                   
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Project Title',true,null,'text');
									   $inputs_step_1.=$this->get_input_file('content_file',$values[1],'Attachment File',true);
									   
									   $content= $this->form_builder('Progress Report Submission','edit',$inputs_step_1,'','edit');break;
					 
		             case 'project_reports':	
                                       $sql="SELECT title, content_file FROM projectreport";
                                       $values=$this->get_form_fields(2,$sql,$sub_position,$action,$position);									   
						                   
									   $inputs_step_1=$this->get_input_text('title',$values[0],'Project Title',true,null,'text');
									   $inputs_step_1.=$this->get_input_file('content_file',$values[1],'Attachment File',true);
									   
									   $content= $this->form_builder('Project Report Submission','edit',$inputs_step_1,'','edit');break;
						                   
					
                  
				  }
      
	  }else if($action=='delete'){
		      switch($sub_position){
			        case 'proposals':
					                   $id=$_GET['value'];
					                 
									   $sql="DELETE FROM titleproposal WHERE proposalID=$id";				  
				                       $sql=$this->connect->createCommand($sql)->query();
									   
									   $content= $this->get_manage_three($position,$sub_position,'view');break;
	              }
	  
	  }
	  
	return $content;
	}
	
	public function get_chat($position,$sub_position,$action){
		$extra=false;
		 if($action=='view'){		
					switch($sub_position){
					      case 'supervisors':
						                       $userID=Yii::app()->user->id;
						                       if(isset($_GET['id'])){
	                                              $id=$_GET['id'];
		                                          $sql="SELECT userID FROM supervisors WHERE supervisorID='$id'";
                                                  $results=$this->connect->createCommand($sql)->query();
                                                  foreach ($results as $result){
                                                    $receiverID=$result['userID'];
                                                  }	
	                                                 $content= "<div class='wrapper'>
                                                                   <h1 class='content_header'>Excahnge Ideas</h1>
																   <div class='clear'></div>
					                                            </div>";
													 $content.=	"<div id='chatroom'>
			                                                      <div id='chat'>
				                                                  </div>
				                                                  <div id='forms'>
					                                               <form action='41.86.176.19/index.php/ajax' method='post' id='chatarea'>
						                                             <textarea placeholder='Enter your message a maximum of 100 characters' name='message' cols='30' rows='5' id='msg'></textarea>
							                                         <input type='hidden' id='receiverID' name='receiverID' value='$receiverID' />
							                                         <input type='hidden' id='userID' name='userID' value='$userID' />
																	 <input type='submit' class='btn'  id='button' value='Comment' />
			                                                   	   </form>
				                                                  </div>
                                                                 </div>";		
											      
											   }else{
						                          $sql="SELECT supervisorID, SupervisorLastName, COUNT(msg_no) AS msg_count FROM supervisors
												        INNER JOIN chat_room ON chat_room.source=supervisors.userID
														WHERE receiver='$userID' AND receiver_seen='0'
														GROUP BY supervisorID
														UNION
														SELECT supervisorID, SupervisorLastName, 0 FROM supervisors
												        INNER JOIN chat_room ON chat_room.source=supervisors.userID
														WHERE receiver='$userID' AND receiver_seen='1'
														    AND supervisors.supervisorID NOT IN(
															   SELECT supervisorID FROM supervisors
												               INNER JOIN chat_room ON chat_room.source=supervisors.userID
														       WHERE receiver='$userID' AND receiver_seen='0'
														    )
														GROUP BY supervisorID
														UNION
														SELECT supervisorID, SupervisorLastName, 0 FROM supervisors
														WHERE supervisorID NOT IN(
														       SELECT supervisorID FROM supervisors
												               INNER JOIN chat_room ON chat_room.source=supervisors.userID
														       WHERE receiver='$userID'  
															   )
														GROUP BY supervisorID
														ORDER BY msg_count DESC, SupervisorLastName ASC";
		                                          $headers[0]=$this->get_table_header('No.','number');
		                                          $headers[1]=$this->get_table_header('Supervisor Name','default');
                                                  $headers[2]=$this->get_table_header('New Messages','default');												  
		                                          $caption='Supervisors';
		                                          $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
											   }break;
						  
					      case 'students':
						                       $userID=Yii::app()->user->id;
						                       if(isset($_GET['id'])){
	                                              $id=$_GET['id'];
		                                          $sql="SELECT userID FROM students WHERE studentID='$id'";
                                                  $results=$this->connect->createCommand($sql)->query();
                                                  foreach ($results as $result){
                                                    $receiverID=$result['userID'];
                                                  }	
	                                                 $content= "<div class='wrapper'>
                                                                   <h1 class='content_header'>Excahnge Ideas</h1>
																   <div class='clear'></div>
					                                            </div>";
													 $content.=	"<div id='chatroom'>
			                                                      <div id='chat'>
				                                                  </div>
				                                                  <div id='forms'>
					                                               <form action='41.86.176.19/index.php/ajax' method='post' id='chatarea'>
						                                             <textarea placeholder='Enter your message a maximum of 100 characters' name='message' cols='30' rows='5' id='msg'></textarea>
							                                         <input type='hidden' id='receiverID' name='receiverID' value='$receiverID' />
							                                         <input type='hidden' id='userID' name='userID' value='$userID' />
																	 <input type='submit' class='btn'  id='button' value='Comment' />
			                                                   	   </form>
				                                                  </div>
                                                                 </div>";		
											      
											   }else{
						                          $sql="SELECT students.studentID, studentLastName, SupervisorLastName, titleproposal.title, COUNT(msg_no) AS msg_count FROM students
										                INNER JOIN supervisors ON supervisors.supervisorID=students.supervisorID
														INNER JOIN chat_room ON chat_room.source=students.userID
														INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
										                WHERE students.yearStudy=3 AND receiver='$userID' AND receiver_seen='0' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted'
														GROUP BY students.studentID
														UNION
														SELECT students.studentID, studentLastName, SupervisorLastName, titleproposal.title, 0 FROM students
														INNER JOIN supervisors ON supervisors.supervisorID=students.supervisorID
														INNER JOIN chat_room ON chat_room.source=students.userID
														INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
														WHERE students.yearStudy=3 AND receiver='$userID' AND receiver_seen='1' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted'
														    AND students.studentID NOT IN(
															   SELECT students.studentID FROM students
										                       INNER JOIN supervisors ON supervisors.supervisorID=students.supervisorID
														       INNER JOIN chat_room ON chat_room.source=students.userID
															   INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
										                       WHERE students.yearStudy=3 AND receiver='$userID' AND receiver_seen='0' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted'
														    )
														GROUP BY students.studentID 
														UNION
														SELECT students.studentID, studentLastName, SupervisorLastName, titleproposal.title, 0 FROM students
														INNER JOIN supervisors ON supervisors.supervisorID=students.supervisorID
														INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
														WHERE students.yearStudy=3 AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted' AND students.studentID NOT IN (
														             SELECT students.studentID FROM students
										                             INNER JOIN supervisors ON supervisors.supervisorID=students.supervisorID
														             INNER JOIN chat_room ON chat_room.source=students.userID
																	 INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
										                             WHERE students.yearStudy=3 AND receiver='$userID' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted')
														GROUP BY students.studentID 
														ORDER BY msg_count DESC, studentLastName ASC";
                                                  $headers[0]=$this->get_table_header('No.','number');
		                                          $headers[1]=$this->get_table_header('Student Name','default');													 
		                                          $headers[2]=$this->get_table_header('Supervisor Name','default');													 
		                                          $headers[3]=$this->get_table_header('Title','default');													 
		                                          $headers[4]=$this->get_table_header('New Messages','default');													 
                                                  $caption='Students';
		                                          $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
											   }break;
											   
					      case 'coordinator':
						                       $userID=Yii::app()->user->id;
                                               if(isset($_GET['id'])){
	                                              $id=$_GET['id'];
		                                          $sql="SELECT userID FROM coordinator WHERE coordinatorID='$id'";
                                                  $results=$this->connect->createCommand($sql)->query();
                                                  foreach ($results as $result){
                                                    $receiverID=$result['userID'];
                                                  }	
	                                                 $content= "<div class='wrapper'>
                                                                   <h1 class='content_header'>Excahnge Ideas</h1>
																   <div class='clear'></div>
					                                            </div>";
													 $content.=	"<div id='chatroom'>
			                                                      <div id='chat'>
				                                                  </div>
				                                                  <div id='forms'>
					                                               <form action='41.86.176.19/index.php/ajax' method='post' id='chatarea'>
						                                             <textarea placeholder='Enter your message a maximum of 100 characters' name='message' cols='30' rows='5' id='msg'></textarea>
							                                         <input type='hidden' id='receiverID' name='receiverID' value='$receiverID' />
							                                         <input type='hidden' id='userID' name='userID' value='$userID' />
																	 <input type='submit' class='btn'  id='button' value='Comment' />
			                                                   	   </form>
				                                                  </div>
                                                                 </div>";		
											      
											   }else{
											      $sql="SELECT coordinatorID, coordinatorLastName, COUNT(msg_no) AS msg_count FROM coordinator 
												        INNER JOIN chat_room ON chat_room.source=coordinator.userID
												        WHERE receiver='$userID' AND receiver_seen='0'
														GROUP BY coordinatorID
														UNION
														SELECT coordinatorID, coordinatorLastName, 0 FROM coordinator 
												        INNER JOIN chat_room ON chat_room.source=coordinator.userID
												        WHERE receiver='$userID' AND receiver_seen='1' 
														    AND coordinator.coordinatorID NOT IN(
															   SELECT coordinatorID FROM coordinator 
												               INNER JOIN chat_room ON chat_room.source=coordinator.userID
												               WHERE receiver='$userID' AND receiver_seen='0'
														    )
														GROUP BY coordinatorID
														UNION
														SELECT coordinatorID, coordinatorLastName, 0 FROM coordinator
														WHERE coordinatorID NOT IN(
														       SELECT coordinatorID FROM coordinator 
												               INNER JOIN chat_room ON chat_room.source=coordinator.userID
												               WHERE receiver='$userID' 
															   )
														GROUP BY  coordinatorID
														ORDER BY msg_count DESC, coordinatorLastName ASC";
		                                          $headers[0]=$this->get_table_header('No.','number');
		                                          $headers[1]=$this->get_table_header('Coordinator Name','default'); 
		                                          $headers[2]=$this->get_table_header('New Messages','default'); 
		                                          $caption='Coordinators';
		                                          $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
											   }break;
											   
					      case 'supervisor_students':
						                       $userID=Yii::app()->user->id;
											   if(isset($_GET['id'])){
	                                              $id=$_GET['id'];
		                                          $sql="SELECT userID FROM students WHERE studentID='$id'";
                                                  $results=$this->connect->createCommand($sql)->query();
                                                  foreach ($results as $result){
                                                    $receiverID=$result['userID'];
                                                  }	
	                                                 $content= "<div class='wrapper'>
                                                                   <h1 class='content_header'>Excahnge Ideas</h1>
																   <div class='clear'></div>
					                                            </div>";
													 $content.=	"<div id='chatroom'>
			                                                      <div id='chat'>
				                                                  </div>
				                                                  <div id='forms'>
					                                               <form action='41.86.176.19/index.php/ajax' method='post' id='chatarea'>
						                                             <textarea placeholder='Enter your message a maximum of 100 characters' name='message' cols='30' rows='5' id='msg'></textarea>
							                                         <input type='hidden' id='receiverID' name='receiverID' value='$receiverID' />
							                                         <input type='hidden' id='userID' name='userID' value='$userID' />
																	 <input type='submit' class='btn'  id='button' value='Comment' />
			                                                   	   </form>
				                                                  </div>
                                                                 </div>";		
											      
											   }else{
						                          $userId=Yii::app()->user->id; 
									              $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                                                  $results=$this->connect->createCommand($sql)->query();
                                                  foreach ($results as $result){
                                                    $supervisorID=$result['supervisorID'];
                                                  }
											   
											      $sql="SELECT students.studentID, studentLastName, titleproposal.title, COUNT(msg_no) AS msg_count FROM students
                     							        INNER JOIN chat_room ON chat_room.source=students.userID
                     							        INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
														WHERE students.supervisorID = '$supervisorID' AND chat_room.receiver='$userID' AND chat_room.receiver_seen='0' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted'
														GROUP BY students.studentID
														UNION
														SELECT students.studentID, studentLastName, titleproposal.title, 0 FROM students
                     							        INNER JOIN chat_room ON chat_room.source=students.userID
														INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
														WHERE students.supervisorID = '$supervisorID' AND chat_room.receiver='$userID' AND chat_room.receiver_seen='1' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted'
														    AND students.studentID NOT IN(
															   SELECT students.studentID FROM students
                     							               INNER JOIN chat_room ON chat_room.source=students.userID
															   INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
														       WHERE students.supervisorID = '$supervisorID' AND chat_room.receiver='$userID' AND chat_room.receiver_seen='0' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted'
														    )
														GROUP BY students.studentID
														UNION
														SELECT students.studentID, studentLastName, titleproposal.title, 0 FROM students
														INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
														WHERE students.supervisorID = '$supervisorID' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted' AND students.studentID NOT IN (
														       SELECT students.studentID FROM students
                     							               INNER JOIN chat_room ON chat_room.source=students.userID
															   INNER JOIN titleproposal ON titleproposal.studentID=students.studentID
														       WHERE students.supervisorID = '$supervisorID' AND chat_room.receiver='$userID' AND titleproposal.supervisorApproval='Accepted' AND titleproposal.panelApproval='Accepted'
															   )
														GROUP BY students.studentID
													    ORDER BY msg_count DESC, studentLastName ASC";
		                                          $headers[0]=$this->get_table_header('No.','number');
		                                          $headers[1]=$this->get_table_header('Student Name','default');
		                                          $headers[2]=$this->get_table_header('Title','default');
                                                  $headers[3]=$this->get_table_header('New Messages','default');												  
		                                          $caption='Students';
		                                          $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
											   }break;
						  
					      case 'student_supervisor':
						                      $userID=Yii::app()->user->id;
											  if(isset($_GET['id'])){
	                                              $id=$_GET['id'];
		                                          $sql="SELECT userID FROM supervisors WHERE supervisorID='$id'";
                                                  $results=$this->connect->createCommand($sql)->query();
                                                  foreach ($results as $result){
                                                    $receiverID=$result['userID'];
                                                  }	
											        $content= "<div class='wrapper'>
                                                                   <h1 class='content_header'>Excahnge Ideas</h1>
																   <div class='clear'></div>
					                                            </div>";
													 $content.=	"<div id='chatroom'>
			                                                      <div id='chat'>
				                                                  </div>
				                                                  <div id='forms'>
					                                               <form action='41.86.176.19/index.php/ajax' method='post' id='chatarea'>
						                                             <textarea placeholder='Enter your message a maximum of 100 characters' name='message' cols='30' rows='5' id='msg'></textarea>
							                                         <input type='hidden' id='receiverID' name='receiverID' value='$receiverID' />
							                                         <input type='hidden' id='userID' name='userID' value='$userID' />
																	 <input type='submit' class='btn'  id='button' value='Comment' />
			                                                   	   </form>
				                                                  </div>
                                                                 </div>";		
											      
											   }else{
											      $userId=Yii::app()->user->id; 
									              $sql="SELECT supervisors.supervisorID, SupervisorLastName, COUNT(msg_no) AS msg_count FROM supervisors 
											            INNER JOIN students ON supervisors.supervisorID=students.supervisorID
														INNER JOIN chat_room ON chat_room.source=supervisors.userID
													    WHERE students.userID='$userId' AND receiver='$userID' AND receiver_seen='0'
														GROUP BY supervisors.supervisorID
														UNION
														SELECT supervisors.supervisorID, SupervisorLastName, 0 FROM supervisors 
											            INNER JOIN students ON supervisors.supervisorID=students.supervisorID
														INNER JOIN chat_room ON chat_room.source=supervisors.userID
													    WHERE students.userID='$userId' AND receiver='$userID' AND receiver_seen='1'
														    AND supervisors.supervisorID NOT IN(
															   SELECT supervisors.supervisorID FROM supervisors 
											                   INNER JOIN students ON supervisors.supervisorID=students.supervisorID
														       INNER JOIN chat_room ON chat_room.source=supervisors.userID
													           WHERE students.userID='$userId' AND receiver='$userID' AND receiver_seen='0'
														    )
														GROUP BY supervisors.supervisorID
														UNION
														SELECT supervisors.supervisorID, SupervisorLastName, 0 FROM supervisors 
											            INNER JOIN students ON supervisors.supervisorID=students.supervisorID
													    WHERE students.userID='$userId' AND supervisors.supervisorID NOT IN (
														       SELECT supervisors.supervisorID FROM supervisors 
											                   INNER JOIN students ON supervisors.supervisorID=students.supervisorID
														       INNER JOIN chat_room ON chat_room.source=supervisors.userID
													           WHERE students.userID='$userId' AND receiver='$userID'
															   )
														GROUP BY supervisors.supervisorID
													    ORDER BY msg_count DESC, SupervisorLastName ASC";
                                                  $headers[0]=$this->get_table_header('No.','number');
		                                          $headers[1]=$this->get_table_header('Supervisor Name','default'); 
		                                          $headers[2]=$this->get_table_header('New Messages','default'); 
		                                          $caption='Supervisor';       
						                          $content= $this->get_table_view($position,$sub_position,$sql,$headers,false,true,false,$caption,'NoAction',true,true,false);
											   }break;
											   
					   }
	  
	  }
	 return $content; 
	}  
	
	

	//dealing with table views
	/******
	
	******/
	
	public function get_actions($index,$action,$position,$sub_position){
	$baseUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('pms.assets'));
	  switch ($action){
	    case 'delete':$action="<a href='?menu=$position&view=$sub_position&action=delete&value=$index'><img src='".$baseUrl."/images/icons/delete.png' class='delete'  title='Click to delete entry'/></a>";break;
		case 'edit':$action="<a href='?menu=$position&view=$sub_position&action=edit&value=$index'><img src='".$baseUrl."/images/icons/edit.png' class='edit'  title='Click to edit details'/></a>";break;
		case 'info':$action="<a href='?menu=$position&view=$sub_position&action=info&value=$index'><img src='".$baseUrl."/images/icons/info.png' class='edit'  title='Click to view details'/></a>";break;	
	  }
	return $action;
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

	
	public function get_table_attendance($position,$sub_position,$sql,$headers,$hasbutton,$ismodern,$extra,$caption,$name,$link=false){
	    
		$rowCount=count($headers);
		$rowCount=$rowCount-1;
		//$results=$this->get_query_result($sql,true);
		$headers=$this->resolve_headers($headers);
		if($hasbutton){
			$button="<div class='action_bar'>
					  <a href='?menu=$position&add=$sub_position' class='btn add'>Add New</a>
			         </div>";
		}else $button='';
		
		if($ismodern){
			  $id='modern_table';
		}else $id='default_table';
		
	    $content="<div class='wrapper'>
			  <h1 class='content_header'>$caption</h1><div class='clear'></div>
				$button
			   <table id='$id'>
				<thead>
				   <tr>$headers</tr>
			   </thead>
			   <tbody>";
			
            if ($name=='Action' || $name=='Approval'){			
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount;$i++){
				  if ($link==true){
				    $content.="<td><a href='?id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
				$edit=$this->get_actions($new_result[0],'edit',$position,$sub_position);
				$delete=$this->get_actions($new_result[0],'delete',$position,$sub_position);
				
				switch ($name){
				    case 'Action':    $content.="<td class='action'>$delete$edit</td></tr>";break;
					case 'Approval':  $content.="<td class='action'>$edit</td></tr>";break;
				}
				
			 
			 }
			
			}else if($name=='NoAction'){
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount+1;$i++){
				     if ($link==true){
				    $content.="<td><a href='?menu=manage&view=attendances&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
			  }
			}
			
			 $content.=" 
			   
			   </tbody>
			   
			   
			   </table>
		   </div>";
	   return $content;
	}
	
	
	public function get_table_marking($position,$sub_position,$sql,$headers,$hasbutton,$ismodern,$extra,$caption,$name,$link=false){
	    
		$rowCount=count($headers);
		$rowCount=$rowCount-1;
		//$results=$this->get_query_result($sql,true);
		$headers=$this->resolve_headers($headers);
		if($hasbutton){
			$button="<div class='action_bar'>
					  <a href='?menu=$position&add=$sub_position' class='btn add'>Add New</a>
			         </div>";
		}else $button='';
		
		if($ismodern){
			  $id='modern_table';
		}else $id='default_table';
		
	    $content="<div class='wrapper'>
			  <h1 class='content_header'>$caption</h1><div class='clear'></div>
				$button
			   <table id='$id'>
				<thead>
				   <tr>$headers</tr>
			   </thead>
			   <tbody>";
			
            if ($name=='Action' || $name=='Approval'){			
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount;$i++){
				  if ($link==true){
				    $content.="<td><a href='?menu=manage&view=marking&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
				$edit=$this->get_actions($new_result[0],'edit',$position,$sub_position);
				$delete=$this->get_actions($new_result[0],'delete',$position,$sub_position);
				
				switch ($name){
				    case 'Action':    $content.="<td class='action'>$delete$edit</td></tr>";break;
					case 'Approval':  $content.="<td class='action'>$edit</td></tr>";break;
				}
				
			 
			 }
			
			}else if($name=='NoAction'){
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount+1;$i++){
				     if ($link==true){
				    $content.="<td><a href='?menu=manage&view=marking&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
			  }
			}
			
			 $content.=" 
			   
			   </tbody>
			   
			   
			   </table>
		   </div>";
	   return $content;
	}
	
	public function get_table_reports ($position,$sub_position,$sql,$headers,$hasbutton,$ismodern,$extra,$caption,$name,$link=false){
	    
		$rowCount=count($headers);
		$rowCount=$rowCount-1;
		//$results=$this->get_query_result($sql,true);
		$headers=$this->resolve_headers($headers);
		if($hasbutton){
			$button="<div class='action_bar'>
					  <a href='?menu=$position&add=$sub_position' class='btn add'>Add New</a>
			         </div>";
		}else $button='';
		
		if($ismodern){
			  $id='modern_table';
		}else $id='default_table';
		
	    $content="<div class='wrapper'>
			  <h1 class='content_header'>$caption</h1><div class='clear'></div>
				$button
			   <table id='$id'>
				<thead>
				   <tr>$headers</tr>
			   </thead>
			   <tbody>";
			
            if ($name=='Action' || $name=='Approval'){			
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount;$i++){
				  if ($link==true){
				    $content.="<td><a href='?menu=manage&view=reportsSupervisor&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
				$edit=$this->get_actions($new_result[0],'edit',$position,$sub_position);
				$delete=$this->get_actions($new_result[0],'delete',$position,$sub_position);
				
				switch ($name){
				    case 'Action':    $content.="<td class='action'>$delete$edit</td></tr>";break;
					case 'Approval':  $content.="<td class='action'>$edit</td></tr>";break;
				}
				
			 
			 }
			
			}else if($name=='NoAction'){
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount+1;$i++){
				     if ($link==true){
				    $content.="<td><a href='?menu=manage&view=reportsSupervisor&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
			  }
			}
			
			 $content.=" 
			   
			   </tbody>
			   
			   
			   </table>
		   </div>";
	   return $content;
	}
	
	public function get_table_progressReports ($position,$sub_position,$sql,$headers,$hasbutton,$ismodern,$extra,$caption,$name,$link=false){
	    
		$rowCount=count($headers);
		$rowCount=$rowCount-1;
		//$results=$this->get_query_result($sql,true);
		$headers=$this->resolve_headers($headers);
		if($hasbutton){
			$button="<div class='action_bar'>
					  <a href='?menu=$position&add=$sub_position' class='btn add'>Add New</a>
			         </div>";
		}else $button='';
		
		if($ismodern){
			  $id='modern_table';
		}else $id='default_table';
		
	    $content="<div class='wrapper'>
			  <h1 class='content_header'>$caption</h1><div class='clear'></div>
				$button
			   <table id='$id'>
				<thead>
				   <tr>$headers</tr>
			   </thead>
			   <tbody>";
			
            if ($name=='Action' || $name=='Approval'){			
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount;$i++){
				  if ($link==true){
				    $content.="<td><a href='?menu=manage&view=progressSupervisor&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
				$edit=$this->get_actions($new_result[0],'edit',$position,$sub_position);
				$delete=$this->get_actions($new_result[0],'delete',$position,$sub_position);
				
				switch ($name){
				    case 'Action':    $content.="<td class='action'>$delete$edit</td></tr>";break;
					case 'Approval':  $content.="<td class='action'>$edit</td></tr>";break;
				}
				
			 
			 }
			
			}else if($name=='NoAction'){
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount+1;$i++){
				     if ($link==true){
				    $content.="<td><a href='?menu=manage&view=progressSupervisor&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
					}else {
					$content.="<td>$new_result[$i]</td>";
					}
				}
			  }
			}
			
			 $content.=" 
			   
			   </tbody>
			   
			   
			   </table>
		   </div>";
	   return $content;
	}
	
	
    //method that displays the actual table
	public function get_table_view($position,$sub_position,$sql,$headers,$hasbutton,$ismodern,$extra,$caption,$name,$link=false,$newLink=false,$print){  
		$rowCount=count($headers);
		$rowCount=$rowCount-1;
		$headers=$this->resolve_headers($headers);
		
		
		if($print)
		{
			$print_link="<a href='41.86.176.19/report_generator/report.php?report=$sub_position' class='btn add'>Download</a>";
		}else{
			$print_link='';
		}
		
		
		
		if($hasbutton){
			$button="<div class='action_bar'>
					  <a href='?menu=$position&add=$sub_position' class='btn add'>Add New</a>
					  $print_link
			         </div>";
		}else $button=$print_link;
		
		
		if($ismodern){
			  $id='modern_table';
		}else $id='default_table';
		
	    $content="<div class='wrapper'>
			  <h1 class='content_header'>$caption</h1><div class='clear'></div>
				$button
			   <table id='$id'>
				<thead>
				   <tr>$headers</tr>
			   </thead>
			   <tbody>";
			
            if ($name=='Action' || $name=='Approval'){			
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data); //foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount;$i++){
				 if($newLink==false){
				  if ($link==true){
				    $content.="<td><a href='?id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 }else{
				  if ($link==true){
				    $content.="<td><a href='?menu=$position&view=$sub_position&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 } 
				}
				$edit=$this->get_actions($new_result[0],'edit',$position,$sub_position); 
				$delete=$this->get_actions($new_result[0],'delete',$position,$sub_position);
				
				switch ($name){
				    case 'Action':    $content.="<td class='action'>$delete$edit</td></tr>";break;
					case 'Approval':  $content.="<td class='action'>$edit</td></tr>";break;
				}
			  }
			
			}else if($name=='NoAction'){
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount+1;$i++){
				 if($newLink==false){
				  if ($link==true){
				    $content.="<td><a href='?id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 }else{
				  if ($link==true){
				    $content.="<td><a href='?menu=$position&view=$sub_position&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 }
				}
			  }
			}
			
			 $content.=" 
			   
			   </tbody>
			   
			   
			   </table>
		   </div>";
	   return $content;
	}
	
	
	public function get_table_view_attendances($position,$sub_position,$sql,$headers,$hasbutton,$ismodern,$extra,$caption,$name,$link=false,$newLink=false,$print,$id){  
		$rowCount=count($headers);
		$rowCount=$rowCount-1;
		$headers=$this->resolve_headers($headers);
		
		
		if($print)
		{
			$print_link="<a href='41.86.176.19/report_generator/report.php?report=$sub_position&id=$id' class='btn add'>Download</a>";
		}else{
			$print_link='';
		}
		
		
		
		if($hasbutton){
			$button="<div class='action_bar'>
					  <a href='?menu=$position&add=$sub_position' class='btn add'>Add New</a>
					  $print_link
			         </div>";
		}else $button=$print_link;
		
		
		if($ismodern){
			  $id='modern_table';
		}else $id='default_table';
		
	    $content="<div class='wrapper'>
			  <h1 class='content_header'>$caption</h1><div class='clear'></div>
				$button
			   <table id='$id'>
				<thead>
				   <tr>$headers</tr>
			   </thead>
			   <tbody>";
			
            if ($name=='Action' || $name=='Approval'){			
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data); //foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount;$i++){
				 if($newLink==false){
				  if ($link==true){
				    $content.="<td><a href='?id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 }else{
				  if ($link==true){
				    $content.="<td><a href='?menu=$position&view=$sub_position&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 } 
				}
				$edit=$this->get_actions($new_result[0],'edit',$position,$sub_position); 
				$delete=$this->get_actions($new_result[0],'delete',$position,$sub_position);
				
				switch ($name){
				    case 'Action':    $content.="<td class='action'>$delete$edit</td></tr>";break;
					case 'Approval':  $content.="<td class='action'>$edit</td></tr>";break;
				}
			  }
			
			}else if($name=='NoAction'){
			  $count=0;
			  $results=$this->connect->createCommand($sql)->query();
              foreach ($results as $result){
              $data=(array) $result;
              $new_result=array_values($data);//foreach($results as $result){
			    $count++;
				$content.="<tr><td>$count</td>";
				for($i=1;$i<$rowCount+1;$i++){
				 if($newLink==false){
				  if ($link==true){
				    $content.="<td><a href='?id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 }else{
				  if ($link==true){
				    $content.="<td><a href='?menu=$position&view=$sub_position&id=$new_result[0]' style='text-decoration:none; color:#555'>$new_result[$i]</a></td>";
				  }else{
					$content.="<td>$new_result[$i]</td>";
				  }
				 }
				}
			  }
			}
			
			 $content.=" 
			   
			   </tbody>
			   
			   
			   </table>
		   </div>";
	   return $content;
	}
	
	
	
	/********DEALING WITH FORMS*******/
	public function create_empty_array($size){
		for($i=0;$i<$size;$i++)
		{
			$result[$i]='';
		}
		return $result;
	}
	public function get_form_fields($size,$sql,$sub_position,$action,$position){ 
		$_SESSION['form']=$sub_position; //set_the form type this will determine action to take when submit is done by user store it in a session and we send it when user clicks submit
		$_SESSION['action']=$action;
		$_SESSION['position']=$position;
		if(isset($_SESSION['form_data'])){
				  $parameters=$_SESSION['form_data'];
				  unset($_SESSION['form_data']);
				  $i=0;
				  foreach($parameters as $name => $value){
					$result[$i]=$value;
					$i++;
				  }
		   
		}else{		
				if($action=='edit'){
					$results=$this->get_query_result_parameter($sql,@$_GET['value'],false);
					foreach ($results as $raw_result){
                       $data=(array) $raw_result;
                       $result=  array_values($data);
					}
					$_SESSION['update']=@$_GET['value']; //store the key we are going to identify the record to update
				}else{
					  $result=$this->create_empty_array($size);
				}
			
		}
	    return $result;
	
	}
	
	public function get_select_list($index,$sql,$name,$label,$ismultiple,$isrequired,$id){
		    //0. Check if the select list is required
			 if($isrequired)
		    {
				$display='<span class="required">*</span>';
				$validation="class='required'";
		    }else{ 
				$display='';
				$validation='';
		   }
			
			
			
			//1. First check if there is a parameter required for the select list query....
			if(isset($_GET['value'])){
			  $results=$this->get_query_result_parameter($sql,true,true);
			}else{
			  $results=$this->get_query_result($sql,true);
			}
			
			
			//2. Check if the select list allows multiple selections or just a normal select list
			if($ismultiple){
				$plugin='multiple="multiple" enabled="enabled"';
				$blank='';
			}else {
				$plugin='';
				$blank='<option value="" ></option>';
			}
			
			
			//3. Check if the select list is required or can be null
			if($isrequired){
				$class='class="required"';
			}else $class='';
			
			$list="<p><label>$label$display</label><select name='$name' class='required' id='$id' $plugin $validation>$blank";
			
			
			$class='';
			
			//4. The loop that generates the select list
			foreach ($results as $result){
				if($ismultiple){
						  //comparison for array type....
								if(($index!=null) && in_array($result[0], $index)){
									$class='selected';
								}else $class='';
				}else{
						   //comparison for single value...
							   if(($index!=null) && ($index==$result[0])){
								   $class='selected';
							   }else $class='';	
				}
				
				$list.="<option value='$result[0]' $class>$result[1]</option>";
			
			}		
			$list.='</select></p>';
		  return $list;	
	}
	
	public function get_selected_in_list($sql){
	    $selected_list=null; //initialize the select list
	
		if(isset($_GET['value'])){ // if the get value is there then get the selected indexes in list
			 $i=0; //counter
			 $results=$this->get_query_result_parameter($sql,$_GET['value'],true);
			foreach($results as $result){
				$selected_list[$i]=$result[0];
				$i++;
			}
		}
	 return $selected_list;	
	}
	
	public function get_input_file($name,$value,$label,$isrequired){
		  if($isrequired)
		  {
			$display='<span class="required">*</span>';
			$validation="required";
		  }else{ 
			$display='';
			$validation='default';
		  }
		  
		
		  $input="<p>
		              <label>$label$display</label>
					  <input type='file' name='$name'  value='$value' $validation class='$validation'>
				  </p>";
	
	return $input;
	}
	
	public function get_input_text($name,$value,$label,$isrequired,$extra,$particular){
		  if($isrequired)
		  {
			$display='<span class="required">*</span>';
			$validation="required";
		  }else{ 
			$display='';
			$validation='default';
		  }
		  
		  if($extra!=null){
			$validation.=' '.$extra;
		  }
		  
		  
		  switch ($particular){
		    case 'text':
		                $input="<p>
		                        <label>$label$display</label>
					            <input type='text' name='$name'  value='$value' $validation class='$validation'>
				                </p>"; break;
			/*case 'session':
                        $input="<p>
		                        <label>$label$display</label>
					            <select name='$name'  value='$value' $validation class='$validation'>
                                <option></option>
					            <option>Title Proposal Submission</option>
								<option>Project Progression</option>
								<option>Progress Report Submission</option>
								<option>Final Report Submission</option>
								<option>Oral Presentation</option>
					            <option>Report Marking</option></select>
				                </p>"; break;*/			
				  
			case 'supervisor':
                        $input="<p>
		                        <label>$label$display</label>
					            <select name='$name'  value='$value' $validation class='$validation'>";
				                  $session='';	  
				                  $input.="<option>".$session."</option>";	     
		         
				                  $sql= "SELECT DISTINCT supervisorLastName FROM supervisors ORDER BY supervisorLastName ASC";
				                  $results=$this->connect->createCommand($sql)->query();
		                          foreach($results as $result){
                                      $input.="<option>".$result['supervisorLastName']."</option>"; 
		                          } 
			            $input.="</select>
				                 </p>"; break;

			case 'approval':
                        $input="<p>
		                       <label>$label$display</label>
					           <select name='$name'  value='$value' $validation class='$validation'>
					           <option></option>
					           <option>Accepted</option>
					           <option>Rejected</option>
				               </select>
				               </p>"; break;   
			
			case 'proposal':
			            $input="<p>
		                        <label>$label$display</label>
					            <select name='$name'  value='$value' $validation class='$validation'>";
				                  $session='';	  
				                  $input.="<option>".$session."</option>";	

                                  $userId=Yii::app()->user->id; 
								  $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                  $results=$this->connect->createCommand($sql)->query();
                                  foreach ($results as $result){
                                        $studentID=$result['studentID'];
                                  }								  
		         
				                  $sql= "SELECT title FROM  titleproposal WHERE (supervisorApproval='Accepted') AND (studentID='$studentID')";
				                  $results=$this->connect->createCommand($sql)->query();
		                          foreach($results as $result){
                                      $input.="<option>".$result['title']."</option>"; 
		                          } 
			            $input.="</select>
				                 </p>"; break;
			
			case 'student':
			            $input="<p>
		                        <label>$label$display</label>
					            <select name='$name'  value='$value' $validation class='$validation'>";
				                  $session='';	  
				                  $input.="<option>".$session."</option>";	     
		         
				                  $sql= "SELECT DISTINCT studentLastName FROM students WHERE yearStudy=3 ORDER BY studentLastName ASC";
				                  $results=$this->connect->createCommand($sql)->query();
		                          foreach($results as $result){
                                      $input.="<option>".$result['studentLastName']."</option>"; 
		                          } 
			            $input.="</select>
				                 </p>"; break;
			
            case 'studentMarking':
			            $userId=Yii::app()->user->id; 
						$sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                        $results=$this->connect->createCommand($sql)->query();
                        foreach ($results as $result){
                            $supervisorID=$result['supervisorID'];
                        }
						
						$input="<p>
		                        <label>$label$display</label>
					            <select name='$name'  value='$value' $validation class='$validation'>";
				                  $session='';	  
				                  $input.="<option>".$session."</option>";	     
		         
				                  $sql="SELECT studentLastName FROM projectreport
										        INNER JOIN students ON students.studentID=projectreport.studentID
										        WHERE (projectreport.supervisorID='$supervisorID') OR (projectreport.independentExaminerID='$supervisorID')
												ORDER BY studentLastName ASC";
				                  $results=$this->connect->createCommand($sql)->query();
		                          foreach($results as $result){
                                      $input.="<option>".$result['studentLastName']."</option>"; 
		                          } 
			            $input.="</select>
				                 </p>"; break;
			
			case 'studentSupervisor':
			            $userId=Yii::app()->user->id; 
						$sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
                        $results=$this->connect->createCommand($sql)->query();
                        foreach ($results as $result){
                            $supervisorID=$result['supervisorID'];
                        }
						
						$input="<p>
		                        <label>$label$display</label>
					            <select name='$name'  value='$value' $validation class='$validation'>";
				                  $session='';	  
				                  $input.="<option>".$session."</option>";	     
		         
				                  $sql= "SELECT DISTINCT studentLastName FROM students WHERE (yearStudy=3) AND (supervisorID='$supervisorID') ORDER BY studentLastName ASC";
				                  $results=$this->connect->createCommand($sql)->query();
		                          foreach($results as $result){
                                      $input.="<option>".$result['studentLastName']."</option>"; 
		                          } 
			            $input.="</select>
				                 </p>"; break;					 
					   
	       }
		   
	return $input;
	
	}
	
	public function get_input_numbers($name,$value,$label,$isrequired,$extra,$particular){
		  if($isrequired)
		  {
			$display='<span class="required">*</span>';
			$validation="required";
		  }else{ 
			$display='';
			$validation='default';
		  }
		  
		  if($extra!=null){
			$validation.=' '.$extra;
		  }
		  
		  switch ($particular){
		      case 'years':
		                    $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $year='';	  
				                      $input.="<option>".$year."</option>";	     
		                              for ($year=date('Y'); $year>2000; $year--){ 
                                         $input.="<option>".$year."</option>"; 
		                              } break;
									  
			  case 'weeks':		
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $week='';	  
				                      $input.="<option>".$week."</option>";	     
		                              for ($week=1; $week<16; $week++){ 
                                         $input.="<option>".$week."</option>"; 
		                              } break;

			  case 'marks':
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $mark='';	  
				                      $input.="<option>".$mark."</option>";	     
		                              for ($mark=0; $mark<101; $mark++){ 
                                         $input.="<option>".$mark."</option>"; 
		                              } break;
									  
			  case 'five':
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $mark='';	  
				                      $input.="<option>".$mark."</option>";	     
		                              for ($mark=0; $mark<6; $mark++){ 
                                         $input.="<option>".$mark."</option>"; 
		                              } break;
									  
			  case 'six':
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $mark='';	  
				                      $input.="<option>".$mark."</option>";	     
		                              for ($mark=0; $mark<7; $mark++){ 
                                         $input.="<option>".$mark."</option>"; 
		                              } break;		

			  case 'four':
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $mark='';	  
				                      $input.="<option>".$mark."</option>";	     
		                              for ($mark=0; $mark<5; $mark++){ 
                                         $input.="<option>".$mark."</option>"; 
		                              } break;	
			  case 'three':
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $mark='';	  
				                      $input.="<option>".$mark."</option>";	     
		                              for ($mark=0; $mark<4; $mark++){ 
                                         $input.="<option>".$mark."</option>"; 
		                              } break;
									  
			  case 'ten':
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $mark='';	  
				                      $input.="<option>".$mark."</option>";	     
		                              for ($mark=0; $mark<11; $mark++){ 
                                         $input.="<option>".$mark."</option>"; 
		                              } break;	

			  case 'forty':
                            $input="<p>
		                            <label>$label$display</label>
					                <select name='$name'  value='$value' $validation class='$validation'>";
				                      $mark='';	  
				                      $input.="<option>".$mark."</option>";	     
		                              for ($mark=0; $mark<41; $mark++){ 
                                         $input.="<option>".$mark."</option>"; 
		                              } break;						  
						  
          }
					  
					
			     $input.="</select>
				          </p>";
	
	return $input;
	
	}
	
	
	public function get_input_date($name,$value,$label,$isrequired,$extra){
		  if($isrequired)
		  {
			$display='<span class="required">*</span>';
			$validation="required";
		  }else{ 
			$display='';
			$validation='default';
		  }
		  
		  if($extra!=null){
			$validation.=' '.$extra;
		  }
		  
		  
		  
		  if ($name=='startTime'){
		    $input="<p>
		              <label>$label$display</label>
					  <input type='text' name='$name' class='pp' value='$value' $validation class='$validation'>
				    </p>";
					
          }else if ($name=='endTime'){
		    $input="<p>
		              <label>$label$display</label>
					  <input type='text' name='$name' class='pp' value='$value' $validation class='$validation'>
				    </p>";
				  
          }
		  
	  return $input;
	
	}
	
	
	public function get_input_text_area($name,$value,$label,$isrequired){
		  if($isrequired)
		  {
			$display='<span class="required">*</span>';
			$validation="class='required'";
		  }else{ 
			$display='';
			$validation='';
		  }
          
		  $input="<p>
		          <label>$label$display</label>
				  <textarea name='$name' $validation>$value</textarea>
				  </p>";
	
	  return $input;
	}
	
	public function formAdd(){
	
	    if(!empty($_POST)){
            $sub_position=$_POST['sub_position'];
                switch($sub_position){
                    case 'announcements':
                                         $title=$_POST['title'];
                                         $content=$_POST['content'];
										 $file_name='';
                                         $userId=Yii::app()->user->id; 
										
										if(isset($_FILES)){
                                           $file_name = $_FILES['file']['name'];
	                                       $file_tmp  = $_FILES['file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$file_name;
										   $allowed_extensions = array('pdf','xls','xlsx','zip');
										   $extension = explode(".", $_FILES['file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u>, <u>.xls</u>, <u>.xlsx</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }    
										 
										 //insert/update data into database
                                         $sql="INSERT INTO announcement SET title='".addslashes($title)."', content='".addslashes($content)."', file='".addslashes($file_name)."', coordinatorID='$coordinatorID'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=announcements');
										}break;
	                
					case 'sessions':    /*
                                         $title=$_POST['title'];
                                         $startTime=date('Y-m-d H:m',strtotime($_POST['startTime']));
                                         $endTime=date('Y-m-d H:m',strtotime($_POST['endTime'])); 
                                       
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
										 
										 //insert data into database
                                         $sql="INSERT INTO sessions SET title='".addslashes($title)."', startTime='$startTime', endTime='$endTime', coordinatorID='$coordinatorID'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=sessions');break;*/
										 
					case 'previous_projects':
                                         $title=$_POST['title'];
										 $studentName=$_POST['studentName'];
                                         $supervisorName=$_POST['supervisorName'];
										 $year=$_POST['year'];
										 $file_name='';
									
                                         if(isset($_FILES)){
                                           $file_name = $_FILES['content_file']['name'];
	                                       $file_tmp  = $_FILES['content_file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$file_name;
										   $allowed_extensions = array('pdf','zip',);
										   $extension = explode(".", $_FILES['content_file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
										 //insert data into database
                                         $sql="INSERT INTO pastprojects SET title='".addslashes($title)."', studentName='".addslashes($studentName)."', supervisorName='".addslashes($supervisorName)."', content_file='".addslashes($file_name)."', year='$year', coordinatorID='$coordinatorID'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=previous_projects');
										}break;	

                    case 'ideas':
                                         $title=$_POST['title'];
                                         $content=$_POST['content'];
                                        
                                         $userId=Yii::app()->user->id;
										 $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 //insert data into database
                                         $sql="INSERT INTO titleideas SET title='".addslashes($title)."', content='".addslashes($content)."', supervisorID='$supervisorID'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=ideas');break;	

                    case 'attendances':
					                     $studentLastName=$_POST['studentID'];
										 $weekNo=$_POST['weekNo'];
										 $description=$_POST['description'];
										 $comment=$_POST['comment'];
										 
										 $sql="SELECT studentID FROM students WHERE studentLastName='$studentLastName'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $studentID=$result['studentID'];
										 }	
										 
										 $userId=Yii::app()->user->id;
										 $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $sql="INSERT INTO attendances SET studentID='$studentID', supervisorID='$supervisorID', weekNo='$weekNo', description='".addslashes($description)."', comment='".addslashes($comment)."', attendanceTime=NOW() ";
                                         $results=$this->connect->createCommand($sql)->query();

                                         header('location: ?menu=manage&view=attendances');break;
										 
					case 'evaluation':
                                         $studentLastName=$_POST['studentID'];
										 $organisation=$_POST['organisation_score'];
										 $content=$_POST['content_score'];
										 $accomplishment=$_POST['accomplishment_score'];
									     $plan=$_POST['plan_score'];
                                         $delivery=$_POST['delivery_score'];
                                         $multimedia=$_POST['multimedia_score'];
										 $questions=$_POST['questions_score']; 
										 $total=$organisation+$content+$accomplishment+$plan+$delivery+$multimedia+$questions;
										 
										 $sql="SELECT studentID FROM students WHERE studentLastName='$studentLastName'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $studentID=$result['studentID'];
										 }
										 
										 $userId=Yii::app()->user->id;
										 $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $sql="INSERT INTO prentationevaluations SET studentID='$studentID', supervisorID='$supervisorID', organisation_score='$organisation', content_score='$content', accomplishment_score='$accomplishment', plan_score='$plan', delivery_score='$delivery', multimedia_score='$multimedia', questions_score='$questions', total_score='$total', time=NOW() ";
                                         $results=$this->connect->createCommand($sql)->query();

                                         header('location: ?menu=manage&view=evaluation');break;
					
					
					case 'proposals':
                                         $title=$_POST['title'];
                                         $content=$_POST['content'];
										 $supervisorLastName=$_POST['supervisorID'];
                                    
                                         $sql="SELECT supervisorID FROM supervisors WHERE supervisorLastName='$supervisorLastName'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }	
                                         
                                         $userId=Yii::app()->user->id; 
									     $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $studentID=$result['studentID'];
                                         }										 
										 
										 $sql="INSERT INTO titleproposal SET title='".addslashes($title)."', content='".addslashes($content)."', supervisorID='$supervisorID', studentID='$studentID', proposedTime=NOW() ";
                                         $results=$this->connect->createCommand($sql)->query();

                                         header('location: ?menu=manage&view=proposals');break;
										 
										 
					case 'marking':					 
					                      $studentLastName=$_POST['studentID'];
										  $sql="SELECT studentID FROM students WHERE studentLastName='$studentLastName'";
										  $results=$this->connect->createCommand($sql)->query();
										  foreach ($results as $result){
										    $studentID=$result['studentID'];
										  }
										  
										  $userId=Yii::app()->user->id;
										  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										  $results=$this->connect->createCommand($sql)->query();
										  foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										  }
										  
										  $grammar_score=$_POST['grammar_score'];
										  $content_score=$_POST['content_score'];
										  $accomplishment_score=$_POST['accomplishment_score'];
										  $total_score=$grammar_score+$content_score+$accomplishment_score;
										  
										  $sql="INSERT INTO reportmarks SET studentID='$studentID', grammar_score='$grammar_score', content_score='$content_score', accomplishment_score='$accomplishment_score', total_score='$total_score', markerID='$supervisorID', time=NOW() ";
                                          $results=$this->connect->createCommand($sql)->query();

                                          //view the new look
                                          header('location: ?menu=manage&view=marking');break;
					
                    case 'progress_reports': //new added
					                     $userId=Yii::app()->user->id; 
									     $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $studentID=$result['studentID'];
                                         }	
										 
										 $sql="SELECT supervisorID FROM students WHERE studentID='$studentID'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									     $results=$this->connect->createCommand($sql)->query();
									     foreach ($results as $result){
									        $semesterEnd = $result['endTime'];
									        $semesterStart = $result['startTime'];
									     } 
										 
										 $path='';
										 $title=$_POST['title'];
										 $file_name='';
										 $string=strtotime($semesterStart);
										 
										 if(isset($_FILES)){
                                           $file_name = $_FILES['content_file']['name'];
	                                       $file_tmp  = $_FILES['content_file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$string.$file_name;
										   $allowed_extensions = array('pdf','zip');
										   $extension = explode(".", $_FILES['content_file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
										 $sql="INSERT INTO progress_report SET studentID='$studentID', supervisorID='$supervisorID', title='".addslashes($title)."', content_file='".addslashes($file_name)."', submissionTime=NOW() ";
                                         $results=$this->connect->createCommand($sql)->query();
									    
                                          //view the new look
                                         header('location: ?menu=manage&view=progress_reports');
										}break;						  
					
					case 'project_reports':
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $studentID=$result['studentID'];
                                         }	
										 
										 $sql="SELECT supervisorID FROM students WHERE studentID='$studentID'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									     $results=$this->connect->createCommand($sql)->query();
									     foreach ($results as $result){
									        $semesterEnd = $result['endTime'];
									        $semesterStart = $result['startTime'];
									     } 
										 
										 $path='';
										 $title=$_POST['title'];
										 $file_name='';
										 $string=strtotime($semesterStart);
									 
										 if(isset($_FILES)){
                                           $file_name = $_FILES['content_file']['name'];
	                                       $file_tmp  = $_FILES['content_file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$string.$file_name;
										   $allowed_extensions = array('pdf','zip');
										   $extension = explode(".", $_FILES['content_file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
										 $sql="INSERT INTO projectreport SET studentID='$studentID', supervisorID='$supervisorID', title='".addslashes($title)."', content_file='".addslashes($file_name)."', submissionTime=NOW(), independentExaminerID='0'";
                                         $results=$this->connect->createCommand($sql)->query();
									    
                                          //view the new look
                                         header('location: ?menu=manage&view=project_reports');
										}break;						  

                    case 'performance':		
                                          $studentLastName=$_POST['studentID'];
										  $sql="SELECT studentID FROM students WHERE studentLastName='$studentLastName'";
										  $results=$this->connect->createCommand($sql)->query();
										  foreach ($results as $result){
										    $studentID=$result['studentID'];
										  }
										  
										  $userId=Yii::app()->user->id;
										  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										  $results=$this->connect->createCommand($sql)->query();
										  foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										  }
										  
										  $comment=$_POST['comment'];
										  $performance_score=$_POST['performance_score'];
										  
										  $sql="INSERT INTO performance SET studentID='$studentID', comment='".addslashes($comment)."', performance_score='$performance_score', supervisorID='$supervisorID', time=NOW() ";
                                          $results=$this->connect->createCommand($sql)->query();

                                          //view the new look
                                          header('location: ?menu=manage&view=performance');break;					
				}
	    }
	}
	
	public function formEdit(){
	    if(!empty($_POST)){
            $sub_position=$_POST['sub_position'];
                switch($sub_position){
                    case 'announcements':
										 $id = $_POST['id'];
                                         $title=$_POST['title'];
                                         $content=$_POST['content'];
										 $file_name='';
										 
                                         if(isset($_FILES)){
                                           $file_name = $_FILES['file']['name'];
	                                       $file_tmp  = $_FILES['file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$file_name;
										   $allowed_extensions = array('pdf','xls','xlsx','zip');
										   $extension = explode(".", $_FILES['file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u>, <u>.xls</u>, <u>.xlsx</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
										 
										 //insert/update data into database
                                         $sql="UPDATE announcement SET title='".addslashes($title)."', content='".addslashes($content)."', file='".addslashes($file_name)."', coordinatorID='$coordinatorID', publishTime=NOW() WHERE announcementID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=announcements');
										}break;

                    case 'sessions':
                                         $id = $_POST['id'];
										 //$title=$_POST['title'];
                                         $startTime=date('Y-m-d H:m',strtotime($_POST['startTime']));
                                         $endTime=date('Y-m-d H:m',strtotime($_POST['endTime']));
										 
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
                                        
										 //insert data into database
                                         $sql="UPDATE sessions SET startTime='$startTime', endTime='$endTime', coordinatorID='$coordinatorID' WHERE sessionID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=sessions');break;
                     
					case 'previous_projects':
                                         $id = $_POST['id'];
										 $title=$_POST['title'];
										 $studentName=$_POST['studentName'];
                                         $supervisorName=$_POST['supervisorName'];
										 $year=$_POST['year'];
										 $file_name='';
										 
                                         if(isset($_FILES)){
                                           $file_name = $_FILES['content_file']['name'];
	                                       $file_tmp  = $_FILES['content_file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$file_name;
										   $allowed_extensions = array('pdf','zip');
										   $extension = explode(".", $_FILES['content_file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
                                         $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
										 
										 //insert data into database
                                         $sql="UPDATE pastprojects SET title='".addslashes($title)."', studentName='".addslashes($studentName)."', supervisorName='".addslashes($supervisorName)."', content_file='".addslashes($file_name)."', year='$year', coordinatorID='$coordinatorID' WHERE projectID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=previous_projects');
										}break;
					
					case 'titles':
					                     $id = $_POST['id'];
										 $title=$_POST['title'];
                                         $supervisorLastName=$_POST['supervisorLastName'];
										 $comment=$_POST['comment'];
										 $panelApproval=$_POST['panelApproval'];
										 
										 $sql="SELECT supervisorID FROM supervisors WHERE supervisorLastName='$supervisorLastName'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $sql="SELECT studentID FROM titleproposal WHERE proposalID='$id'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $studentID=$result['studentID'];
										 }	
										 
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
									  
										 //insert data into database
                                         $sql="UPDATE titleproposal SET title='".addslashes($title)."', supervisorID='$supervisorID', comment='".addslashes($comment)."', panelApproval='$panelApproval', coordinatorID='$coordinatorID' WHERE proposalID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();
										 
										 $sql="UPDATE students SET supervisorID='$supervisorID' WHERE studentID='$studentID'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=titles');break;
										 
					case 'reports':
					                     $id = $_POST['id'];
										 $independentExaminer=$_POST['independentExaminer'];
										 
										 $sql="SELECT supervisorID FROM supervisors WHERE supervisorLastName='$independentExaminer'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
										 
										 $sql="UPDATE projectreport SET independentExaminerID='$supervisorID', coordinatorID='$coordinatorID' WHERE reportID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=reports');break;
										 
					case 'results':		
                                         $id = $_POST['id'];
										 $externalMarks=$_POST['externalMarks'];
										 
										 $userId=Yii::app()->user->id; 
									     $sql="SELECT coordinatorID FROM coordinator WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $coordinatorID=$result['coordinatorID'];
                                         }
 
                                         $sql="UPDATE results SET externalMarks='$externalMarks', coordinatorID='$coordinatorID' WHERE resultID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=results');break; 
					
					
					
					case 'ideas':
                                         $id = $_POST['id'];
										 $title=$_POST['title'];
                                         $content=$_POST['content'];
										 
										 $userId=Yii::app()->user->id;
										 $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
                                        
										 //insert data into database
                                         $sql="UPDATE titleideas SET title='".addslashes($title)."', content='".addslashes($content)."', supervisorID='$supervisorID' WHERE titleID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=ideas');break;
										 
										 
					case 'titlesSupervisor':
					                     $id = $_POST['id'];
										 $supervisorApproval=$_POST['supervisorApproval'];
										 $supervisorComment=$_POST['supervisorComment'];
										 
										 $sql="UPDATE titleproposal SET supervisorApproval='$supervisorApproval', supervisorComment='$supervisorComment' WHERE proposalID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=titlesSupervisor');break;
										 
					case 'reportsSupervisor':					 
										 $id = $_POST['id'];
										 $supervisorApproval=$_POST['supervisorApproval'];
										 
										 $sql="UPDATE projectreport SET supervisorApproval='$supervisorApproval' WHERE reportID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=reportsSupervisor');break;
										 
					case 'progressSupervisor': //new added
					                     $id = $_POST['id'];
										 $supervisorApproval=$_POST['supervisorApproval'];
										 
										 $sql="UPDATE progress_report SET supervisorApproval='$supervisorApproval' WHERE reportID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=progressSupervisor');break;
										  
					case 'performance':
					                     $id = $_POST['id'];
                                    	 $performance_score=$_POST['performance_score'];
                                         $comment=$_POST['comment'];
                                         $sql="UPDATE performance SET comment='".addslashes($comment)."', performance_score='$performance_score', time=NOW() WHERE performanceID='$id'";
                                         $results=$this->connect->createCommand($sql)->query();

                                         //view the new look
                                         header('location: ?menu=manage&view=performance');break;										 
					
                    case 'evaluation':
                                         $id = $_POST['id'];
										 $studentLastName=$_POST['studentID'];
										 $organisation=$_POST['organisation_score'];
										 $content=$_POST['content_score'];
										 $accomplishment=$_POST['accomplishment_score'];
									     $plan=$_POST['plan_score'];
                                         $delivery=$_POST['delivery_score'];
                                         $multimedia=$_POST['multimedia_score'];
										 $questions=$_POST['questions_score']; 
										 $total=$organisation+$content+$accomplishment+$plan+$delivery+$multimedia+$questions;
										 
										 $sql="SELECT studentID FROM students WHERE studentLastName='$studentLastName'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $studentID=$result['studentID'];
										 }
										 
										 $userId=Yii::app()->user->id;
										 $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $sql="UPDATE prentationevaluations SET studentID='$studentID', supervisorID='$supervisorID', organisation_score='$organisation', content_score='$content', accomplishment_score='$accomplishment', plan_score='$plan', delivery_score='$delivery', multimedia_score='$multimedia', questions_score='$questions', total_score='$total', time=NOW() WHERE evaluationID='$id' ";
                                         $results=$this->connect->createCommand($sql)->query();

                                         header('location: ?menu=manage&view=evaluation');break;
										 
			        case 'presentation':		
                                         $id = $_POST['id'];
										 $studentLastName=$_POST['studentID'];
										 $organisation=$_POST['organisation_score'];
										 $content=$_POST['content_score'];
										 $accomplishment=$_POST['accomplishment_score'];
									     $plan=$_POST['plan_score'];
                                         $delivery=$_POST['delivery_score'];
                                         $multimedia=$_POST['multimedia_score'];
										 $questions=$_POST['questions_score']; 
										 $total=$organisation+$content+$accomplishment+$plan+$delivery+$multimedia+$questions;
										 
										 $sql="SELECT studentID FROM students WHERE studentLastName='$studentLastName'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $studentID=$result['studentID'];
										 }
										 
										 $sql="UPDATE prentationevaluations SET studentID='$studentID', organisation_score='$organisation', content_score='$content', accomplishment_score='$accomplishment', plan_score='$plan', delivery_score='$delivery', multimedia_score='$multimedia', questions_score='$questions', total_score='$total', time=NOW() WHERE evaluationID='$id' ";
                                         $results=$this->connect->createCommand($sql)->query();

                                         header('location: ?menu=manage&view=presentation');break;
					
					case 'markingreport':
					                     $id = $_POST['id'];
										  $grammar_score=$_POST['grammar_score'];
										  $content_score=$_POST['content_score'];
										  $accomplishment_score=$_POST['accomplishment_score'];
										  $total_score=$grammar_score+$content_score+$accomplishment_score;
										  
										  $sql="UPDATE reportmarks SET grammar_score='$grammar_score', content_score='$content_score', accomplishment_score='$accomplishment_score', total_score='$total_score', time=NOW() WHERE markingID='$id'";
                                          $results=$this->connect->createCommand($sql)->query();

                                          //view the new look
                                          header('location: ?menu=manage&view=markingreport');break;
					
					
					case 'marking':					 
										  $userId=Yii::app()->user->id;
										  $sql="SELECT supervisorID FROM supervisors WHERE userID='$userId'";
										  $results=$this->connect->createCommand($sql)->query();
										  foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										  }
										  
										  $id = $_POST['id'];
										  $grammar_score=$_POST['grammar_score'];
										  $content_score=$_POST['content_score'];
										  $accomplishment_score=$_POST['accomplishment_score'];
										  $total_score=$grammar_score+$content_score+$accomplishment_score;
										  
										  $sql="UPDATE reportmarks SET grammar_score='$grammar_score', content_score='$content_score', accomplishment_score='$accomplishment_score', total_score='$total_score', markerID='$supervisorID', time=NOW() WHERE markingID='$id'";
                                          $results=$this->connect->createCommand($sql)->query();

                                          //view the new look
                                          header('location: ?menu=manage&view=marking');break;
					
                    case 'proposals':
					                     $id = $_POST['id'];
                                         $title=$_POST['title'];
										 
										 $sql="UPDATE titleproposal SET submissionTime=NOW() WHERE title='$title'";
                                         $results=$this->connect->createCommand($sql)->query();
										 
										 header('location: ?menu=manage&view=proposals');break;
										 
					case 'progress_reports': //new added
                                         $userId=Yii::app()->user->id; 
									     $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $studentID=$result['studentID'];
                                         }	
										 
										 $sql="SELECT supervisorID FROM students WHERE studentID='1'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $path='';
										 $title=$_POST['title'];
										 $file_name='';
										 
										 $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									     $results=$this->connect->createCommand($sql)->query();
									     foreach ($results as $result){
									        $semesterEnd = $result['endTime'];
									        $semesterStart = $result['startTime'];
									     } 
										 
										 $string=strtotime($semesterStart);
										 
										 if(isset($_FILES)){
                                           $file_name = $_FILES['content_file']['name'];
	                                       $file_tmp  = $_FILES['content_file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$string.$file_name;
										   $allowed_extensions = array('pdf','zip');
										   $extension = explode(".", $_FILES['content_file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
										 $sql="UPDATE progress_report SET title='".addslashes($title)."', content_file='".addslashes($file_name)."', submissionTime=NOW(), independentExaminerID='0', supervisorApproval='' WHERE studentID='$studentID' ";
                                         $results=$this->connect->createCommand($sql)->query();
									     
										
                                          //view the new look
                                         header('location: ?menu=manage&view=progress_reports');
										}break;					
					
					case 'project_reports':
                                         $userId=Yii::app()->user->id; 
									     $sql="SELECT studentID FROM students WHERE userID='$userId'";
                                         $results=$this->connect->createCommand($sql)->query();
                                         foreach ($results as $result){
                                            $studentID=$result['studentID'];
                                         }	
										 
										 $sql="SELECT supervisorID FROM students WHERE studentID='1'";
										 $results=$this->connect->createCommand($sql)->query();
										 foreach ($results as $result){
										    $supervisorID=$result['supervisorID'];
										 }
										 
										 $path='';
										 $title=$_POST['title'];
										 $file_name='';
										 
										 $sql="SELECT endTime, startTime FROM sessions WHERE title='Semester duration'";
									     $results=$this->connect->createCommand($sql)->query();
									     foreach ($results as $result){
									        $semesterEnd = $result['endTime'];
									        $semesterStart = $result['startTime'];
									     } 
										 
										 $string=strtotime($semesterStart);
										
										 if(isset($_FILES)){
                                           $file_name = $_FILES['content_file']['name'];
	                                       $file_tmp  = $_FILES['content_file']['tmp_name'];
                                           $directory_path = $_SERVER["DOCUMENT_ROOT"].yii::app()->baseUrl.'/files/';
								     	   $path=$directory_path.$string.$file_name;
										   $allowed_extensions = array('pdf','zip');
										   $extension = explode(".", $_FILES['content_file']['name']);
                                           $file_extension = array_pop($extension);
										   if (in_array($file_extension, $allowed_extensions)){
										      if(is_dir($directory_path)){
                                                   move_uploaded_file($file_tmp, $path);              
                                              }else {
										           echo 'Error in accessing the path directory';
										      }
										   }else{
										      echo "<div class='wrapper'>
			                                             <div class='clear'></div>
					                                     <div class='step' id='first'>
														    <p><h1 class='content_header'>error in uploading a file: <u>.pdf</u> and <u>.zip</u> are the only <u>allowed</u> file extensions. <h1/><p/>
														 </div>	
													   </div>"; 
										   }
										}
										if (in_array($file_extension, $allowed_extensions) || ($file_name=='')){
										 $sql="UPDATE projectreport SET title='".addslashes($title)."', content_file='".addslashes($file_name)."', submissionTime=NOW(), independentExaminerID='0', supervisorApproval='' WHERE studentID='$studentID' ";
                                         $results=$this->connect->createCommand($sql)->query();
									     
										
                                          //view the new look
                                         header('location: ?menu=manage&view=project_reports');
										}break;					 
							  
                }

        }
	
	}
	
	
	public function form_builder($header,$type,$inputs_step_1,$inputs_step_2,$action){
		if($inputs_step_2!=null){
			 $inputs_step_2="<div class='step' id='second'>$inputs_step_2</div>";
		}else {
			$inputs_step_2='';
		}
	    
	  if($action=='add') {
		$content="<div class='wrapper'>
          <h1 class='content_header'>$header</h1><div class='clear'></div>
			<form action='".$this->formAdd()."' id='input_form' method='post' enctype='multipart/form-data'>
				     <div class='step' id='first'>$inputs_step_1</div>
							$inputs_step_2 				
						
				<div id='reportNavigation'> 							
						<p>
						<input type='hidden' name='sub_position' value='".@$_GET['add']."' />
						<input class='navigation_button' id='back' value='Reset' type='reset' />
						<input class='navigation_button' id='next' value='Submit' type='submit' />
						</p>
				</div>
			</form>
		  </div>"; 
		  
	  }else if($action=='edit'){ //change to formEdit
	    $content="<div class='wrapper'>
          <h1 class='content_header'>$header</h1><div class='clear'></div>
			<form action='".$this->formEdit()."' id='input_form' method='post' enctype='multipart/form-data'>
				     <div class='step' id='first'>$inputs_step_1</div>
							$inputs_step_2 				
						
				<div id='reportNavigation'> 							
						<p>
						<input type='hidden' name='id' value='".@$_GET['value']."' />
						<input type='hidden' name='sub_position' value='".@$_GET['view']."' />
						<input class='navigation_button' id='back' value='Reset' type='reset' />
						<input class='navigation_button' id='next' value='Submit' type='submit' />
						</p>
				</div>
			</form>
		  </div>";
		  
	  }
	  
		return $content;
	}

	
/*9 

9*/	
	
	//DEALING WITH MISC FREQUENTLY USED METHODS
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
		$sql=$this->connect->createCommand($sql);
		$sql->bindParam(':value', $parameter);
		$result=$sql->query();
		return $result;
	}
	 //$results=$connect->createCommand($sql)->query();
/*******	
	
*******/	
	
/*****
	
*****/	
	
/*8  
 
8*/
	
	
	
	
	//customizing dashboard
	public function get_dashboard(){
	
		$content='<div class="message_dash">
					<h1>WELCOME</h1>
					<p>Project Management System (PMS) is the web-based system for the modern electronic way of managing undergraduates final year projects.</p>
					</div>
					
			    <div class="block announcements">
				<h1 class="blockhead">ANNOUNCEMENTS</h1>
				<div class="clear"></div>
				<ul class="block_list">';
			$sql= 'SELECT * FROM announcement ORDER BY publishTime DESC LIMIT 2'; 
			$x=$this->connect->createCommand($sql)->query();
			foreach($x as $y){
			   $content.='<li><a href="#">'.$y['title'].'</a>
                         <span class="info">'.$y['publishTime'].'</span>
			             </li>';
			}
				
			$sql= 'SELECT COUNT(*) FROM announcement'; 
			$x=$this->connect->createCommand($sql)->query();
			foreach($x as $y){
			   if ($y['COUNT(*)']>0){
			     $content.='<span class="moreinfo"><a href="41.86.176.19/index.php/pms?menu=manage&amp;view=dash_announcements" style="text-decoration:none; color:orange">more</a></span>';
			   }else {
			     $content.='';
			   }
			}
				
			$content.='
			    </ul>
				
			    </div>
			    <div class="block past">
				<h1 class="blockhead">PAST PROJECTS</h1>
				<div class="clear"></div>
				<ul class="block_list">';
			$sql= 'SELECT * FROM pastprojects  ORDER BY year DESC LIMIT 2'; 
			$x=$this->connect->createCommand($sql)->query();
			
			foreach($x as $y){		
				$content.='<li><a href="#">'.$y['title'].'</a>
                         <span class="info">'.$y['studentName'].', '.$y['year'].'</span>
			             </li>';
			}
			$sql= 'SELECT COUNT(*) FROM pastprojects'; 
			$x=$this->connect->createCommand($sql)->query();
			foreach($x as $y){
			   if ($y['COUNT(*)']>0){
			     $content.='<span class="moreinfo"><a href="41.86.176.19/index.php/pms?menu=manage&amp;view=dash_pastprojects" style="text-decoration:none; color:orange">more</a></span>';
			   }else {
			     $content.='';
			   }
			}
			
			$content.='	
				</ul>			
			
			    </div>
				<div class="clear"></div>
			    <div class="block ideas">
				<h1 class="blockhead">PROJECT IDEAS</h1>
				<div class="clear"></div>
				<ul class="block_list">';
			$sql= 'SELECT title, publishTime, supervisorLastName FROM titleideas  
			       INNER JOIN supervisors ON supervisors.supervisorID=titleideas.supervisorID 
				   ORDER BY publishTime DESC LIMIT 2'; 
			$x=$this->connect->createCommand($sql)->query();
			
			foreach($x as $y){		
				$content.='<li><a href="#">'.$y['title'].'</a>
                         <span class="info">'.$y['supervisorLastName'].', '.$y['publishTime'].'</span>
			             </li>';
			}
			$sql= 'SELECT COUNT(*) FROM titleideas'; 
			$x=$this->connect->createCommand($sql)->query();
			foreach($x as $y){
			   if ($y['COUNT(*)']>0){
			     $content.='<span class="moreinfo"><a href="41.86.176.19/index.php/pms?menu=manage&amp;view=dash_titleideas" style="text-decoration:none; color:orange">more</a></span>';
			   }else {
			     $content.='';
			   }
			}
			$content.='	
				</ul>

				</div>
     			<div class="block approved">
				<h1 class="blockhead">APPROVED PROJECTS</h1>
				<div class="clear"></div>
				<ul class="block_list">';
				
				date_default_timezone_set('Africa/Nairobi');
				$year = date("Y");                                      
				
			$sql= "SELECT title, submissionTime, studentLastName FROM titleproposal  
			       INNER JOIN students ON students.studentID=titleproposal.studentID
				   WHERE (panelApproval != 'NULL') AND (DATE_FORMAT(submissionTime, '%Y')='$year')  
				   ORDER BY submissionTime DESC LIMIT 2";  
			$x=$this->connect->createCommand($sql)->query();
			
			foreach($x as $y){		
				$content.='<li><a href="#">'.$y['title'].'</a>
                         <span class="info">'.$y['studentLastName'].', '.$y['submissionTime'].'</span>
			             </li>';
			}
			$sql= "SELECT COUNT(*) FROM titleproposal  
				   WHERE (panelApproval != 'NULL') AND (DATE_FORMAT(submissionTime, '%Y')='$year')"; 
			$x=$this->connect->createCommand($sql)->query();
			foreach($x as $y){
			   if ($y['COUNT(*)']>0){
			     $content.='<span class="moreinfo"><a href="41.86.176.19/index.php/pms?menu=manage&amp;view=dash_titleproposal" style="text-decoration:none; color:orange">more</a></span>';
			   }else {
			     $content.='';
			   }
			}
			$content.='			
				</ul>	
				
			
			</div>';
			
	return $content;
	}
	
	
    //switching the user's interfaces on different roles
	public function switch_system($position,$sub_position,$action){

	  if($this->role==1){
		switch($position){
		 case 'home':$content=$this->get_dashboard();break;
		 case 'manage':$content=$this->get_manage_one($position,$sub_position,$action);break;
		 case 'chat':$content=$this->get_chat($position,$sub_position,$action);break;
		 default:$content='';
		}
		
	  }else if($this->role==2){
		switch($position){
		 case 'home':$content=$this->get_dashboard();break;
		 case 'manage':$content=$this->get_manage_two($position,$sub_position,$action);break;
		 case 'chat':$content=$this->get_chat($position,$sub_position,$action);break;
		 default:$content='';
		}
		
	  }else if($this->role==3){
		switch($position){
		 case 'home':$content=$this->get_dashboard();break;
		 case 'manage':$content=$this->get_manage_three($position,$sub_position,$action);break;
		 case 'chat':$content=$this->get_chat($position,$sub_position,$action);break;
		 default:$content='';
		}
	  }else if(($this->role==4)||($this->role==5)){
		switch($position){
		 case 'home':$content=$this->get_dashboard();break;
		 case 'manage':$content=$this->get_manage_three($position,$sub_position,$action);break;
		 default:$content='';
		}
	  }	
     return $content;
    }
	

}     

?>