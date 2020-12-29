<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <a href="index.php">Home</a><br>
    <?php 
        include_once("connection.php");

        if(isset($_POST['submit'])){
            $user = mysqli_real_escape_string($mysqli_conn, $_POST['username']);
            $pass = mysqli_real_escape_string($mysqli_conn, $_POST['password']);

            if($user == "" || $pass == ""){
                echo "Either username or password is empty";
            }else{
                $result = mysqli_query($mysqli_conn, "SELECT * FROM login WHERE username = '$user' AND password = md5('$pass')")
                            or die("Could not execute the select query.");

                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
                    $validuser = $row['username'];
                    $_SESSION['username'] = $validuser;
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['id'] = $row['id'];
                } else {
                    echo "Invalid username or password.";
                    echo "<br/>";
                    echo "<a href='login.php'>Go back</a>";
                }
                
                if(isset($_SESSION['username'])) {
                    header('Location: index.php');            
                }
            }
      //end of if and start of else
        }else{
            
    ?>
    <p><font size="+2">Login</font></p>
    <form name="form1" method="post" action="">
        <table width="75%" border="0">
            <tr> 
                <td width="10%">Username</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr> 
                <td>Password</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr> 
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Submit"></td>
            </tr>
        </table>
    </form>
    <?php } //end of else?>
</body>
</html>