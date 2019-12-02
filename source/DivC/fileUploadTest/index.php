<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>

<!------------------------WRITE YOUR UPDATES HERE------------------->
	
<h1>File Upload Test Directory</h1>
<hr>

<!--php from http://2buntu.com/articles/1301/php-script-to-dynamically-generate-links-to-the-files-present-in-current-directory/-->
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

<p>Important Note: Technically, as of now, anyone can upload any image to this directory, so Solon Science Olympiad is NOT responsible for any content in this directory. This page only exists as a test for possible future functionality.</p>

</div>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>