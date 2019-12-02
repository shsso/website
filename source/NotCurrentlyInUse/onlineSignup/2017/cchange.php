<?php
  session_start();
  //include("valiableSet.inc");
  $periodTime[1] = "9:30~10:20";
	$periodTime[2] = "10:30~11:20";
	$periodTime[3] = "11:30~12:20";
	$periodTime[4] = "12:30~1:20";
	$periodTime[5] = "1:30~2:20";
	$periodTime[6] = "2:30~3:20";
	
	$timePeriod["9:30~10:20"] = 1; 
	$timePeriod["10:30~11:20"] = 2;
	$timePeriod["11:30~12:20"] = 3;
	$timePeriod["12:30~1:20"] = 4; 
	$timePeriod["1:30~2:20"] = 5;  
	$timePeriod["2:30~3:20"] = 6;  
	
	$totalEvent = 8;
	$eventName[0] =   "Experimental Design";            
	$eventName[1] =   "Electric Vehicle";            
	$eventName[2] =   "Helicopters";          
	$eventName[3] =   "Towers";
	$eventName[4] =   "Hovercraft";
	$eventName[5] =   "Robot Arm";
	$eventName[6] =   "Trial 1: TBD";
	$eventName[7] =   "Trial 2: TBD";
	
	$location[0] = "Commons";
	$location[1] = "Old Gym";
	$location[2] = "Orchestra room 160";
	$location[3] = "ROOM 150";
	$location[4] = "Old Gym";
	$location[5] = "161 (Band rm)";
	$location[6] = "Room 209A";
	$location[7] = "Room 206";
	
	//event flag: 1 for selective schedule and 0 for fixed	
	$eventF[0] = 1;
	$eventF[1] = 1;
	$eventF[2] = 1;
	$eventF[3] = 1; 
	$eventF[4] = 1; 
	$eventF[5] = 1;
	$eventF[6] = 1;
	$eventF[7] = 1;
	
	
	$UID = "ssssadmin";
	$pwd = "!QAZ2wsx";
	$address = "solonsoadmin.ipagemysql.com";
	
	$dbName = "solon2017";
	$dbTeamTable[0] = "DivBTeams";
	$dbTeamTable[1] = "DivCTeams";
	$dbTimeTable[0] = "DivBTime";
	$dbTimeTable[1] = "DivCTime";

	
	if(isset($_GET['event'])) {
		$changeEvent = $_GET['event'];
		$changeEventName = $eventName[$changeEvent];
		$_SESSION['changeEventName'] = $changeEventName;
	} else {
		session_destroy(); 
		die("Error: No Change Event.<br><br><a href='clogin.php'>Please Log In to Solon Science Olympiad Sign Up.");
	}
	
	//echo $changeEvent . "--" . $eventName[$changeEvent] . "--" . $_SESSION['changeEventName'] . "<br>\n";
	
	$link = mysql_connect($address, $UID, $pwd);
  	//echo $link . "<br />";
  	if (!$link) { 
  	  echo 'Could not connect to the MySQL database.  Please try late. <p></p>';
   	 session_destroy(); 
   	 die('MySQL Error: ' . mysql_error()); 
  	}
  	mysql_select_db($dbName, $link);
  	
  	//$tid = $_SESSION['UserID'];
  	$tid = $_GET['uid'];
		$tpwd = $_GET['pid'];
  	//$tpwd = $_SESSION['UserPaswd'];
  	$qstr = "SELECT * FROM $dbTeamTable[1] WHERE UserID ='$tid' and UserPaswd ='$tpwd'";
  	
  	$result = mysql_query($qstr);
    //echo $result . "<br />";
    if ( mysql_num_rows($result) != 1 ) {
    	echo 'Fail to login.  Please check the team ID (B## or C##) and the password.<p></p>';
    	session_destroy();
    	echo '<p><big><strong><a href="clogin.php">Try again.</strong></p></big>';
    	mysql_close($link);
    	die();
    } 
    
    $current = mysql_result($result,0,$changeEventName);
