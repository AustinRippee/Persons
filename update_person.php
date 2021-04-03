<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
error_reporting(0);
// get ID of the person to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once '../database/database.php';
include_once 'objects/persons.php';
  
// Gets the database connection
$database = new Database();
$db = $database->connect();
  
// Prepares the Person object
$person = new Person($db);
  
// Sets the ID property of the user to be edited
$person->id = $id;
  
// Reads the details of the user to be edited
$person->readOne();
  
// Sets the page header
$page_title = "Editing User Profile";
include_once "layouts/layout_header.php";
  
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Back to User List";
    echo "</a>";
echo "</div>";
?>
<?php 
// if the form was submitted
if($_POST){
  
    // Sets the user property values
    $person->role = $_POST['role'];
    $person->fname = $_POST['fname'];
    $person->lname = $_POST['lname'];
    $person->email = $_POST['email'];
    $person->phone = $_POST['phone'];
    $person->password_hash = $_POST['password_hash'];
    $person->password_salt = $_POST['password_salt'];
    $person->address = $_POST['address'];
    $person->address2 = $_POST['address2'];
    $person->city = $_POST['city'];
    $person->state = $_POST['state'];
    $person->zip_code = $_POST['zip_code'];
  
    // Updates the user
    if($person->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Person was updated.";
        echo "</div>";
    }
  
    // Message to display if unable to update the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update person.";
        echo "</div>";
    }
}
?>

<!-- Creates the table of values that can be updated by the user -->
<form method='post' action='edit_person.php?id=<?php echo $id ?>'>
    <div class="input-group">
        <span class="input-group-addon">Email:</i></span>
        <input id="email" type="text" class="form-control" name="email" value='<?php echo $person->email; ?>'>
    </div>
    </br>

    <div class="input-group">
            <span class="input-group-addon">Role:</i></span>
            <select name="role" class="form-control">
                <option value="User" <?php if($_GET['role']=='User'){ echo 'selected'; } ?>>User</option>
                <option value="Admin"<?php if($_GET['role']=='Admin'){  echo 'selected'; } ?>>Admin</option>
          </select> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">First name:</i></span>
        <input name='fname' class="form-control" type='text' value='<?php echo $person->fname; ?>'> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Last name:</i></span>
        <input name='lname' class="form-control" type='text' value='<?php echo $person->lname; ?>'> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Phone:</i></span>
        <input name='phone' class="form-control" type='tel' value='<?php echo $person->phone; ?>'> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Address:</i></span>
        <input name='address' class="form-control" type='text' value='<?php echo $person->address; ?>'> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Address 2:</i></span>
        <input name='address2' class="form-control" type='text' value='<?php echo $person->address2; ?>'> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">City:</i></span>
        <input name='city' class="form-control" type='text' value='<?php echo $person->city; ?>'> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">State:</i></span>
        <input name='state' class="form-control" type='text' value='<?php echo $person->state; ?>'> </br>
    </div></br>

    <div class="input-group">
        <span class="input-group-addon">Zip Code:</i></span>
        <input name='zip_code' class="form-control" type='text' value='<?php echo $person->zip_code; ?>'> </br>
    </div>
    </br>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>


