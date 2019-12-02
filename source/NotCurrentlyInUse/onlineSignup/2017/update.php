<?php
  session_start();
  //include("valiableSet.inc");

  $periodTime[1] = "9:00~9:50";
	$periodTime[2] = "10:000~10:50";
	$periodTime[3] = "11:00~11:50";
	$periodTime[4] = "12:00~12:50";
	$periodTime[5] = "1:00~1:50";
	$periodTime[6] = "2:00~2:50";
	$periodTime[0] = "---------";
	
	$timePeriod["9:00~9:50"] = 1;  
	$timePeriod["10:000~10:50"] = 2; 
	$timePeriod["11:00~11:50"] = 3;
	$timePeriod["12:00~12:50"] = 4;
	$timePeriod["1:00~1:50"] = 5; 
	$timePeriod["2:00~2:50"] = 6;   
	
	$totalEvent = 7;

	$eventName[0] =   "Hovercraft";            
	$eventName[1] =   "Bottle Rockets";          
	$eventName[2] =   "Towers";
	$eventName[3] =   "Wright Stuff";
	$eventName[4] =   "Mission Possible";
	$eventName[5] =   "Scrambler";
	$eventName[6] =   "Wind Power";
       
	
	$location[0] = "Parkside Gym";
	$location[1] = "Football Field";
	$location[2] = "Lecture Hall";
	$location[3] = "MS Gym";
	$location[4] = "Parkside Gym";
	$location[5] = "SMS Gym";
	$location[6] = "Room 216";
	$location[7] = "";
	
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
    $tT = 49;  
	
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
  	$qstr = "SELECT * FROM $dbTeamTable[0] WHERE UserID ='$tid' and UserPaswd ='$tpwd'";
  	
  	$result = mysql_query($qstr);
    //echo $result . "<br />";
    if ( mysql_num_rows($result) != 1 ) {
    	echo 'Fail to login.  Please check the team ID (B## or C##) and the password.<p></p>';
    	session_destroy();
    	echo '<p><big><strong><a href="login.php">Try again.</strong></p></big>';
    	mysql_close($link);
    	die();
    } 
    
    $ctm = "&nbsp;";
    $ctm = mysql_result($result,0,$changeEventName);
 	
  	$qstr = "SELECT * FROM $dbTimeTable[0] WHERE Event ='$changeEventName'";
  	$result1 = mysql_query($qstr);
    //echo $result . "<br />";
    if ( mysql_num_rows($result1) != 1 ) {
    	echo 'MySQL Error: ' . mysql_error() . '<br>';
    	session_destroy();
    	echo '<p><big><strong><a href="login.php">Try again.</strong></p></big>';
    	mysql_close($link);
    	die();
    } 
    
    $cFieldName="";
    $nFieldName="";
    
//    if ( $changeEventName == "Trajectory" ) {
//    	$tT = 57;
//    } else {
//    	$tT = 51;
//    }

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
    	$updateTime = "UPDATE $dbTimeTable[0] SET $deleteCurrent $nFieldName = '$tid' WHERE Event ='$changeEventName'";
		if ( !mysql_query($updateTime) ) {
			$msg = "ERROR - unable to save the new time!<br>SQL ERROR: ".mysql_errno().".  ".mysql_error()."<BR><BR>";
		} else {
			$updateTeam = "UPDATE $dbTeamTable[0] SET `$changeEventName` = '$newTime' WHERE UserID ='$tid' and UserPaswd ='$tpwd'";
			if ( !mysql_query($updateTeam) ) {
				$msg = "ERROR - unable to save the team recoder!<br>SQL ERROR: ".mysql_errno().".  ".mysql_error()."<BR><BR>";
			}
		}
	}
	
	if ( $msg == "" ) {
		$msg = "The time for $changeEventName is successfully updated.";
	}
	
	$qstr = "SELECT * FROM $dbTeamTable[0] WHERE UserID ='$tid' and UserPaswd ='$tpwd'";
  	
  	$result = mysql_query($qstr);
  	
  	for ($i = 0; $i < $totalEvent; $i++) {
  		$TE[$i] = mysql_result($result,0,$eventName[$i]);
  	}
?>
<html>
<body>

<h2 align="center"><big><strong>Science Olympiad</strong></p></big></h2>
<p align="center"><big><strong>2017 SOLON INVITATIONAL DIVISION B WALK-IN EVENT SCHEDULE</strong></p></big>
<p align="center"><big><strong>Saturday, Feb. 4, 2017</strong></p></big>
<br>
<h3 align="center"><big><strong>Team <?php echo $tid . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . mysql_result($result,0,"Team"); ?></strong></p></big></h3>
<br>
<p align="center"><big><strong><?php echo $msg; ?></strong></p></big>
<br>
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
		<td align="center" width="100"><b>9:000~9:50</td>
		<td align="center" width="100"><b>10:00~10:50</td>
		<td align="center" width="100"><b>11:00~11:50</td>
		<td align="center" width="100"><b>12:00~12:50</td>
		<td align="center" width="100"><b>1:00~1:50</td>
		<td align="center" width="100"><b>2:00~2:50</td>
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
   				if ( $n < 830 && $n >= 130  ) { $p = 6; }
   				elseif ( $n < 830 && $n >= 100 ) { $p = 5; }
   				elseif ( $n < 930 ) { $p = 1; }
   				elseif ( $n < 1030 ) { $p = 2; }
   				elseif ( $n < 1130 ) { $p = 3; }
   				elseif ( $n < 1230 ) { $p = 4; }
   				else { $p = 5; }
   				
   				for ($j = 1; $j < $p; $j++) { echo "<td>&nbsp;</td>"; }
   				echo "<td align='center'><b>$t</b></td>";
   				for ($j = $p + 1; $j < 7; $j ++) { echo "<td>&nbsp;</td>"; }
   				echo "</td><td align='center' width='59'><a href='change.php?event=".$i."&uid=".$tid."&pid=".$tpwd."'><b>Change</td>";
   			} else {
   				echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></td><td align='center' width='59'><a href='change.php?event=".$i."&uid=".$tid."&pid=".$tpwd."'><b>Change</td>";
   			}
   		}
   		echo "</tr>\n";
   	}
   	?>
</table></div>
<br><br><p align="center"><a href='login.php'><big><strong><b>Log Out</b></strong></p></big>
</body>
</html> 

<?php mysql_close($link); ?>


