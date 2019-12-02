<?php
  session_start();
  //include("valiableSet.inc");
  $periodTime[1] = "8:30~9:20";
	$periodTime[2] = "9:30~10:20";
	$periodTime[3] = "10:30~11:20";
	$periodTime[4] = "11:30~12:20";
	$periodTime[5] = "12:30~1:20";
	$periodTime[6] = "1:30~2:20";
	$periodTime[7] = "2:30~3:20";
	
	$timePeriod["8:30~9:20"] = 1;  
	$timePeriod["9:30~10:20"] = 2; 
	$timePeriod["10:30~11:20"] = 3;
	$timePeriod["11:30~12:20"] = 4;
	$timePeriod["12:30~1:20"] = 5; 
	$timePeriod["1:30~2:20"] = 6;  
	$timePeriod["2:30~3:20"] = 7;  
	
	$totalEvent = 9;
	$eventName[0] =   "Scrambler";                
	$eventName[1] =   "Wright Stuff";              
	$eventName[2] =   "Bungee Drop";
	$eventName[3] =   "Air Trajectory";
	$eventName[4] =   "Mission Possible";
	$eventName[5] =   "Bridge Building";
  $eventName[6] =   "Trial 1";
  $eventName[7] =   "Trial 2";
  $eventName[8] =   "Trial 3";
	
	$location[0] = "Old Gym";
	$location[1] = "New Gym";
	$location[2] = "Auditorium Atrium";
	$location[3] = "Old Gym";
	$location[4] = "Commons";
	$location[5] = "Room 150";
	$location[6] = "Room 209A";
	$location[7] = "Room 209B";
	$location[8] = "TBD";
	
	//event flag: 1 for selective schedule and 0 for fixed	
	$eventF[0] = 1;
	$eventF[1] = 1;
	$eventF[2] = 1;
	$eventF[3] = 1; 
	$eventF[4] = 1; 
	$eventF[5] = 1;
	$eventF[6] = 1;
	$eventF[7] = 1;
	$eventF[8] = 1;
	
	
	$UID = "ssssadmin";
	$pwd = "!QAZ2wsx";
	$address = "solonsoadmin.ipagemysql.com";
	
	$dbName = "solon2015";
	$dbTeamTable[0] = "DivBTeams";
	$dbTeamTable[1] = "DivCTeams";
	$dbTimeTable[0] = "DivBTime";
	$dbTimeTable[1] = "DivCTime";

	
	if(isset($_POST['username'])) 
  		$_SESSION['UserID'] = strtoupper($_POST['username']);
  	if(isset($_POST['password'])) 
  		$_SESSION['UserPaswd'] = $_POST['password'];
  		
  //echo "UserID =" . $_SESSION['UserID'] . "<br />";
  //echo "UserPaswd =" . $_SESSION['UserPaswd'] . "<br />";
  //echo "address =" . $address . "<br />";
  //echo "UID =" . $UID . "<br />";
  //echo "pwd =" . $pwd . "<br />";
  //echo "dbNameB =" . $dbNameB . "<br />";
  //echo "dbTeamTableB =" . $dbTeamTableB . "<br />";
  
  
  $link = mysql_connect($address, $UID, $pwd);
  //echo $link . "<br />";
  if (!$link) { 
    echo 'Could not connect to the MySQL database.  Please try late. <p></p>';
    session_destroy(); 
    die('MySQL Error: ' . mysql_error()); 
  }
  mysql_select_db($dbName, $link);
  $tid = $_SESSION['UserID'];
  $tpwd = $_SESSION['UserPaswd'];
  $qstr = "SELECT * FROM $dbTeamTable[1] WHERE UserID ='$tid' and UserPaswd ='$tpwd'";
  //echo $qstr . "<br />";
  $result = mysql_query($qstr);
  //echo $result . "<br />" . mysql_num_rows($result) . "<br />";
  if ( mysql_num_rows($result) != 1 ) {
  	echo 'Fail to login.  Please check the team ID (B## or C##) and the password.<p></p>';
  	session_destroy();
  	echo '<p><big><strong><a href="clogin.php">Try again.</strong></p></big>';
  	mysql_close($link);
  	die();
  } 
  
  for ($i = 0; $i < $totalEvent; $i++) {
  	$TE[$i] = mysql_result($result,0,$eventName[$i]);
  	//echo $eventName[$i] . " --> " . $TE[$i] . "<br>\n";
  	//if ( $eventF[$i] == 1 ) {
  	//	$_SESSION[$eventName[$i]] = $TE[$i];
  	//	
  	//}
  }
  
?>
<html>
<body>

<h2 align="center"><big><strong>Science Olympiad</strong></p></big></h2>
<p align="center"><big><strong>2015 SOLON INVITATIONAL DIVISION C WALK-IN EVENT SCHEDULE</strong></p></big>
<p align="center"><big><strong>Saturday, Jan. 31, 2015</strong></p></big>
<br>
<!-- 
<h3 align="center"><big><strong>Team <?php echo $_SESSION['UserID'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . mysql_result($result,0,"Team"); ?>&nbsp;&nbsp;&nbsp;&nbsp;Base Room: <?php echo mysql_result($result,0,"Base Room") ; ?></strong></p></big></h3>
-->
<h3 align="center"><big><strong>Team <?php echo $_SESSION['UserID'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . mysql_result($result,0,"Team"); ?></strong></p></big></h3>
<br>

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
<div align="center"><center><table border="4">
   <tr>
		<td align="center" width="150"><b>Event</td>
		<td align="center" width="100"><b>Location</td>
		<td align="center" width="100"><b>8:30~9:20</td>
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
   			for ($j = $t + 1; $j < 9; $j ++) { echo "<td>&nbsp;</td>"; } 
   		} else {
   			$t = trim($t);
   			if ( $t != "0" && $t != "" ) {
   				$p = strrpos($t,":");
   				
   				$n = substr($t, 0, $p) . substr($t, ($p + 1));
   				if ( $n < 830 && $n >= 230  ) { $p = 7; }
   				elseif ( $n < 830 && $n >= 130 ) { $p = 6; }
   				elseif ( $n < 830 && $n >= 100 ) { $p = 5; }
   				elseif ( $n < 930 ) { $p = 1; }
   				elseif ( $n < 1030 ) { $p = 2; }
   				elseif ( $n < 1130 ) { $p = 3; }
   				elseif ( $n < 1230 ) { $p = 4; }
   				else { $p = 5; }
   				
   				for ($j = 1; $j < $p; $j++) { echo "<td>&nbsp;</td>"; }
   				echo "<td align='center'><b>$t</b></td>";
   				for ($j = $p + 1; $j < 8; $j ++) { echo "<td>&nbsp;</td>"; }
   				echo "</td><td align='center' width='59'><a href='cchange.php?event=" . $i . "'><b>Change</td>";
   			} else {
   				echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></td><td align='center' width='59'><a href='cchange.php?event=" . $i . "'><b>Change</td>";
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