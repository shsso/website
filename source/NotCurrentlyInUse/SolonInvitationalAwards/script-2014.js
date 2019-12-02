var QueryString = function () {
  // This function is anonymous, is executed immediately and 
  // the return value is assigned to QueryString!
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    	// If first entry with this name
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = pair[1];
    	// If second entry with this name
    } else if (typeof query_string[pair[0]] === "string") {
      var arr = [ query_string[pair[0]], pair[1] ];
      query_string[pair[0]] = arr;
    	// If third or later entry with this name
    } else {
      query_string[pair[0]].push(pair[1]);
    }
  } 
    return query_string;
} ();

var events=[];
var teams=[];
var currentSlide=-1;
var numRankings=6;
var results;
var currentRanking=0;
var alreadyViewedEvents=[];
var theUrl="https://spreadsheets.google.com/feeds/cells/"+QueryString.spreadsheetKey+"/od6/public/values?alt=json-in-script&callback=dataLoaded";
var revealMode=(QueryString.reveal==="true");
//var decrypter = new Blowfish(encryptionKey);
var TRANSITION_SPEED=300;
var suffix=["st","nd","rd","th","th","th","th","th","th","th"];

function setup()
{
	var rawTeams = document.getElementById("teamList").innerHTML.split("\n");
	for(var i=1;i<rawTeams.length-1;i++)
	{
		var splitted = rawTeams[i].split(" ");
		teams[Number(splitted[0])]=splitted[1];
	}
	events = document.getElementById("eventList").innerHTML.split("\n");
	events.shift();
	events.pop();
	
	var menuText="";
	//menuText+="<p id='menuEvent-1' class='menuEvent'><a onclick='gotoEvent(-1)'>Title Screen</a></p>";
	for(var i=0;i<events.length;i++)
	{
		menuText+="<p id='menuEvent"+i+"' class='menuEvent'><a onclick='gotoEvent("+i+")'>"+events[i]+"</a></p>";
	}
	menuText+="";
	document.getElementById("menu").innerHTML=menuText;
	
	var rankingText="";
	for(var i=0;i<numRankings;i++)
	{
		rankingText+="<p class='rankingNumber'>"+(i+1)+"<sup>"+suffix[i]+"</sup>"+" <span id='ranking"+i+"' class='ranking'></span></p>";
	}
	document.getElementById("rankingOutput").innerHTML=rankingText;
	
	setInterval(refreshResults,1000);
	blankResults();
	refreshResults();
	
	renderSlide(-1);
	$(".ranking").hide();
	
	$("#slide").mousedown(function(event){
		nextStep(1);
	});
	$("body").keyup(function(event) {
		if(event.which==32 || event.which==39)
		{
			nextStep(1);
		}
		else if(event.which==37 || event.which==8)
		{
			nextStep(-1);
		}
		event.preventDefault();
		/*else
		{
			console.log(event.which);
		}*/
	});
	$(document).unbind('keydown').bind('keydown', function (event) {
    	var doPrevent = false;
    	if (event.keyCode === 8) {
	    var d = event.srcElement || event.target;
	    if ((d.tagName.toUpperCase() === 'INPUT' && (d.type.toUpperCase() === 'TEXT' || d.type.toUpperCase() === 'PASSWORD' || d.type.toUpperCase() === 'FILE')) 
	         || d.tagName.toUpperCase() === 'TEXTAREA') {
	        doPrevent = d.readOnly || d.disabled;
	    }
	    else {
	        doPrevent = true;
	    }
	}

    if (doPrevent) {
        event.preventDefault();
    }
});
}

function blankResults()
{
	var results=[];
	for(var i=1;i<=teams.length;i++)
	{
		var eventRes=[];
		for(var j=0;j<events.length;j++)
			eventRes[j]=undefined;
		results[i]=eventRes;
	}
	$("div").hide();
	return results;
}

var updateTime = new Date().getTime()+5000;
function retrieveResults()
{
	var scriptTag = document.createElement('SCRIPT');
	scriptTag.src = theUrl;
	 
	document.getElementsByTagName('HEAD')[0].appendChild(scriptTag);
	
	/*
	var results=[];
	for(var i=1;i<=teams.length && i<=;i++)
	{
		var eventRes=[];
		for(var j=0;j<events.length;j++)
			eventRes[j]=i;
		results[i]=eventRes;
	}
	return results;
	*/
}

