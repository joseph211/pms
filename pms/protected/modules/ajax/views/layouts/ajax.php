<?php

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

//$receiverID=$_POST['receiverID'];
//$userId=$_POST['userID'];
//$receiverID=1;
//$userId=31;

/*get the values entered by the user from the form*/
if (isset($_POST['message']))
 $message=$_POST['message'];
 
if (isset($_POST['time']))
 $timestamp=intval($_POST['time']);
 
 
 $receiverID=$_POST['receiverID'];
 

 $userID=$_POST['userID'];
   


 // Script
/*error_reporting(E_ALL);
header("Content-type: text/xml");
header("Cache-Control: no-cache");
 */
 //exit;
   
   
   
   
/*if message variable is set insert this comment to our database */
if(!empty($message))
{
$sql="INSERT INTO chat_room SET source='$userID', receiver='$receiverID', stamp=".time().", content='".addslashes($message)."'";
//$sql=$connect->createCommand($sql);
$sql=$db->prepare($sql);
$sql->bindParam(':source',$userID);
$sql->bindParam(':content',$message);
//$result=$sql->query();
$sql->execute();
}



/*now lets write our simple XML file so that we can get the latest message*/

/*$sql="SELECT * FROM chat_room WHERE (source='$userId' AND receiver='$receiverID') OR (source='$receiverID' AND receiver='$userId') ORDER BY stamp>:timestamp";
$sql=$connect->createCommand($sql);
$sql->bindParam(':timestamp',$timestamp);
$results=$sql->query();
$count=count($results);
*/
$sql="SELECT COUNT(*) FROM chat_room WHERE (source='$userID' AND  receiver='$receiverID') OR (source='$receiverID' AND receiver='$userID') ORDER BY stamp>:timestamp";
$sql=$db->prepare($sql);
$sql->bindParam(':timestamp',$timestamp);
$sql->execute();
$count=$sql->fetch();
$count=$count[0];



/*$sql="SELECT lastname, firstname, content, DATE_FORMAT(time, '%d %M, %Y at %H:%i:%s') as time, stamp FROM chat_room
      INNER JOIN profile ON chat_room.source=profile.user_id 
	  WHERE ((source='$userId' AND receiver='$receiverID') OR (source='$receiverID' AND receiver='$userId')) AND (stamp>'$timestamp') 
	  ORDER BY msg_no ASC";
$sql=$connect->createCommand($sql);
$messages=$sql->query();*/

$sql="SELECT lastname, firstname, content, DATE_FORMAT(time, '%d %M, %Y at %H:%i:%s') as time, stamp, msg_no, receiver_seen, receiver FROM chat_room
      INNER JOIN profile ON chat_room.source=profile.user_id 
	  WHERE ((source='$userID' AND receiver='$receiverID') OR (source='$receiverID' AND receiver='$userID')) AND (stamp>'$timestamp') 
	  ORDER BY msg_no ASC";
$messages=$db->query($sql);



if($count== 0){ 
$status_code = 2;}
else {
$status_code = 1;
}




header("Cache-Control: no-cache");


echo "<?xml version=\"1.0\"?>\n";
echo "<response>\n";
echo "\t<status>$status_code</status>\n";
echo "\t<time>".time()."</time>\n";

if($status_code == 1)
{
	foreach ($messages as $message)
	{
	    if ($message['receiver']==$userID && $message['receiver_seen']==0){
          $sql="UPDATE chat_room SET receiver_seen='1' WHERE msg_no=$message[msg_no]";
          $sql=$db->query($sql);
		}
		
		$message['content'] = htmlspecialchars(stripslashes($message['content']));
		echo "\t<message>\n";
		echo "\t\t<author>$message[firstname] $message[lastname]</author>\n";
		echo "\t\t<text>$message[content]</text>\n";
		echo "\t\t<date_time>$message[time]</date_time>\n";
		echo "\t</message>\n";
	}
}
echo "</response>";




?>