//echo "current=$current<br>\n";

  	$qstr = "SELECT * FROM $dbTimeTable[1] WHERE Event ='$changeEventName'";
  	$result1 = mysql_query($qstr);
    //echo $result . "<br />";
    if ( mysql_num_rows($result1) != 1 ) {
    	echo 'Fail to login.  Please check the team ID (B## or C##) and the password.<p></p>';
    	session_destroy();
    	echo '<p><big><strong><a href="clogin.php">Try again.</strong></p></big>';
    	mysql_close($link);
    	die();
    } 
    
    if ( $current == "" || $current == "0" ) {
    	$current = "&nbsp;";
    }
    
    $openCount = 0;
    $previous = "";
    
    $tT = 61;
    
    for ($i = 1; $i < $tT; $i++) {
    	$time = mysql_result($result1,0,"T$i");
    	$team = mysql_result($result1,0,"D$i");
//echo "$i -- $time --$team<br>\n"; 	
    	if ( $time == "" ) {
    		//the end time slot
    		$i = $tT;
    	} elseif ( $team == "" && $current != $time && $previous != $time) {
    		$openCount ++ ;
    		$openTime[$openCount] = $time;
    		$previous = $time;
//echo "openTime($openCount) = $time<br>\n";
    	}	
    }
    
    $action = "cupdate.php?uid=" . $tid . "&pid=" . $tpwd . "&evn=" . $changeEventName

?>
<html>
<body>

<h2 align="center"><big><strong>Science Olympiad</strong></p></big></h2>
<p align="center"><big><strong>2017 SOLON INVITATIONAL DIVISION C WALK-IN EVENT SCHEDULE</strong></p></big>
<p align="center"><big><strong>Saturday, Feb. 4, 2017</strong></p></big>
<br>
<h3 align="center"><big><strong>Team <?php echo $_SESSION['UserID'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . mysql_result($result,0,"Team"); ?></strong></p></big></h3>

<!--
<div align="center"><center><table border="4">
   <tr><td align="center" width="300">Team ID</td><td align="center" width="300"><?php echo $_SESSION['UserID']; ?></td></tr>
   <tr><td align="center">Team</td><td align="center"><?php echo mysql_result($result,0,"Team") ; ?></td></tr>
   <tr><td align="center" width="300">Coach</td><td align="center" width="300"><?php echo mysql_result($result,0,"Coach") ; ?></td></tr>
   <tr><td align="center">Address</td><td align="center"><?php echo mysql_result($result,0,"Address") ; ?></td></tr>
   <tr><td align="center">City</td><td align="center"><?php echo mysql_result($result,0,"City") ; ?></td></tr>
   <tr><td align="center">State</td><td align="center"><?php echo mysql_result($result,0,"State") ; ?></td></tr>
   <tr><td align="center">Zip</td><td align="center"><?php echo mysql_result($result,0,"Zip") ; ?></td></tr>
   <tr><td align="center">e-mail</td><td align="center"><?php echo mysql_result($result,0,"e-mail") ; ?></td></tr>
   <tr><td align="center">Phone</td><td align="center"><?php echo mysql_result($result,0,"Phone") ; ?></td></tr>
   <tr><td align="center">Base Room</td><td align="center"><?php echo mysql_result($result,0,"Base Room") ; ?></td></tr>
</table></div>
-->

<br><br>

<h2 align="center"><strong>Event Schedule Change</strong></h4>
<h2 align="center"><strong><?php echo $changeEventName; ?></strong></h4>

<form ACTION="<?php echo $action; ?>" name="saveform" METHOD="POST" align="center">
<h4 align="center">Current Time: <?php echo $current; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; New Time: <select name="time"> 
	<?php 
		for ($i = 1; $i <= $openCount; $i++) {
			echo "<option>$openTime[$i]</option>\n";
		}
	?> </h4>
<input type="submit" align="center"  VALUE="Submit"/>
</form>
<br><br>
<p align="center"><a href='<?php echo "cdisplay.php?uid=".$tid."&pid=".$tpwd; ?>'><big><strong><b>Go Back</b></strong></p></big>
</body></html>
<?php   	mysql_close($link); ?>
