<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
?>

<link rel='stylesheet' href='/DivC/calendar/fullcalendar.css' />
<script src='lib/moment.min.js'></script>
<script src='fullcalendar.js'></script>
<script type='text/javascript' src='gcal.js'></script>
<script type='text/javascript'>

$(document).ready(function() {
    $('#calendar').fullCalendar({
    	height: "auto",
    	eventBackgroundColor: '#88ACBB',
    	eventBorderColor: '#577F91',
    	eventTextColor: '#FFFFFF',
    	
    	header: {
			left: ' prev today next',
			center: 'title',
			right: 'listSeason listMonth month '
		},
		
		views: {
			listMonth: { buttonText: 'list month' },
			listSeason: {
	            type: 'list',
	            duration: { months: 9 },
	            buttonText: 'list season'
	       },
		},
    	
        googleCalendarApiKey: 'AIzaSyBLDfb4k9dqFxr2RUNgBWFhY11sO0ybIio',
        events: {
            googleCalendarId: 'solonscienceolympiad@gmail.com'
        }
    });
});

</script>
<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<!-- Sync the new and old calendar infos -->
<script>
    $(function() { $('#calendar-info').load('/DivC/calendar.php #calendar-info'); });
</script>

<!------------------------CALENDAR IS HERE------------------->

<div id='calendar' style="overflow:hidden"></div>
<div id='calendar-info'></div>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>