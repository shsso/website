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

	//Total time slots + 1:
    $tT = 61;  
	
	//$changeEventName = $_SESSION['changeEventName'];
	if(isset($_POST['time'])) {
		$newTime = $_POST['time'];
	} else {
		session_destroy(); 
		die("Error: No time selected.<br><br><a href='login.php'>Please Log In to Solon Science Olympiad Sign Up.");
	}
	
	$changeEventName = $_GET['evn'];
	$tid = $_GET['uid'];
  	$tpwd = $_GET['pid'];

	//echo $changeEventName . "\n" . $newTime;
	
	$link = mysql_connect($address, $UID, $pwd);
  	//echo $link . "<br />";
  	if (!$link) { 
  	  echo 'Could not connect to the MySQL database.  Please try late. <p></p>';
   	 session_destroy(); 
   	 die('MySQL Error: ' . mysql_error()); 
  	}
  	mysql_select_db($dbName, $link);
  	
  	//$tid = $_SESSION['UserID'];
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
    
    $ctm = "&nbsp;";
    $ctm = mysql_result($result,0,$changeEventName);
 	
  	$qstr = "SELECT * FROM $dbTimeTable[1] WHERE Event ='$changeEventName'";
  	$result1 = mysql_query($qstr);
    //echo $result . "<br />";
    if ( mysql_num_rows($result1) != 1 ) {
    	echo 'MySQL Error: ' . mysql_error() . '<br>';
    	session_destroy();
    	echo '<p><big><strong><a href="clogin.php">Try again.</strong></p></big>';
    	mysql_close($link);
    	die();
    } 
    
    $cFieldName="";
    $nFieldName="";
    
    //$tT = 51;
    
    $msg = "";
    for ($i = 1; $i < $tT; $i++) {
    	$time = mysql_result($result1,0,"T$i");
    	$team = mysql_result($result1,0,"D$i");
    	if ( $time == "" ) {
    		//the end time slot
    		$i = $tT;
			} elseif ( $team == $tid ) {
    		$cFieldName = "D$i";
    	} elseif ( $nFieldName == "" && $team == "" && $time == $newTime) {
    		$nFieldName = "D$i";
    	}
    }
    if ( $nFieldName == "" ) {
    	$msg = $newTime . " for " .  $changeEventName . " is not avaliable.  Please select another time.";
    } else {
    	if ( $cFieldName == "" ) {
    		$deleteCurrent = "";
    	} else {
    		$deleteCurrent = "$cFieldName = '',";
    	}
    	$updateTime = "UPDATE $dbTimeTable[1] SET $deleteCurrent $nFieldName = '$tid' WHERE Event ='$changeEventName'";
		if ( !mysql_query($updateTime) ) {
			$msg = "ERROR - unable to save the new time!<br>SQL ERROR: ".mysql_errno().".  ".mysql_error()."<BR><BR>";
		} else {
			$updateTeam = "UPDATE $dbTeamTable[1] SET `$changeEventName` = '$newTime' WHERE UserID ='$tid' and UserPaswd ='$tpwd'";
			if ( !mysql_query($updateTeam) ) {
				$msg = "ERROR - unable to save the team recoder!<br>SQL ERROR: ".mysql_errno().".  ".mysql_error()."<BR><BR>";
			}
		}
	}
	
	if ( $msg == "" ) {
		$msg = "The time for $changeEventName is successfully updated.";
	}
	
	$qstr = "SELECT * FROM $dbTeamTable[1] WHERE UserID ='$tid' and UserPaswd ='$tpwd'";
  	
  	$result = mysql_query($qstr);
  	
  	for ($i = 0; $i < $totalEvent; $i++) {
  		$TE[$i] = mysql_result($result,0,$eventName[$i]);
  	}
?>
<html>
<body>

<h2 align="center"><big><strong>Science Olympiad</strong></p></big></h2>
<p align="center"><big><strong>2017 SOLON INVITATIONAL DIVISION C WALK-IN EVENT SCHEDULE</strong></p></big>
<p align="center"><big><strong>Saturday, Feb. 4, 2017</strong></p></big>
<br>
<!--
<h3 align="center"><big><strong>Team <?php echo $tid . "&nbsp;&nbsp;&nbsp;&nbsp;" . mysql_result($result,0,"Team"); ?>&nbsp;&nbsp;&nbsp;&nbsp;Base Room: <?php echo mysql_result($result,0,"Base Room") ; ?></strong></p></big></h3>
-->
<h3 align="center"><big><strong>Team <?php echo $tid . "&nbsp;&nbsp;&nbsp;&nbsp;" . mysql_result($result,0,"Team"); ?></strong></p></big></h3>
<br>

<p align="center"><big><strong><?php echo $msg; ?></strong></p></big>
<!--   
<div align="center"><center><table border="4">
<tr><td align="center" width="300">Team ID</td><td align="center" width="300"><?php echo $tid; ?></td></tr>
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
<div align="center"><center><table border="4">
   <tr>
		<td align="center" width="150"><b>Event</td>
		<td align="center" width="100"><b>Location</td>
		<td align="center" width="100"><b>9:30~10:20</td>
		<td align="center" width="100"><b>10:30~11:20</td>
		<td align="center" width="100"><b>11:30~12:20</td>
		<td align="center" width="100"><b>12:30~1:20</td>
		<td align="center" width="100"><b>1:30~2:20</td>
		<td align="center" width="100"><b>2:30~3:20</td>
		<td align="center" width="59">&nbsp;</td>
   </tr>
   <?php for ($i = 0; $i < $totalEvent; $i++) {
   		echo "<tr><td align='center'><b>" . $eventName[$i] . "</b></td><td align='center'>" . $location[$i] . "</td>";
   		$t = $TE[$i];
   		if ($eventF[$i] == 0) {
   			for ($j = 1; $j < $t; $j++) { echo "<td>&nbsp;</td>"; }
   			echo "<td align='center'><b>X</b></td>";
   			for ($j = $t + 1; $j < 8; $j ++) { echo "<td>&nbsp;</td>"; } 
   		} else {
   			$t = trim($t);
   			if ( $t != "0" && $t != "" ) {
   				$p = strrpos($t,":");
   				
   				$n = substr($t, 0, $p) . substr($t, ($p + 1));
   				if ( $n < 830 && $n >= 230  ) { $p = 6; }
   				elseif ( $n < 830 && $n >= 130 ) { $p = 5; }
   				elseif ( $n < 830 && $n >= 100 ) { $p = 4; }
   				elseif ( $n < 1030 ) { $p = 1; }
   				elseif ( $n < 1130 ) { $p = 2; }
   				elseif ( $n < 1230 ) { $p = 3; }
   				else { $p = 4; }
   				
   				for ($j = 1; $j < $p; $j++) { echo "<td>&nbsp;</td>"; }
   				echo "<td align='center'><b>$t</b></td>";
   				for ($j = $p + 1; $j < 7; $j ++) { echo "<td>&nbsp;</td>"; }
   				echo "</td><td align='center' width='59'><a href='cchange.php?event=".$i."&uid=".$tid."&pid=".$tpwd."'><b>Change</td>";
   			} else {
   				echo "</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></td><td align='center' width='59'><a href='cchange.php?event=".$i."&uid=".$tid."&pid=".$tpwd."'><b>Change</td>";
   			}
   		}
   		echo "</tr>\n";
   	}
   	?>
</table></div>
<br><br><p align="center"><a href='clogin.php'><big><strong><b>Log Out</b></strong></p></big>
</body>
</html> 

<?php mysql_close($link); ?>