<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:../login.php");
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title><?php echo $page_title; ?></title>
  
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
   
    <!-- our custom CSS -->
    <link rel="stylesheet" href="libs/css/custom.css" />
   
</head>
<body>
  
    <!-- container -->
    <div class="container">
  
        <?php
        // show page header
        echo "<div class='page-header'>
                <h1>{$page_title}</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
        ?>