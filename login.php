<?php
    // Initilizes the session
    session_start();
   
    $errMsg='';
    
    // Checks the user's login credentials
    if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])){
        
        // Prevents from any HTML/CSS/JS injection
        $_POST['email']=htmlspecialchars($_POST['email']);
        $_POST['password']=htmlspecialchars($_POST['password']);
        
        // Logs in with the manually entered Admin account
        if($_POST['email']=='admin@admin.com' && $_POST['password']=='admin'){
        $_SESSION['email'] = 'admin@admin.com';
        $_POST['role']='Admin';
        header("Location:index.php");
        }
        
        // Logs in with the manually entered User account
        else if($_POST['email']=='user@user.com' && $_POST['password']=='user'){
            $_SESSION['email'] = 'user@user.com';
            $_POST['role']='User';
            header("Location:index.php");
        }

        else{
            // Checks the databse for the correctly-entered user
            require '../database/database.php';
            $pdo = Database::connect();
            // Sets the SQL statement to be executed
            $sql = 'SELECT * FROM persons '
                . ' WHERE email = ? '
                . ' LIMIT 1';
            
            // Prepares the statement
            $query =$pdo->prepare($sql);
            // Executes the statement
            $query->execute(Array($_POST['email']));
            // Returns the Result
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            // If user entered a correct email, it will start the session
            if ($result){
               $password = $_POST['password'];
               $password_hash_db = $result['password_hash'];
               $password_salt_db = $result['password_salt'];
               $password_hash = MD5($password . $password_salt_db);
               
               // If user entered correct email and password combination
               if(!strcmp($password_hash, $password_hash_db)){
                   $_SESSION['email'] = $result['email'];
                   
                   header("Location:index.php");
               }
               // If user entered wrong email and password combination
               else {
                   $errMsg = "Login Failed: Wrong email or password";
               }

            }
            // user entered anything wrong, error message will appear regardless unless correctly entered
            else{
            $errMsg = "Login Failed: Wrong email or password";
            }
        }
    }
?>

<DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Persons List</title>
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
                <h1>Persons List</h1>
                <h5 style='color:grey;'>CRUD Applet with Login Created by Austin Rippee</h5>
            </div>";
        ?>
             <a href="https://github.com/AustinRippee/users.git">Link to the GitHub Source Code </a>
        <h2>Login</h2>
             <form action="" method="post">
            
            <p style="color: red;"><?php echo $errMsg; ?></p>
            
            <!-- User area to enter their email and password -->
            <input type="text" class="form-control" name='email' placeholder="Email" required autofocus /> <br />
            <input type="password" class="form-control" name="password" placeholder="Password" required  /> <br />
            

            <!-- Buttons to Login or Join -->
            <button class="btn btn-lg btn-primary btn-block" type ="submit" name="login" >Login</button> 
            <button class="btn btn-lg btn-success btn-block" onClick="window.location.href='register.php';" type ="button" name="join" >Join</button>
        </form>
        </div>
       
    </body>