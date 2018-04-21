<?php
// Start the session
session_start();

require 'dbinfo.php';

$email = $password = "";
$emailErr = $passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    }
    else {
        $email = $_POST["email"];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    }
    else {
        $password = $_POST["password"];
    }
}

if(!empty($_POST['email']) && !empty($_POST['password'])) {
    $connection = mysqli_connect($host, $usernameDB, $passwordDB, $database) or die( "Unable to connect");
    $hashPswd = md5($password);
    $query = "SELECT * FROM User WHERE Email='$email' AND Password='$hashPswd'";
    
    if($stmt=mysqli_prepare($connection, $query)) {
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1) {
            echo "User '$email' login successfully";
            header('Location: register.php');
        }
        else {
            echo "Login failed!";
        }   
    }
    else {
        echo "Failed";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
</head>
<body>

<form action="login.php" method="post">
    Email: <input type="text" name="email"><span>* <?php echo $emailErr;?></span><br>
    Password: <input type="password" name="password"><span>* <?php echo $passwordErr;?></span><br>
    <input value="Login" type="submit">
</form>

</body>
</html>
