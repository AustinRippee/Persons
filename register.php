<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>Register New User</title>
  
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
                <h1>Register New User</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
        ?>
</body>
<?php
// Creates the button to go back to the login page
echo "<div class='right-button-margin'>";
echo "<a href='login.php' class='btn btn-primary pull-right'>";
    echo "<span class='glyphicon glyphicon-user'></span> Back to Login Page";
echo "</a>";
echo "</div>";
?>
</br>
<?php
error_reporting(0);
// Error to display to show that all fields to be to have data
if($_GET['err']=='empty'){
    echo "<p style='color:red'>All fields are required.</p></br>";
}

// Error to display if the email is not in valid format
else if($_GET['err']=='invalidEmail'){
    echo "<p style='color:red'>That is an invalid email.</p></br>";
}

// Error to display if the password doesn't fulfill all the requirements
else if($_GET['err']=='passRequ'){
    echo "<p style='color:red'>Your password must have these requirements:</br>";
    echo "- At least 16 characters in length</br>";
    echo "- Include at least one upper case letter</br>";
    echo "- Include at least one number</br>";
    echo "- Include at least one special character.</p></br>";
}

// Error to display if the passwords do not match up
else if($_GET['err']=='passVal'){
    echo "<p style='color:red'>Your passwords don't match.</p></br>";
}

// Error to display if the email has already been registered
else if($_GET['err']=='existEmail'){
    echo "<p style='color:red'>The email <b> {$_GET['email']} </b> you entered is already registed.</p></br>";
}
?>
</br>
<!-- Creates the table to enter the data to register a user -->
<form method='post' action='register_person.php'>
    <div class="input-group">
        <span class="input-group-addon">Email:</i></span>
        <input id="email" type="text" class="form-control" name="email" placeholder=<?php echo $_GET['email'] ?>>
    </div>
    </br>

    <div class="input-group">
        <span class="input-group-addon">Password:</i></span>
        <input type="password" class="form-control" name="password"?>
    </div>
    </br>

    <div class="input-group">
        <span class="input-group-addon">Confirm Password:</i></span>
        <input name='valPassword' class="form-control" type='password'> </br>
    </div>
    </br>

    <div class="input-group">
            <span class="input-group-addon">Role:</i></span>
            <select name="role" class="form-control">
                <option value="User" <?php if($_GET['role']=='User'){ echo 'selected'; } ?>>User</option>
                <option value="Admin"<?php if($_GET['role']=='Admin'){  echo 'selected'; } ?> disabled>Admin</option>
          </select> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">First name:</i></span>
        <input name='fname' class="form-control" type='text'placeholder=<?php echo $_GET['fname'] ?>> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Last name:</i></span>
        <input name='lname' class="form-control" type='text' placeholder=<?php echo $_GET['lname'] ?>> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Phone:</i></span>
        <input name='phone' class="form-control" type='tel'placeholder=<?php echo $_GET['phone'] ?>> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Address:</i></span>
        <input name='address' class="form-control" type='text' placeholder=<?php echo $_GET['address'] ?>> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">Address 2:</i></span>
        <input name='address2' class="form-control" type='text' placeholder=<?php echo $_GET['address2'] ?>> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">City:</i></span>
        <input name='city' class="form-control" type='text' placeholder=<?php echo $_GET['city'] ?>> </br>
    </div>
    </br>
    <div class="input-group">
        <span class="input-group-addon">State:</i></span>
        <input name='state' class="form-control" type='text' placeholder=<?php echo $_GET['state'] ?>> </br>
    </div></br>

    <div class="input-group">
        <span class="input-group-addon">Zip Code:</i></span>
        <input name='zip_code' class="form-control" type='text' placeholder=<?php echo $_GET['zip_code'] ?>> </br>
    </div>
    </br>
    <input class="btn btn-primary" type="submit" value="Submit">
</form>