function dataLoaded(data)
{
	$("div").show();
	var rows=Number(data.feed["gs$rowCount"]["$t"]);
	var cols=Number(data.feed["gs$colCount"]["$t"]);
	var temp=[];
	var teamNumsByRow=[];
	//for(var i=1;i<rows;i++)
	for(var i=0;i<data.feed.entry.length;i++)
	{
		var cell = data.feed.entry[i]["gs$cell"];
		var row = Number(cell.row);
		var col = Number(cell.col);
		var value = cell["$t"];//decrypter.decrypt(cell["$t"]);
		//console.log(cell["$t"]);
		if(row>=2)
		{
			if(col==1)
			{
				//if(!data.feed.entry[cols*i-1])
				if(!value)
					break;
				//var teamName=data.feed.entry[cols*i-1].content["$t"];
				var teamName = value;
				var firstSpace = teamName.indexOf(" ");
				var splitted=[];
				
				if(firstSpace==-1)
				{
					break;
				}
				else
				{
					splitted[0]=teamName.substr(0,firstSpace);
					splitted[1]=teamName.substr(firstSpace+1);
				}
				
				var teamNum=Number(splitted[0]);
				teams[teamNum]=splitted[1];
				teamNumsByRow[row]=teamNum;
			}
			else
			{
				//var teamNum=Number(splitted[0]);
				//teams[teamNum]=splitted[1];
				
				//var eventRes=[];
				//for(var j=0;j<events.length+1 && j<cols;j++)
				//{
				var teamNum=teamNumsByRow[row];
				
				if(!temp[teamNum])
				{
					temp[teamNum]=[];
				}
				
				//var tempJ=j;
				var tempJ=col-2;
				if(tempJ>=events.length)
				{
					tempJ--;
				}
				//eventRes[tempJ]=data.feed.entry[i*cols+j].content["$t"];
				temp[teamNum][tempJ]=Number(value);
				//}
				//temp[teamNum]=eventRes;
			}
		}
	}
	results=temp;
	renderSlide(currentSlide);
}

function gotoEvent(i)
{
	if(!isEventFinalized(i))
		return;

	$("#slide").fadeOut(TRANSITION_SPEED);
	$(".ranking").fadeOut(TRANSITION_SPEED);
	currentSlide=i;
	currentRanking=numRankings;
	setTimeout(function(){
		renderSlide(i);
		$("#slide").fadeIn(TRANSITION_SPEED);
	},TRANSITION_SPEED);

}

function refreshResults()
{
	retrieveResults();
}

function isEventFinalized(event)
{
	if(event==-1)
		return true;
	for(var i=1;i<=teams.length;i++)
	{
		if(results[i] && (results[i][event]===undefined || results[i][event]==="" || results[i][event]==="--" || isNaN(results[i][event]) || results[i][event]<=0))
		{
			return false;
		}
	}
	return true;
}

