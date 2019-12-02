<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
?>

<script type="text/javascript">
window.onload = function test(){
	var elems = document.getElementsByClassName("schedules");
    elems[0].style.color = "white";
};
</script>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/navDefault.php");
?>

<!------------------------WRITE YOUR UPDATES HERE------------------->
	
<h1>Competition Schedule (2014-15)</h1>
<hr>

<!-- <div class="twrap"><table class="scheduleMenu"><tr>
<th id = "rMLeft"><a href="/DivC/schedules/14-15.php">prev</a>
</th><th><a href="/DivC/schedules/">all schedules</a>	
</th><th id = "rMRight"><a href="/DivC/schedules/15-16.php">next</a>
</th></tr></table></div> -->

<div class="twrap"><table id="schedule">
  <tr>
  	<th class="scheduleHead">Tournaments / Results*</th>
  	<th class="scheduleHead">Date</th>
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2014_Sylvania-Northview.php">Sylvania-Northview</a></td>
    <td class="scheduleDate">December 12th-13th, 2014</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_Westlake.php">Westlake</a></td>
    <td class="scheduleDate">January 10th, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_Kenston.php">Kenston</a></td>
    <td class="scheduleDate">January 17th, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_MIT.php">MIT</a></td>
    <td class="scheduleDate">January 22nd-25th, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_Solon.php">Solon</a></td>
    <td class="scheduleDate">January 31st, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_WrightState.php">Wright State</a></td>
    <td class="scheduleDate">February 6th-8th, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_Mentor.php">Mentor</a></td>
    <td class="scheduleDate">February 14th, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_Regionals.php">Regional Tournament @ CWRU</a></td>
    <td class="scheduleDate">February 21st, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_WestLiberty-Salem.php">West Liberty-Salem</a></td>
    <td class="scheduleDate">March 6th-7th, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament"><a href="/DivC/results/2015_States.php">States Tournament @ OSU</a></td>
    <td class="scheduleDate">April 9th-11th, 2015</td>		
  </tr>
</table></div>


<p>&nbsp; &nbsp; &nbsp; &nbsp; *For results, click on the tournament name (assuming they have been posted)</p>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>