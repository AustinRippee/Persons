<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
error_reporting(0);
?>
<?php
// core.php holds pagination variables
include_once 'config/core.php';
  
// include database and object files
include_once '../database/database.php';
include_once 'objects/persons.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->connect();

$person = new Person($db);
  
// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';
  
$page_title = "You searched for \"{$search_term}\"";
include_once "layouts/layout_header.php";
  
// creates the button to go back to the main user list
echo "<div class='right-button-margin'>";
echo "<a href='index.php' class='btn btn-primary pull-left'>";
    echo "<span class='glyphicon glyphicon-list'></span> Back to User List";
echo "</a>";
echo "</div>";

// query products
$stmt = $person->search($search_term, $from_record_num, $records_per_page);
  
// specify the page where paging is used
$page_url="search.php?s={$search_term}&";
  
// count total rows - used for pagination
$total_rows=$product->countAll_BySearch($search_term);
  
// read_template.php controls how the product list will be rendered
include_once "layouts/layout_list.php";
?>