function renderSlide(eventNumber)
{	
	if(revealMode)
	{
		var output="";
		for(var evt=0;evt<events.length;evt++)
		{
			if(isEventFinalized(evt))
			{
				output+="<h2><a name='event"+i+"'>"+events[evt]+"</h2>";
				var rankings = [];
				for(var i=1;i<=teams.length;i++)
				{
					if(results[i] && results[i][evt]<=numRankings)
					{
						rankings[results[i][evt]-1] = teams[i]+" (Team #"+i+")";
					}
				}

				
				for(var i=numRankings-1;i>=0;i--)
				{
					output+="<p class='rankingP'>"+(i+1)+suffix[i]+": " + rankings[i]+"</p>";
				}
			}
		}
		if(output=="")
			output="No events are finalized yet.";
		document.getElementById("slide").innerHTML=output;
		document.getElementById("menu").innerHTML="";
	}
	else
	{
		alreadyViewedEvents[eventNumber]=true;

		document.getElementById("eventTitle").innerHTML=events[eventNumber];
		
		var numFinalized=0;
		var numRemaining=0;
		//$("#menuEvent-1").addClass("ready");
		for(var j=0;j<events.length;j++)
		{
			var isFinalized = isEventFinalized(j);
			if(isFinalized)
			{
				//$("#menuEvent"+j).show();
				$("#menuEvent"+j).addClass("ready");
				if(alreadyViewedEvents[j])
				{
					$("#menuEvent"+j).addClass("viewed");
				}
				numFinalized++;
			}
			else
			{
				//$("#menuEvent"+j).hide();
				$("#menuEvent"+j).removeClass("ready");
				if(j<events.length-1)
					numRemaining++;
			}
		}
		if(eventNumber==-1)
		{
			document.getElementById("eventTitle").innerHTML="Solon Science Olympiad Invitational Award Ceremony";
			var numRemainingText;
			if(numRemaining==0)
			{
				if($(".viewed").size()==$(".menuEvent").size())
					numRemainingText="Full results will be posted at tiny.cc/soloninvite";
				else
					numRemainingText="All events are finalized. Get ready for the awards!"
			}
			else
				numRemainingText="" + numRemaining + " more event" + ((numRemaining>1)?"s":"") + " to be finalized...";
			document.getElementById("noReally").innerHTML=numRemainingText;
			$(".rankingNumber").hide();
		
			return;
		}
		document.getElementById("noReally").innerHTML="";
		$(".rankingNumber").show();

		var rankings = [];
		for(var i=1;i<=teams.length;i++)
		{
			if(results[i] && results[i][eventNumber]<=numRankings)
			{
				rankings[results[i][eventNumber]-1] = teams[i]+" (Team #"+i+")";
			}
		}

		
		for(var i=0;i<numRankings;i++)
		{
			document.getElementById("ranking"+i).innerHTML=" - " + rankings[i];
		}
	
	}
}

function nextStep(direction)
{
	if(direction == -1 && currentRanking<numRankings)
	{
		$("#ranking"+currentRanking).fadeOut(500);
	}

	currentRanking-=direction;
	
	if(currentRanking<0 && direction==1)
	{
		do
		{
			currentSlide++;
			if(currentSlide==events.length)
			{
				currentSlide=-1;
				currentRanking=0;
			}
			else
			{
				currentRanking=numRankings;
			}
		}
		while(!isEventFinalized(currentSlide));
		$("#slide").fadeOut(TRANSITION_SPEED);
		$(".ranking").fadeOut(TRANSITION_SPEED);
		setTimeout(function(){
			renderSlide(currentSlide);
			
			$("#slide").fadeIn(TRANSITION_SPEED);
		},TRANSITION_SPEED);
	}
	else if(currentRanking>numRankings && direction==-1)
	{
		do
		{
			if(currentSlide<=0)
			{
				currentSlide=-1;
				currentRanking=0;
			}
			else
			{
				currentSlide--;
				currentRanking=numRankings;
			}
		}
		while(!isEventFinalized(currentSlide));
		renderSlide(currentSlide);
		$(".ranking").hide();
	}
	else if(currentRanking>0 && currentSlide==-1 && direction==-1)
	{
		currentRanking=0;
	}
	
	if(direction == 1 && currentRanking<numRankings && currentSlide!=-1)
	{
		$("#ranking"+currentRanking).fadeIn(500);
	}
}




//

var CLIENT_ID = '524897521788.apps.googleusercontent.com';
var SCOPES = 'https://www.googleapis.com/auth/drive';

/**
* Called when the client library is loaded to start the auth flow.
*/
function handleClientLoad() {
	window.setTimeout(checkAuth, 1);
}

/**
* Check if the current user has authorized the application.
*/
function checkAuth() {
	gapi.auth.authorize(
		{'client_id': CLIENT_ID, 'scope': SCOPES, 'immediate': true},
		handleAuthResult);
}

/**
* Called when authorization server replies.
*
* @param {Object} authResult Authorization result.
*/
function handleAuthResult(authResult) {
	var authButton = document.getElementById('authorizeButton');
	var filePicker = document.getElementById('filePicker');
	authButton.style.display = 'none';
	filePicker.style.display = 'none';
	if (authResult && !authResult.error) {
	  // Access token has been successfully retrieved, requests can be sent to the API.
	  filePicker.style.display = 'block';
	  filePicker.onchange = uploadFile;
	} else {
	  // No access token could be retrieved, show the button to start the authorization flow.
	  authButton.style.display = 'block';
	  authButton.onclick = function() {
		  gapi.auth.authorize(
			  {'client_id': CLIENT_ID, 'scope': SCOPES, 'immediate': false},
			  handleAuthResult);
	  };
	}
}

window.onload=setup;