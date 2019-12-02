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
	
<h1>All Available Schedules</h1>
<hr>

<!--php from https://2buntu.com/articles/1301/php-script-to-dynamically-generate-links-to-the-files-present-in-current-directory/-->
<?php
$dir_open = opendir('.');
$a = array();


while(false !== ($filename = readdir($dir_open))){
    if($filename != "." && $filename != ".." && $filename != "index.php"){
        $link = "<a href='./$filename'> $filename </a><br />";
        array_push($a, $link);
    }
}

sort($a);

foreach ($a as $key => $val) {
    echo $val;
}

closedir($dir_open);
?>


</div>

<!-- SCROLL SNEAK JS (applies to all links on index page)-->
<script>
(function() {
    var sneaky = new ScrollSneak(location.hostname), links = document.getElementsByTagName('a'), i = 0, len = links.length;
    for (; i < len; i++) {
        links[i].onclick = sneaky.sneak;
    }
})();

</script>
<!-- END OF SCROLL SNEAK JS -->

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>