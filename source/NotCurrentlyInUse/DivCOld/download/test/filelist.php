<?php
  session_start();
	if(isset($_POST['username'])) 
  		$_SESSION['UserID'] = strtoupper($_POST['username']);
  	if(isset($_POST['password'])) 
  		$_SESSION['UserPaswd'] = $_POST['password'];
  		
  $tid = $_SESSION['UserID'];
  $tpwd = $_SESSION['UserPaswd'];

  if ( $tid != "COMETS" || $tpwd != "S0l0n1t1d" ) {
  	echo 'Fail to login.  Please check the user ID and the password.<p></p>';
  	session_destroy();
  	echo '<p><big><strong><a href="login.php">Try again.</strong></p></big>';
  	mysql_close($link);
  	die();
  } 
  
?>
<html>
<body>

<h2 align="center"><big><strong>Solon Science Olympiad Div C</strong></p></big></h2>
<br>
<h3 align="center"><big><strong>File Download</strong></p></big></h3>
<br>


<div align="center"><center><table border="4">
   <tr>
		<td align="center" width="150"><b>File</td>
		<td align="center" width="100"><b>Size</td>
   </tr>
   
   <?php 
      foreach (glob("*") as $filename) {
   		$p = strrpos($filename,".");
   		if ( $p === false) {
   			echo "<tr><td><a href='./" . $filename . "/filelist.php' target='_blank'><b>./" . $filename. "/</b></td><td align='center'>Subdirectory</td></tr>\n";
   		} else {
   			$s = substr($filename, ($p + 1));
			if ( $s != "php" ) {			
   				echo "<tr><td><a href='" . $filename . "' target='_blank'><b>" . $filename. "</b></td><td align='right'>" . filesize($filename) . "</td></tr>\n";
   			}
   		}
   	}
   	?>
</table></div>
