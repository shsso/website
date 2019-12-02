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

var numEvents=26;
var events=[];
var teams=[];
var teamSchools=[];
var teamLength=0;
var currentSlide=-1;
var numRankings=8;
var results;
var currentRanking=0;
var alreadyViewedEvents=[];
//var theUrl="https://spreadsheets.google.com/feeds/cells/"+QueryString.spreadsheetKey+"/od6/public/values?alt=json-in-script&callback=dataLoaded";
var theUrl="https://spreadsheets.google.com/feeds/cells/"+QueryString.spreadsheetKey+"/1/public/values?alt=json-in-script&callback=dataLoaded";
var revealMode=(QueryString.reveal==="true");
//var decrypter = new Blowfish(encryptionKey);
var TRANSITION_SPEED=300;
var suffix=["st","nd","rd","th","th","th","th","th","th","th"];
var TEAM_ELIMINATED=1000; //if you have two teams from the same school, one gets this ranking
var specialEventInfo=[];
var additionalEventInfo=[];
specialEventInfo[25]={removeDuplicateSchools:true,additionalInfo:{offset:-2,text:": $"}};

function setup()
{
	//var rawTeams = document.getElementById("teamList").innerHTML.split("\n");
	//for(var i=1;i<rawTeams.length-1;i++)
	//{
	//	var splitted = rawTeams[i].split(" ");
	//	teams[Number(splitted[0])]=splitted[1];
	//}
	events = document.getElementById("eventList").innerHTML.split("\n");
	events.shift();
	events.pop();
	
	var menuText="";
	//menuText+="<p id='menuEvent-1' class='menuEvent'><a onclick='gotoEvent(-1)'>Title Screen</a></p>";
	for(var i=0;i<events.length;i++)
	{
		menuText+="<p id='menuEvent"+i+"' class='menuEvent'><a onclick='gotoEvent("+i+")' id='eventName"+i+"'>"+events[i]+"</a></p>";
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
	
    //just have patience, wait for first load
	//renderSlide(-1);
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

function endsWith(str,ending)
{
    return str.length>=ending.length && str.substr(str.length-ending.length)==ending;
}

function blankResults()
{
	var results=[];
	for(var i=1;i<=teamLength;i++)
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
        //if(!cell)
        //    continue;
		var row = Number(cell.row);
		var col = Number(cell.col);
		var value = cell["$t"];//decrypter.decrypt(cell["$t"]);
		//console.log(cell["$t"]);
        if(row==1 && col-2<numEvents-1)
        {
            events[col-2]=value;
            var el=document.getElementById("eventName"+(col-2));
            if(el)
            {
                el.innerText=value;
            }
        }
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
                teamLength=Math.max(teamNum,teamLength);

                //Record the school associated with the team
                if(endsWith(splitted[1]," A") || endsWith(splitted[1]," B"))
                {
                    teamSchools[teamNum]=splitted[1].substring(0,splitted[1].length-2);
                }
                else
                {
                    teamSchools[teamNum]=splitted[1];
                }
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
				
				//This is sort of hacky, the point totals will get overwritten by the team rankings since those come later
				var tempJ=col-2;
				if(tempJ>=events.length)
				{
					tempJ--;
				}
                
                //likewise, relies on the overwriting effect
                if(specialEventInfo[tempJ])
                {
                    var additional=specialEventInfo[tempJ].additionalInfo;
                    if(!additionalEventInfo[tempJ])
                    {
                        additionalEventInfo[tempJ]=[];
                    }
                    if(additional && tempJ==col+additional.offset) //check that we're actually looking at point totals, not team rankings
                    {
                        additionalEventInfo[tempJ][teamNum]=Number(value);
                    }
                }
                
				//eventRes[tempJ]=data.feed.entry[i*cols+j].content["$t"];
				temp[teamNum][tempJ]=Number(value);
				//}
				//temp[teamNum]=eventRes;
			}
		}
	}
    fixSchoolDuplicates(temp);
	results=temp;
	renderSlide(currentSlide);
}
function fixSchoolDuplicates(temp)
{
    for(var event=0;event<specialEventInfo.length;event++)
    {
        if(specialEventInfo[event] && specialEventInfo[event].removeDuplicateSchools===true)
        {
            for(var team=1;team<=teamLength;team++)
            {
                var otherTeam = 0;
                do
                {
                    otherTeam = teamSchools.indexOf(teamSchools[team],otherTeam+1);
                    if(otherTeam!=team && otherTeam!=-1 && temp[otherTeam][event]>=temp[team][event])
                    {
                        var oldVal=temp[otherTeam][event];
                        temp[otherTeam][event]=TEAM_ELIMINATED;
                        reduceTeamPlaces(event,oldVal+1,temp);
                    }
                }
                while(otherTeam!=-1);
            }
        }
    }
}
function reduceTeamPlaces(event,minRanking,temp)
{
    //slide down all the other teams
    for(var team=1;team<=teamLength;team++)
    {
        if(temp[team][event]!=undefined && temp[team][event]>=minRanking)
        {
            temp[team][event]--;
        }
    }
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
	for(var i=1;i<=teamLength;i++)
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
				output+="<h2><a name='event"+evt+"'>"+events[evt]+"</h2>";
				var rankings = [];
				for(var i=1;i<=teamLength;i++)
				{
					if(results[i] && results[i][evt]<=numRankings)
					{
						rankings[results[i][evt]-1] = getRankText(i,evt);
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
				//if($(".viewed").size()==$(".menuEvent").size())
				//	numRemainingText="Full results will be posted at tiny.cc/soloninvite";
				//else
				numRemainingText="All events are finalized. Get ready for the awards!";
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
		for(var i=1;i<=teamLength;i++)
		{
			if(results[i] && results[i][eventNumber]<=numRankings)
			{
                rankings[results[i][eventNumber]-1] = " - " + getRankText(i,eventNumber);
			}
		}

		
		for(var i=0;i<numRankings;i++)
		{
			document.getElementById("ranking"+i).innerHTML=rankings[i];
		}
	
	}
}

function getRankText(i,eventNumber)
{
    var text = teams[i]+" (#"+i+")";
    if(specialEventInfo[eventNumber] && specialEventInfo[eventNumber].additionalInfo)
    {
        text+=specialEventInfo[eventNumber].additionalInfo.text.replace("$",additionalEventInfo[eventNumber][i]);
    }
    return text;
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


window.onload=setup;