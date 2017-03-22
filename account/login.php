<html>
    <head>
        <script src="/js/jquery.min.js"></script>
        <script src="/node_modules/bootstrap-validator/js/validator.js"></script>
        <title>BestBasket | Login</title>
    </head>

<?php
include '../components/navbar.php';

session_start();
// Check if the session variables are filled and not empty. If they are, prompt the user to logout
if(isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
   echo 'You are already logged in! If you want to log in to another account, please <a href="logout"> logout</a> first.';
} else {
?>

<html>
<div class="container">
<form name="login" action="<?=$_SERVER['PHP_SELF']?>" method="post" data-toggle="validator">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <label>Email:</label>
                <input class="form-control" name="email" type="email" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <label>Password</label>
                <input class="form-control" name="password" type="password" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    
    <input class="btn btn-success" name="submit" type="submit" value="Log in">
</form>    
</div>
</html>

<?php

include '../components/dbconnect.php';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $password = md5($password);
    
    // The database is queried for all accounts where the email and password given match
    $sql = "SELECT id,type,display_name,email,confirmed,points from accounts WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "Your email or password was incorrect."; // If there are no matches the details are incorrect
    } else {
        // Their details are stored in an array and then saved to variables
        $row = $result->fetch_array(MYSQL_NUM);
        $user_id = $row[0];
        $user_type = $row[1];
        $user_display_name = $row[2];
        $user_email = $row[3];
        $user_confirmed = $row[4];
        $user_points = $row[5];
        
        if ($user_confirmed != 1){
            echo "You still need to confirm your account.";
        } else {
        
        // A PHP session is started so that variables containing the users details can be accessed site-wide
        session_start();
        $_SESSION["user_id"] = "$user_id";
        $_SESSION["user_type"] = "$user_type";
        $_SESSION["user_display_name"] = "$user_display_name";
        $_SESSION["user_email"] = "$user_email";
        $_SESSION["user_points"] = "$user_points";
        
        echo "Logged in successfully. Redirecting...";
        header("refresh:1;url=/index.php");
    }
    }
    
    $conn->close();
}
}
?>

</html>