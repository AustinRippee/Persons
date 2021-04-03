<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
}
error_reporting(0);
?>
<head>
        <title>User Edited</title>
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
                <h1>User Edit Successful</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
        ?>
<?php
# 1. connect to database
require '../database/database.php';
$pdo = Database::connect();
# 2. assign user info to a variable
$email = $_POST['email'];
if (!$_POST['role']) {
    $sql = 'SELECT `role` FROM persons ' . " WHERE email = ? " . ' LIMIT 1';
    $query = $pdo->prepare($sql);
    $query->execute(Array(
        $_SESSION['email']
    ));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $role = $result['role'];
    } else {
        if (strpos($_SESSION['email'], "user", 0) === false) {
            $role = "admin";
        } else {
            $role = "user";
        }
    }
}

$role = $_POST['role'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$address2 = $_POST['address2'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];
$id = $_GET['id'];
if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)) {
    echo '<p>Wrong Email Format!</p><br>';
    echo "<a href='display_update_form.php?id=" . $_GET['id'] . "'>Back to Update form</a>";
    include_once "layout_footer.php";
    exit();
} else {
    //sanatize data
    $email = htmlspecialchars($email);
    $fname = htmlspecialchars($fname);
    $lname = htmlspecialchars($lname);
    $phone = htmlspecialchars($phone);
    $address = htmlspecialchars($address);
    $address2 = htmlspecialchars($address2);
    $city = htmlspecialchars($city);
    $state = htmlspecialchars($state);
    $zip_code = htmlspecialchars($zip_code);
    $sql = 'SELECT `role` FROM persons ' . " WHERE email = ? " . ' LIMIT 1';
    $query = $pdo->prepare($sql);
    $query->execute(Array(
        $_SESSION['email']
    ));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    # 3. assign MySQL query code to a variable
    $sql = "UPDATE persons SET email=?, role=?, fname=?, lname=?, phone=?, `address`=?, address2=?, city=?, `state`=?, zip_code=? WHERE id=?";
    $query = $pdo->prepare($sql);
    $query->execute(Array(
        $email,
        $role,
        $fname,
        $lname,
        $phone,
        $address,
        $address2,
        $city,
        $state,
        $zip_code,
        $id
    ));
    # 4. update the message in the database
    //$pdo->query($sql); # execute the query
    echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-left'>";
        echo "<span class='glyphicon glyphicon-list'></span> Back to User List";
    echo "</a>";
echo "</div>";
}

?>