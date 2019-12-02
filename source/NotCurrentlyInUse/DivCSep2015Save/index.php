<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
?>

<script type="text/javascript">
window.onload = function test(){
	var elems = document.getElementsByClassName("misclinks");
    elems[0].style.backgroundPosition = "left -44px";
};
</script>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/navDefault.php");
?>

<!------------------------WRITE YOUR UPDATES HERE------------------->
<h2>Everything from an Older Version of the Current Website</h2>
<p>The links below lead to an older version of the site (but not THE old version).
The information in these links/files is in the process of being incorporated into the new 
organization system. In the meanwhile, feel free to explore! If you 
ever get lost, simply change the url to end in /DivCSep2015Save/ to return to this page
and regain access to the main site. Happy exploring and dead links ahoy!</p>

<p>P.S. The homepage of older site version is "index.html", while this page is "index.php"</p>

<!--php from http://2buntu.com/articles/1301/php-script-to-dynamically-generate-links-to-the-files-present-in-current-directory/-->
<?php
$dir_open = opendir('.');

while(false !== ($filename = readdir($dir_open))){
    if($filename != "." && $filename != ".." && $filename != "index.php"){
        $link = "<a href='./$filename'> $filename </a><br />";
        echo $link;
    }
}

closedir($dir_open);
?>

<p>NOTE: Some of the pages (aboutus, alumni, calendar, sponsers, download) are not originals but rather from about a week after the save, inserted here to prevent endless 404s that mess up the stats. As such, you may notice their nav bars are a bit different, and you'll have to nagivated through home first. Also, some pages above aren't even linked to from anywhere but here, as far as I know.</p>


</div>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>