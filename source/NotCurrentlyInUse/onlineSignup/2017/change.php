<?
session_start();
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

	
	if(isset($_GET['event'])) {
		$changeEvent = $_GET['event'];
		$changeEventName = $eventName[$changeEvent];
		//$_SESSION['changeEventName'] = $changeEventName;
	} else {
		session_destroy(); 
		die("Error: No Change Event.<br><br><a href='login.php'>Please Log In to Solon Science Olympiad Registration.");
	}
//echo "address =" . $address . "<br />";
//echo "UID =" . $UID . "<br />";
//echo "pwd =" . $pwd . "<br />";
//echo "dbNameB =" . $dbName . "<br />";
//echo "dbTeamTableB =" . $dbTeamTable[0] . "<br />";
	
//echo $changeEvent . "--" . $changeEventName . "--" . $eventName[$changeEvent] . "--" . $_SESSION['changeEventName'] . "--" . $_SESSION[$eventName[$changeEvent]] . "<br />";
	
	$link = mysql_connect($address, $UID, $pwd);
  	//echo $link . "<br />";
  	if (!$link) { 
  	  echo 'Could not connect to the MySQL database.  Please try late. <p></p>';
   	 session_destroy(); 
   	 die('MySQL Error: ' . mysql_error()); 
  	}
  	mysql_select_db($dbName, $link);
  	
  	$tid = $_GET['uid'];
//echo "uid =" . $tid . "<br />";
  	$tpwd = $_GET['pid'];
//echo "wd =" . $tpwd . "<br />";  	
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
    
    $current = mysql_result($result,0,$changeEventName);
//echo "current=$current<br>\n";

  	$qstr = "SELECT * FROM $dbTimeTable[0] WHERE Event ='$changeEventName'";
  	$result1 = mysql_query($qstr);
    //echo $result . "<br />";
    if ( mysql_num_rows($result1) != 1 ) {
    	echo 'Fail to login.  Please check the team ID (B## or C##) and the password.<p></p>';
    	session_destroy();
    	echo '<p><big><strong><a href="login.php">Try again.</strong></p></big>';
    	mysql_close($link);
    	die();
    } 
    
    if ( $current == "" || $current == "0" ) {
    	$current = "&nbsp;";
    }
    
    $openCount = 0;
    $previous = "";

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
	
	$action = "update.php?uid=" . $tid . "&pid=" . $tpwd . "&evn=" . $changeEventName
    
?>
<html>
<body>

<h2 align="center"><big><strong>Science Olympiad</strong></p></big></h2>
<p align="center"><big><strong>2017 SOLON INVITATIONAL DIVISION B SCHEDULE</strong></p></big>
<p align="center"><big><strong>Saturday, Feb. 4, 2017</strong></p></big>
<br>
<h3 align="center"><big><strong>Team <?php echo $tid . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . mysql_result($result,0,"Team"); ?></strong></p></big></h3>
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
<p align="center"><a href='<?php echo "display.php?uid=".$tid."&pid=".$tpwd; ?>'><big><strong><b>Go Back</b></strong></p></big>
</body></html>
<?php   	mysql_close($link); ?>


