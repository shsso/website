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
	
<h1>Competition Schedule (2015-16)</h1>
<hr>

<!-- <div class="twrap"><table class="scheduleMenu"><tr>
<th id = "rMLeft"><a href="/DivC/schedules/14-15.php">prev</a>
</th><th><a href="/DivC/schedules/">all schedules</a>
</th><th id = "rMRight"><a href="/DivC/schedules/15-16.php">next</a>
</th></tr></table></div> -->

<div class="twrap"><table id="schedule">
  <tr>
  	<th class="scheduleHead">Invitational / Tournament</th>
  	<th class="scheduleHead">Date</th>
  </tr>
  <tr>
    <td class="scheTournament">Sylvania-Northview</td>
    <td class="scheduleDate">December 4th-5th, 2015</td>		
  </tr>
  <tr>
    <td class="scheTournament">Westlake</td>
    <td class="scheduleDate">January 9th, 2016</td>		
  </tr>
  <tr>
    <td class="scheTournament">Kenston</td>
    <td class="scheduleDate">January 16th, 2016</td>		
  </tr>
  <tr>
    <td class="scheTournament">MIT</td>
    <td class="scheduleDate">January 21st-24th, 2016</td>		
  </tr>
  <tr>
    <td class="scheTournament">Solon</td>
    <td class="scheduleDate">January 30th, 2016</td>		
  </tr>
  <tr>
    <td class="scheTournament">Wright State</td>
    <td class="scheduleDate">February 5th-6th, 2016</td>		
  </tr>
  <tr>
    <td class="scheTournament">Mentor</td>
    <td class="scheduleDate">February 13th, 2016</td>		
  </tr>
  <tr>
    <td class="scheTournament">Regional Tournament @ CWRU</td>
    <td class="scheduleDate">February 20th, 2016</td>		
  </tr>
  <tr>
    <td class="scheTournament">West Liberty-Salem</td>
    <td class="scheduleDate">March 4th-5th, 2016</td>		
  </tr>
</table></div>

<br>
<p><a href="/DivC/calendar.php">Google Calendar with more details here</a></p>
<p><a href="/DivC/schedules/">Previous Schedules</a></p>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>