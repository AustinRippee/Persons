<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>User Deleted</title>
  
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
                <h1>User Deletion Successful</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
        ?>
</body>
<?php
    // Connects to the database
    require '../database/database.php';
    $pdo = Database::connect();

    // Gets the id from the databse
    $id = $_GET['id'];

    // Sets the SQL statement
    $sql = "DELETE FROM persons WHERE id = ?";

    // Prepares the statement
    $query =$pdo->prepare($sql);

    // Executes the statement
    $query->execute(Array($id));

    // Creates the button to go back to the main user display list
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-left'>";
        echo "<span class='glyphicon glyphicon-list'></span> Back to User List";
    echo "</a>";
echo "</div>";