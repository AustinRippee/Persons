<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:../login.php");
}
error_reporting(0);
class Person{
  
    // database connection and table name
    private $conn;
    private $table_name = "persons";
  
    // object properties from the database
    public $id;
    public $role;
    public $fname;
    public $lname;
    public $email;
	public $phone;
    public $password_hash;
    public $password_salt;
    public $address;
    public $address2;
    public $city;
    public $state;
    public $zip_code;
  // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // create user method
    function create(){
  
        //write query string to variable
        $query = "INSERT INTO " . $this->table_name . "
            SET role=:role, fname=:fname, lname=:lname, email=:email, phone=:phone,
            password_hash=:password_hash, password_salt=:password_salt,
            address=:address, address2=:address2, city=:city, state=:state,
            zip_code=:zip_code
        ";
        // prepare the statement
        $stmt = $this->conn->prepare($query);

        // protect against HTML/JS code injection
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->fname=htmlspecialchars(strip_tags($this->fname));
        $this->lname=htmlspecialchars(strip_tags($this->lname));
        $this->email=htmlspecialchars(strip_tags($this->email));
		$this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->password_hash=htmlspecialchars(strip_tags($this->password_hash));
        $this->password_salt=htmlspecialchars(strip_tags($this->password_salt));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->address2=htmlspecialchars(strip_tags($this->address2));
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->zip_code=htmlspecialchars(strip_tags($this->zip_code));
  
        // protect against SQL Injection
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":lname", $this->lname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
		$stmt->bindParam(":password_hash", $this->password_hash);
        $stmt->bindParam(":password_salt", $this->password_salt);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":address2", $this->address2);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip_code", $this->zip_code);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
	
    // method to read all users in a list
	function readAll($from_record_num, $records_per_page){
        $query = "SELECT id, fname, lname, email, role 
                FROM " . $this->table_name . " 
                ORDER BY lname ASC 
                LIMIT {$from_record_num}, {$records_per_page}";
  
        // the stmt object creates a template and sends the query to the database
        $stmt = $this->conn->prepare( $query );
        // the stmt object binds the values to its parameters which then the database executes it
        $stmt->execute();
  
        // returns the stmt object
        return $stmt;
    }

    // used for paging products
    public function countAll(){
  
        $query = "SELECT id FROM " . $this->table_name . "";
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
  
        $num = $stmt->rowCount();
  
        return $num;
    }

    // method to view a specific user
    function readOne(){
  
        $query = "SELECT role, fname, lname, email, phone, password_hash, password_salt, address, address2, city, state, zip_code
            FROM " . $this->table_name . "
            WHERE id = ?
            LIMIT 0,1";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
      
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
      
        $this->role = $row['role'];
        $this->fname = $row['fname'];
        $this->lname = $row['lname'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->password_hash = $row['password_hash'];
        $this->password_salt = $row['password_salt'];
        $this->address = $row['address'];
        $this->address2 = $row['address2'];
        $this->city = $row['city'];
        $this->state = $row['state'];
        $this->zip_code = $row['zip_code'];
    }

    // method to update the user entered data
    function update(){
  
        // sets the sql code to the query to be executed
        $query = "UPDATE " . $this->table_name . "
                SET
                    role = :role,
                    fname = :fname,
                    lname = :lname,
                    email = :email,
                    phone = :phone,
                    password_hash = :password_hash;
                    password_salt = :password_salt;
                    address = :address;
                    address2 = :address2;
                    city = :city;
                    state = :state;
                    zip_code = :zip_code;
                WHERE
                    id = :id";
      
        $stmt = $this->conn->prepare($query);
      
        // posted values
        $this->role=htmlspecialchars(strip_tags($this->role));
        $this->fname=htmlspecialchars(strip_tags($this->fname));
        $this->lname=htmlspecialchars(strip_tags($this->lname));
        $this->email=htmlspecialchars(strip_tags($this->email));
		$this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->password_hash=htmlspecialchars(strip_tags($this->password_hash));
        $this->password_salt=htmlspecialchars(strip_tags($this->password_salt));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->address2=htmlspecialchars(strip_tags($this->address2));
        $this->city=htmlspecialchars(strip_tags($this->city));
        $this->state=htmlspecialchars(strip_tags($this->state));
        $this->zip_code=htmlspecialchars(strip_tags($this->zip_code));
        $this->id=htmlspecialchars(strip_tags($this->id));
      
        // bind parameters
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":lname", $this->lname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":phone", $this->phone);
		$stmt->bindParam(":password_hash", $this->password_hash);
        $stmt->bindParam(":password_salt", $this->password_salt);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":address2", $this->address2);
        $stmt->bindParam(":city", $this->city);
        $stmt->bindParam(":state", $this->state);
        $stmt->bindParam(":zip_code", $this->zip_code);
        $stmt->bindParam(':id', $this->id);
      
        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
          
    }

    // read products by search term
    public function search($search_term, $from_record_num, $records_per_page){
  
        // select query
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.name LIKE ? OR p.description LIKE ?
            ORDER BY
                p.name ASC
            LIMIT
                ?, ?";
  
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
  
        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
        $stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);
  
        // execute query
        $stmt->execute();
  
        // return values from database
        return $stmt;
    }
  
    public function countAll_BySearch($search_term){
  
        // select query
        $query = "SELECT
                COUNT(*) as total_rows
            FROM
                " . $this->table_name . " p 
            WHERE
                p.name LIKE ? OR p.description LIKE ?";
  
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
  
        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
  
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
        return $row['total_rows'];
        print_r($row['total_rows']);
    
    }
}
?>