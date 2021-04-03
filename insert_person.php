<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:login.php");
}
error_reporting(0);
// Connects to the database
require '../database/database.php';
$pdo = Database::connect();

// Instantiates the variables
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

// Checks to make sure that an email is available 
$sql = "SELECT id FROM persons WHERE email = ?";
$query = $pdo->prepare($sql);
$query->execute(Array($email));
$result = $query->fetch(PDO::FETCH_ASSOC);

// If any of the included values are empty, any error will be displayed
if(empty($email)||empty($password)||empty($valPassword)||empty($role)||
   empty($fname)||empty($lname)||empty($phone)||empty($address)||
   empty($address2)||empty($city)||empty($state)||empty($zip_code)){
    header("Location:create_person.php?err=empty".$header);
}
// Attempts to match any email that has already been created
else if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)) {
    header("Location:create_person.php?err=invalidEmail".$header);
} 
// Proceeds with creating an email not already registered
else {
    $sql = "SELECT id FROM persons WHERE email = ?";
    $query = $pdo->prepare($sql);
    $query->execute(Array(
        $email
    ));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        header("Location:create_person.php?err=existEmail" . "&email=". $email . $header);
    } else {
        // This validates that the password is of required strength
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        $validatePass = strcmp($password, $valPassword);
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 16) {
           header("Location:create_person.php?err=passRequ".$header);
        } else if ($validatePass != 0) {
            header("Location:create_person.php?err=passVal".$header);
        } else {

            // Sanitizes the data to protect against Injections
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

            // Salts and hashes the password to protect it
            $password_salt = MD5(microtime());
            $password_hash = MD5($password . $password_salt);

            // Sets the INSERT INTO value into the sql statement
            $sql = "INSERT INTO persons (`role`, email, password_hash, password_salt, fname, lname, phone, `address`, address2, city, `state`, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            // Prepare the statement
            $query = $pdo->prepare($sql);
            // Executes the statement
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
?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1">
              
                <title>User Added</title>
              
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
                            <h1>User Added Success!</h1>
                        </div>";
                    ?>
            </body>
<?php
            // The Display of when the new user is created and displays the button to go back to the main user list
            echo "<h5 style='color:grey;'>Successfully Created New User</h5><br>";
            echo "<div class='left-button-margin'>";
                echo "<a href='index.php' class='btn btn-primary pull-left'>";
                    echo "<span class='glyphicon glyphicon-list'></span> Back to User List";
                echo "</a>";
            echo "</div>";
        }
    }
}