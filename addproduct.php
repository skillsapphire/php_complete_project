<!DOCTYPE html>
<?php session_start(); ?>
 
<?php
//checks if the SESSION variable is set or not. If not, the user will be redirected to login page
    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
<?php
//including the database connection file
include_once("connection.php");
 
if(isset($_POST['Submit'])) {    
    $name = $_POST['name'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $loginId = $_SESSION['id'];
        
    // checking empty fields
    if(empty($name) || empty($qty) || empty($price)) {                
        if(empty($name)) {
            echo "<font color='red'>Name field is empty.</font><br/>";
        }
        
        if(empty($qty)) {
            echo "<font color='red'>Quantity field is empty.</font><br/>";
        }
        
        if(empty($price)) {
            echo "<font color='red'>Price field is empty.</font><br/>";
        }
        
        //link to the previous page
        echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
    } else { 
        // if all the fields are filled (not empty) 
            
        //insert data to database    
        $result = mysqli_query($mysqli_conn, "INSERT INTO products(name, qty, price, login_id) VALUES('$name','$qty','$price', '$loginId')");
        
        //display success message
        echo "<font color='green'>Data added successfully.";
        echo "<br/><a href='productoverview.php'>View Result</a>";
    }
}
?>
</body>
</html>