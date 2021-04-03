<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:../login.php");
}
error_reporting(0);
require_once '../database/database.php';
$pdo = Database::connect();

$sql = 'SELECT `role` FROM persons '
. " WHERE email = ? "
. ' LIMIT 1';

$query =$pdo->prepare($sql);
$query->execute(Array($_SESSION['email']));
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result){
	$userrole =  $result['role'];
}
else{
	if (strpos($_SESSION['email'], "User", 0)===false){
			$userrole="Admin";
	}
	else{
			$userrole="User";
	}
}

// search form
echo "<form role='search' action='search.php'>";
    echo "<div class='input-group col-md-3 pull-left margin-right-1em'>";
        $search_value=isset($search_term) ? "value='{$search_term}'" : "";
        echo "<input type='text' class='form-control' placeholder='Type person name' name='s' id='srch-term' required {$search_value} />";
        echo "<div class='input-group-btn'>";
            echo "<button class='btn btn-primary' type='submit'><i class='glyphicon glyphicon-search'></i></button>";
        echo "</div>";
    echo "</div>";
echo "</form>";


// create person button
echo "<div class='right-button-margin'>";
if ($userrole == 'Admin'){
    echo "<a href='create_person.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Create Person";
    echo "</a>";
}
    echo "<a href='logout.php' class='btn btn-danger pull-right'>";
        echo "<span class='glyphicon glyphicon-minus'></span> Logout";
    echo "</a>";
echo "</div>";

    echo "<button type='button' class='btn btn-dark btn-md pull-right' disabled>Logged in as <b>{$userrole}</b> with email <b>{$_SESSION['email']}</b></button>";

// display the user list if there are any
if($total_rows>0){
  
    // main table
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>Email</th>";
            echo "<th>Role</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
            
            // values included in the table to be shown
            echo "<tr>";
                echo "<td>{$lname}</td>";
                echo "<td>{$fname}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$role}</td>";

                if ($userrole == 'Admin'){
                echo "<td>";
  
                    // read user button
                    echo "<a href='read_person.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";
  
                    // edit user button
                    echo "<a href='update_person.php?id={$id}' class='btn btn-info left-margin'>";
                        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                    echo "</a>";
  
                    // delete user button
                    echo "<a href='delete_person.php?id={$id}' class='btn btn-danger left-margin'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                    echo "</a>";
  
                echo "</td>";
                }
                elseif ($userrole == 'User'){
                    echo "<td>";
  
                    // read user button
                    echo "<a href='read_person.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";
  
                echo "</td>"; 
                }
                else{
                    echo "<td>";
  
                    // read user button
                    echo "<a href='read_person.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";
  
                echo "</td>"; 
                }
  
            echo "</tr>";
            }
  
  
    echo "</table>";
  
    // paging buttons
    include_once 'paging.php';

    
}
  
// tell the user there are no users
else{
    echo "<div class='alert alert-danger'>No Persons found.</div>";
}
?>