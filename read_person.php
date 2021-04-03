<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
error_reporting(0);
?>
<head>
        <title>View User Profile</title>
        <meta charset="hutf-8" />
        <!-- Latest compiled and minified Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <!-- our custom CSS -->
        <link rel="stylesheet" href="libs/css/custom.css" />
    </head>
    
    <body>
       
        <div class = "container">
        <?php
        // show page header
        echo "<div class='page-header'>
                <h1>Viewing User Profile</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
        ?>
<?php
// Gets the ID of the user to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../database/database.php';
include_once 'objects/persons.php';
  
// Gets the database connection
$database = new Database();
$db = $database->connect();
  
// Prepares the Person object
$person = new Person($db);
  
// Set ID property of user to be read
$person->id = $id;
  
// Reads the details of user to be read
$person->readOne();
  
// read persons button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Back to User List";
    echo "</a>";
echo "</div>";

// HTML table for displaying a product details
echo "<table class='table table-hover table-responsive table-bordered'>";
  
    echo "<tr>";
        echo "<td>Role</td>";
        echo "<td>{$person->role}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>First Name</td>";
        echo "<td>{$person->fname}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>Last Name</td>";
        echo "<td>{$person->lname}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>Email</td>";
        echo "<td>{$person->email}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>Phone</td>";
        echo "<td>{$person->phone}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>Address</td>";
        echo "<td>{$person->address}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>Address 2</td>";
        echo "<td>{$person->address2}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>City</td>";
        echo "<td>{$person->city}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>State</td>";
        echo "<td>{$person->state}</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>Zip Code</td>";
        echo "<td>{$person->zip_code}</td>";
    echo "</tr>";
echo "</tr>";
  
echo "</table>";
?>