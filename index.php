<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Homepage - Complete CRUD App</title>
</head>
<body>
    <div class="container">
        <header id="header">
            Welcome to complete CRUD App!
        </header>
        <section id="main">
            <?php 
                if(isset($_SESSION['username'])){
                    include_once("connection.php");
                    $result = mysqli_query($mysqli_conn, "SELECT * FROM login");
                
            ?>
            Welcome <?php echo $_SESSION['name'];?><br><a href="logout.php">Logout</a><br>
            <a href="productoverview.php">View and Add Products</a><br><br>
            <?php 
                } else{
                    echo "Please login to view this page.<br><br>";
                    echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
                }
            ?>
        </section><br><br>
        <footer id="footer">
            <div>
                All rights reserved @ 2021 <a href="http://obify.in">Obify Consulting Services Pvt Ltd</a>
            </div>
        </footer>
    </div>
</body>
</html>