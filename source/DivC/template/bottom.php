<!-------------------------------- DO NOT WRITE ANYTHING BELOW HERE-------------->
</section>
</section>
<div id="push"></div>
</div>

<footer>
<!--	<h1 style="text-align: center"><a style="color:white" href="/DivC/invitational/2019.php">2019 Solon High School Invitational Information - Here</a></h1>
-->
	<div id="footer-links">
		<a href="/DivC/misc/devlog.php">Development Log</a><br>
		<a href="/DivC/contact-us.php">Contact Info</a><br>
		<a href="/DivC/misc/credits.php">Website Credits</a><br>
	</div>
</footer>




<script>

$(window).scroll(function(){
    $("#fixed-sidebar").css("top", Math.max(0, Math.max($("#list-nav").outerHeight(),600)+ 416 - $(this).scrollTop()));
    // modify this to include point where element is no longer following scroll window so that it doesn't go into
    // the footer
});

function toggleDisplay(elem) {
if(elem.style.display == "block") { elem.style.display = "none"; }
else { elem.style.display = "block"; }
$("#fixed-sidebar").css("top", Math.max(-80, Math.max($("#list-nav").outerHeight(),600)+ 416 - $(this).scrollTop()));
}

function HideContent(d) {
document.getElementById(d).style.display = "none";
}
function ShowContent(d) {
document.getElementById(d).style.display = "block";
}
function ReverseDisplay(d) {
if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; } 
else { document.getElementById(d).style.display = "block"; }
}
function ReverseDisplayS() {
if(document.getElementById("showmore").style.display == "none") { document.getElementById("showmore").style.display = "block"; }
else { document.getElementById("showmore").style.display = "none"; }
}

function ReverseDisplayA() {
if(document.getElementById("aboutus").style.display == "none") { document.getElementById("aboutus").style.display = "block"; }
else { document.getElementById("aboutus").style.display = "none"; }
}

function ReverseMultipleDisplays(className, defaultDisplay) {
	var x = document.getElementsByClassName(className);
	var i;
	
	if(x[0].style.display == "none"){
		for(i=0; i<x.length; i++){
			x[i].style.display = defaultDisplay;
		}
	}
	
	else{
		for(i=0; i<x.length; i++){
			x[i].style.display = "none";
		}
	}
}

function toggleNav()
{	
  if(document.getElementById("vertical").style.display=="block"){
   document.getElementById("vertical").style.display="none";
   document.getElementById("more").innerHTML = "More ↓";
   }
  else{
   document.getElementById("vertical").style.display="block";
   document.getElementById("more").innerHTML = "Less ↑";
   } 
}


</script>

<!------For slideshows-------->
<script src="/DivC/scripts/jquery.cycle2.min.js"></script>
<script src="/DivC/scripts/jquery.cycle2.carousel.min.js"></script>
<script src="/DivC/scripts/jquery.cycle2.center.min.js"></script>
<script src="/DivC/scripts/jquery.cycle2.swipe.min.js"></script>

<!-- SCROLL SNEAK JS: you can change `location.hostname` to any unique string or leave it as is -->
<script>
(function() {
    var sneaky = new ScrollSneak(location.hostname)
    $("#horizontal a").each(function(){ $(this).click(sneaky.sneak); });
})();
</script>
<!-- END OF SCROLL SNEAK JS -->

</body> 
</html>