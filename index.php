<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
// include core and database files
include_once 'config/core.php';
include_once '../database/database.php';
  
// include object file
include_once 'objects/persons.php';
  
// instantiate database
$database = new Database();
$db = $database->connect();

// Creates the user database
$persons = new Person($db);

// Main display
$page_title = "Persons List";
include_once "layouts/layout_header.php";
  
// query persons to read from database
$stmt = $persons->readAll($from_record_num, $records_per_page);
  
// specify the page where paging is used
$page_url = "index.php?";
  
// count total rows - used for pagination
$total_rows=$persons->countAll();
  
// Controls how the user list will be rendered
include_once "layouts/layout_list.php";
?>