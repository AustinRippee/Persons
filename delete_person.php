<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
error_reporting(0);
// connect to the database
require '../database/database.php';
$pdo = Database::connect();

// Retrieve the specifc id from the database
$id = $_GET['id'];

// Set the sql data for it to be executed
$sql = "SELECT * FROM persons WHERE id= ?";

// Prepares the statement
$query=$pdo->prepare($sql);

// Executes the query
$query->execute(Array($id));

// Retreives the result
$result = $query->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>Delete User</title>
  
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
                <h1>User Deletion Confirmation</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
            
        ?>

    <h3>Are you sure you want to delete this user?</h3>

<!-- Sets the table of values to correctly identify which user is being deleted -->
<form method='post' action='remove.php?id=<?php echo $id ?>'>
    
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <th>Role</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address 1</th>
            <th>Address 2</th>
            <th>City</th>
            <th>State</th>
            <th>Zip Code</th>
        </tr>
        <tr>
            <td><?php echo $result['role']; ?></td>
            <td><?php echo $result['fname']; ?></td>
            <td><?php echo $result['lname']; ?></td>
            <td><?php echo $result['email']; ?></td>
            <td><?php echo $result['phone']; ?></td>
            <td><?php echo $result['address']; ?></td>
            <td><?php echo $result['address2']; ?></td>
            <td><?php echo $result['city']; ?></td>
            <td><?php echo $result['state']; ?></td>
            <td><?php echo $result['zip_code']; ?></td>
        </tr>
    </table>
    <button class="btn btn-md btn-danger btn" type ="submit" name="confirm" >Confirm Delete</button>
</form>
<form method ='post' action='index.php'>
    <button class="btn btn-md btn-primary btn" type ="submit" name="cancel" >Cancel</button> 
</form>
</body>