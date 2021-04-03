<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
error_reporting(0);
echo "<ul class=\"pagination\">";
  
// The button for the first page
if($page>1){
    echo "<li><a href='{$page_url}' title='Go back to the first page.'>";
        echo "First Page";
    echo "</a></li>";
}
  
// Counts all users in the database to calculate the total pages
$total_pages = ceil($total_rows / $records_per_page);
  
// The range of links to show
$range = 2;
  
// Display links to 'range of pages' around 'current page'
$initial_num = $page - $range;
$condition_limit_num = ($page + $range)  + 1;
  
for ($x=$initial_num; $x<$condition_limit_num; $x++) {
  
    // be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
    if (($x > 0) && ($x <= $total_pages)) {
  
        // current page
        if ($x == $page) {
            echo "<li class='active'><a href=\"#\">$x <span class=\"sr-only\">(current)</span></a></li>";
        }
  
        // not current page
        else {
            echo "<li><a href='{$page_url}page=$x'>$x</a></li>";
        }
    }
}
  
// The button for the last page
if($page<$total_pages){
    echo "<li><a href='" .$page_url . "page={$total_pages}' title='Last page is {$total_pages}.'>";
        echo "Last Page";
    echo "</a></li>";
}
  
echo "</ul>";
?>