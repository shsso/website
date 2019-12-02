<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>



<!------------------------WRITE YOUR UPDATES HERE------------------->
	
<h1>Previous Teams</h1>
<hr>

<!--php from https://2buntu.com/articles/1301/php-script-to-dynamically-generate-links-to-the-files-present-in-current-directory/-->
<?php
$dir_open = opendir('.');
$a = array();
while(false !== ($filename = readdir($dir_open)))
    if (!in_array($filename, array('.', '..', 'index.php','officers','coaches')))
        $a[$filename] = "<h3 style=\"text-align:center\"><a href='./$filename'>"
        .str_replace('.php','', ucfirst($filename))
        ."</a></h3><hr>";
closedir($dir_open);
// lol have fun figuring this one out
uksort($a, function($n1, $n2) {
        $b = [is_numeric($n1[0]), is_numeric($n2[0])];
        return ($b[0] xor $b[1]) ? -2 * $b[0] + 1 : (($b[0] and $b[1]) ? -1 : 1)*strcmp($n1, $n2);
});
foreach ($a as $val) echo $val;
?>

<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>