<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Overview</title>
</head>
<body>
<?php
//checks if the SESSION variable is set or not. If not, the user will be redirected to login page
    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
    }
?>
<?php
    //including the database connection file
    include_once("connection.php");
    
    //fetching data in descending order (lastest entry first)
    $result = mysqli_query($mysqli_conn, "SELECT * FROM products WHERE login_id=".$_SESSION['id']." ORDER BY id DESC");
?>
<a href="index.php">Home</a> | <a href="addproduct.html">Add New Product</a> | <a href="logout.php">Logout</a>
<br/><br/>
    
<table width='80%' border=0>
    <tr bgcolor='#CCCCCC'>
        <td>Name</td>
        <td>Quantity</td>
        <td>Price ($)</td>
        <td>Update</td>
    </tr>
    <?php
    while($res = mysqli_fetch_array($result)) {        
        echo "<tr>";
        echo "<td>".$res['name']."</td>";
        echo "<td>".$res['qty']."</td>";
        echo "<td>".$res['price']."</td>";    
        echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";        
    }
    ?>
</table> 
</body>
</html>