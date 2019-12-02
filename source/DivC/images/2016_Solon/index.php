<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
?>

<script type="text/javascript">
window.onload = function test(){
	var elems = document.getElementsByClassName("results");
    elems[0].style.color = "white";
};
</script>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/navResults.php");
?>

<!------------------------WRITE YOUR UPDATES HERE------------------->
	
<h1>Pictures from Solon Invitational 2016</h1>
<hr>


<!--php from http://2buntu.com/articles/1301/php-script-to-dynamically-generate-links-to-the-files-present-in-current-directory/-->
<?php
$dir_open = opendir('.');
$a = array();


while(false !== ($filename = readdir($dir_open))){
    if($filename != "." && $filename != ".." && $filename != "index.php"){
        $link = "<a href='./$filename'><img class='small' src='./$filename'></a>";
        array_push($a, $link);
    }
}

sort($a);

foreach ($a as $key => $val) {
    echo $val;
}

closedir($dir_open);
?>


<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>