<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<!------------------------WRITE YOUR UPDATES HERE------------------->
	
<h1>News Archives by Season</h1>
<hr>

<div class="archive">
<!--php from https://2buntu.com/articles/1301/php-script-to-dynamically-generate-links-to-the-files-present-in-current-directory/-->
<?php
$dir_open = opendir('.');
$a = array();


while(false !== ($filename = readdir($dir_open))){
    if($filename != "." && $filename != ".." && $filename != "index.php"){
        $link = "<h3 style=\"text-align:center\"><a href='./$filename'>";
        $link .= str_replace('.php','', $filename);
        $link .= "</a></h3><hr>";
        array_push($a, $link);
    }
}

rsort($a);

foreach ($a as $key => $val) {
    echo $val;
}

closedir($dir_open);
?>

</div>

<!-- SCROLL SNEAK JS (applies to all links on index page)-->
<script>
(function() {
    var sneaky = new ScrollSneak(location.hostname);
    $("a").each(function(i){ $(this).click(sneaky.sneak) })
})();

</script>
<!-- END OF SCROLL SNEAK JS -->

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>