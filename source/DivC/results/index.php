<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/top.php");
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/header.php");
?>
<h1>All Available Results</h1>
<hr>
<p>Listed in reverse alphabetical, not chronological, order. </p>
<ul style="margin-left: 2%">
<?php
$current_dir = opendir(".");
$links = array();

// push all files in current directory into array
while(false !== ($file = readdir($current_dir))) {
    array_push($links, $file);
}
closedir($current_dir);

// remove all files blacklisted in the following array
$links = array_diff($links, array(".", "..", "index.php", "ResultsGenerator.jar"));

// filter out all files containing the substring "_draft"
$links = array_filter($links, function ($file) {
    return strpos($file, "_draft") === false;
});

function comp_func($v1, $v2) {
    $c1 = mb_substr($v1, 0, 1);
    $c2 = mb_substr($v2, 0, 1);
    $type1 = ctype_digit($c1);
    $type2 = ctype_digit($c2);
    if ($type1 and $type2) {
        return strcmp($v2, $v1);
    } else if (!($type1 or type2)) {
        return strcmp($v1, $v2);
    } else {
        return strcmp($v2, $v1);
    }
}

// reverse sort to display first non-numeric files, then the most recent results first
usort($links, "comp_func");

// turn filename into link by wrapping it in a list tag, inserting it into a link, and uses a regex to format the filename into presentable text
$links = array_map(function ($file) {
    $new_name = preg_replace("/(?<![A-Z _-])(?=[A-Z])|_/", " ", substr($file, 0, -4));
    return "<li><a href='./$file'>" . $new_name . "</a></li>";
}, $links);
// display to page
foreach ($links as $link) {
    echo $link;
}
?>
</ul>
<?php
include("/home/users/web/b1097/ipg.solonsoadmin/public_html/DivC/template/bottom.php");
?>
