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
                <h1>User Registration Success</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
        ?>

<?php
// Connect to the database
require '../database/database.php';
$pdo = Database::connect();

// Checks to see if it is a valid email to be registered
$email = $_POST['email'];
$password = $_POST['password'];
$valPassword = $_POST['valPassword'];
$role = $_POST['role'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];

// Sets the header of the values from the database
$header= "&email=" . $email
        ."&role=" . $role
        ."&fname=" . $fname
        ."&lname=" . $lname
        ."&phone=" . $phone
        ."&address=" . $address
        ."&address2=" . $address2
        ."&city=" . $city
        ."&state=" . $state
        ."&zip_code=" . $zip_code;

// If any of the included values are empty, any error will be displayed
if(empty($email)||empty($password)||empty($valPassword)||empty($role)||
   empty($fname)||empty($lname)||empty($phone)||empty($address)||
   empty($address2)||empty($city)||empty($state)||empty($zip_code)){
         header("Location:register.php?err=empty".$header);
}

// Attempts to match any email that has already been created
else if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)) {
    header("Location:register.php?err=invalidEmail".$header);
} 
else {
    //check to make sure email is not there
    $sql = "SELECT id FROM persons WHERE email = ?";
    $query = $pdo->prepare($sql);
    $query->execute(Array($email));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        header("Location:register.php?err=existEmail" . "&email=". $email.$header);
    } else {
        // Validate password strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $validatePass = strcmp($password, $valPassword);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 16) {
           header("Location:register.php?err=passRequ".$header);
        } else if ($validatePass != 0) {
            header("Location:register.php?err=passVal".$header);
        } else {

            //sanatize data
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);
            $fname = htmlspecialchars($fname);
            $lname = htmlspecialchars($lname);
            $phone = htmlspecialchars($phone);
            $address = htmlspecialchars($address);
            $address2 = htmlspecialchars($address2);
            $city = htmlspecialchars($city);
            $state = htmlspecialchars($state);
            $zip_code = htmlspecialchars($zip_code);
            //salt and hash password
            $password_salt = MD5(microtime());
            $password_hash = MD5($password . $password_salt);
            # 3. assign MySQL query code to a variable
            $sql = "INSERT INTO persons (`role`, email, password_hash, password_salt, fname, lname, phone, `address`, address2, city, `state`, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute(Array(
                $role,
                $email,
                $password_hash,
                $password_salt,
                $fname,
                $lname,
                $phone,
                $address,
                $address2,
                $city,
                $state,
                $zip_code
            ));
            echo "<h4>Your info has been added. You can now log in</h4><br>";
            echo "<div class='right-button-margin'>";
                echo "<a href='login.php' class='btn btn-primary pull-left'>";
                    echo "<span class='glyphicon glyphicon-user'></span> Back to Login Page";
                echo "</a>";
            echo "</div>";
        }
    }
}
?>