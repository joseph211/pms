<?php

   $connect=Yii::app()->db;
   //$connection=Yii::app()->db2;

   $userId=Yii::app()->user->id; 
   
   $sql="SELECT user_id, lastname, firstname, username, student, staff, year_of_study FROM profile 
         INNER JOIN user ON profile.user_id=user.id 
		 WHERE ((profile.year_of_study='0') OR (profile.year_of_study='3' AND profile.degreeID='1') OR (profile.year_of_study='2' AND profile.degreeID='1'))";
   $results=$connect->createCommand($sql)->query();
   foreach ($results as $result){
      $data=(array) $result;
      $new_result=  array_values($data);
	  $user_id=$new_result[0];
      $name=$new_result[1].' '.$new_result[2];
	  $username=$new_result[3];
      $student=$new_result[4];
      $staff=$new_result[5];
	  $year=$new_result[6];
	  
	  $sql="SELECT * FROM coordinator WHERE userID='$user_id'";
	  $results=$connect->createCommand($sql)->query();
	  $rows=count($results);
	  if (($rows==0)&&($username=='PMScoordinator')){
	     $sql="INSERT INTO coordinator SET coordinatorLastName='".addslashes($name)."', userID='$user_id'";
		 $results=$connect->createCommand($sql)->query();
	  } else if ($rows!=0){
	     $sql="UPDATE coordinator SET coordinatorLastName='".addslashes($name)."' WHERE userID='$user_id'";
		 $results=$connect->createCommand($sql)->query();
	  }
	  
	  $sql="SELECT * FROM supervisors WHERE userID='$user_id'";
	  $results=$connect->createCommand($sql)->query();
	  $rows=count($results);
	  if (($rows==0)&&($username!='PMScoordinator')&&($username!='coordinator2')&&($staff==1)){
	     $sql="INSERT INTO supervisors SET SupervisorLastName='".addslashes($name)."', userID='$user_id'";
		 $results=$connect->createCommand($sql)->query();
	  } else if ($rows!=0){
	     $sql="UPDATE supervisors SET SupervisorLastName='".addslashes($name)."' WHERE userID='$user_id'";
		 $results=$connect->createCommand($sql)->query();
	  }
	  
	  $sql="SELECT * FROM students WHERE userID='$user_id'";
	  $results=$connect->createCommand($sql)->query();
	  $rows=count($results);
	  if (($rows==0)&&($student==1)){
	     $sql="INSERT INTO students SET studentLastName='".addslashes($name)."', userID='$user_id', yearStudy='$year'";
		 $results=$connect->createCommand($sql)->query();
	  } else if ($rows!=0){
	     $sql="UPDATE students SET studentLastName='".addslashes($name)."' WHERE userID='$user_id'";
		 $results=$connect->createCommand($sql)->query();
	  }
    }
   
   
  ///moving titles to past projects..............
    date_default_timezone_set('Africa/Nairobi');
	$year = date("Y");                                      
									  
    $sql="SELECT proposalID, title, studentLastName, supervisorLastName, submissionTime, comment, panelApproval FROM titleproposal
		  INNER JOIN students ON students.studentID = titleproposal.studentID
		  INNER JOIN supervisors ON supervisors.supervisorID = titleproposal.supervisorID
		  WHERE (supervisorApproval='Accepted') AND (panelApproval != 'NULL') AND (DATE_FORMAT(submissionTime, '%Y')<'$year') ";
    $results=$connect->createCommand($sql)->query();
    foreach ($results as $result){
              $title=$result['title'];
              $studentLastName=$result['studentLastName'];
              $supervisorLastName=$result['supervisorLastName'];
              /*$submissionTime=$result['submissionTime'];
              $comment=$result['comment'];
              $panelApproval=$result['panelApproval'];*/   
    
	    $sql="SELECT * FROM pastprojects WHERE (title='".addslashes($title)."') AND (studentName='".addslashes($studentLastName)."') AND (supervisorName='".addslashes($supervisorLastName)."') ";
	    $results=$connect->createCommand($sql)->query();
	    $rows=count($results);
	    if ($rows==0){
	      $sql="INSERT INTO pastprojects SET title='".addslashes($title)."', studentName='".addslashes($studentLastName)."', supervisorName='".addslashes($supervisorLastName)."', year='$year'";
		  $results=$connect->createCommand($sql)->query();
	    }
	
	}
	
   //$submissionTime=(DATE_FORMAT($result['submissionTime'], '%Y');
   
   
   ?>