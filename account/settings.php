<html>
    <head>
        <script src="/js/jquery.min.js"></script>
        <script src="/node_modules/bootstrap-validator/js/validator.js"></script>
        <title>BestBasket | Account Settings</title>
    </head>
</html>

<?php

include '../components/navbar.php';
include '../components/dbconnect.php';

session_start();

if(!isset($_SESSION["user_id"]) && empty($_SESSION["user_id"])) {
   echo 'You must be logged in to access this page.';
} else {

?>
<div class="container">
<h1>Your Account Settings</h1><br>

<h4>Update email:</h4>

<form class="form-inline" name="update_email" action="<?=$_SERVER['PHP_SELF']?>" method="post" data-toggle="validator">
    <div class="form-group">
        <input class="form-control" type="email" name="new_email" placeholder="Email" required>
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#emailCollapse" aria-expanded="false">
            Next
        </button>
    </div>
    <div class="collapse" id="emailCollapse">
        <div class="form-group">
            <input class="form-control" type="password" name="email_password_confirm" placeholder="Confirm password" required>
        </div>
        <div class="form-group">
            <input class="btn btn-warning" type="submit" name="update_email_submit" value="Update">
        </div>
    </div>
</form>

<?php

// The code only executes if the confirm button for the correlating form is clicked
if(isset($_POST['update_email_submit'])) {
    
    // The password is retrieved and hashed to match database entries
    $confirm_password = $_POST['email_password_confirm'];
    $confirm_password = md5($confirm_password);
    
    // Password check
    $sql = "SELECT id from accounts WHERE id = '{$_SESSION['user_id']}' AND password = '$confirm_password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "<b><font color='red'> Password incorrect</b></font>"; 
    } else {
    
    // Update only commences if the password was correct
    $email = $_POST['new_email'];
    
    $sql = "UPDATE `bestbasket`.`accounts` SET `email` = '$email' WHERE `accounts`.`id`= {$_SESSION['user_id']};";

    if ($conn->query($sql) === TRUE) {
        echo "<b>Your email has been updated.</b>";
    } else {
        echo "<b>There was an error updating your email.</b>";
    }
}
}

?>

<h4>Update password:</h4>
<form class="form-inline" name="update_password" action="<?=$_SERVER['PHP_SELF']?>" method="post" data-toggle="validator">
    <div class="form-group">
        <input class="form-control" type="password" name="new_password" id="new_password" placeholder="New password" required>
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="new_password_confirm" data-match="#new_password" placeholder="Confirm" required>
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#passwordCollapse" aria-expanded="false">
            Next
        </button>
    </div>
    <div class="collapse" id="passwordCollapse">
        <div class="form-group">
            <input class="form-control" type="password" name="password_password_confirm" placeholder="Confirm old password" required>
        </div>
        <div class="form-group">
            <input class="btn btn-warning" type="submit" name="update_password_submit" value="Update">
        </div>
    </div>
</form>

<?php

if(isset($_POST['update_password_submit'])) {
    
    // Old password used to confirm user
    $confirm_password = $_POST['password_password_confirm'];
    $confirm_password = md5($confirm_password);
    
    $sql = "SELECT id from accounts WHERE id = '{$_SESSION['user_id']}' AND password = '$confirm_password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "<b>Password incorrect</b>"; 
    } else {
    
    // New input taken
    $password = $_POST['new_password'];
    $password = md5($password); // Password is hashed
    
    // Database updated
    $sql = "UPDATE `bestbasket`.`accounts` SET `password` = '$password' WHERE `accounts`.`id`= {$_SESSION['user_id']};";

    if ($conn->query($sql) === TRUE) {
        echo "<b>Your password has been updated.</b>";
    } else {
        echo "<b>There was an error updating your password.</b>";
    }
}
}

?>

<h4>Delete account</h4>
<form class="form-inline" name="delete_account" action="<?=$_SERVER['PHP_SELF']?>" method="post" data-toggle="validator">
    <div class="form-group">
        <input type="checkbox" name="confirm_delete" required>
        <strong>Please confirm that you would like to delete your account and reviews.</strong>
    </div>
    <div class="form-group">
        <button class="btn btn-warning btn-sm" type="button" data-toggle="collapse" data-target="#deleteCollapse" aria-expanded="false">
            Next
        </button>
    </div>
    <div class="collapse" id="deleteCollapse">
        <div class="form-group">
            <input class="form-control" type="password" name="delete_password_confirm" placeholder="Confirm password" required>
        </div>
        <div class="form-group">
            <input class="btn btn-danger" type="submit" name="delete_account_submit" value="Delete">
        </div>
    </div>
</form>

<?php

if(isset($_POST['delete_account_submit'])) {
    
    $confirm_password = $_POST['delete_password_confirm'];
    $confirm_password = md5($confirm_password);
    
    $sql = "SELECT id from accounts WHERE id = '{$_SESSION['user_id']}' AND password = '$confirm_password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "<b>Password incorrect</b>"; 
    } else {

    // Account is removed from the database
    $sql = "DELETE FROM `bestbasket`.`accounts` WHERE `accounts`.`id` = {$_SESSION['user_id']}";
    if ($conn->query($sql) === TRUE) {
        echo "Please wait...";
    } else {
        echo "Error" . $conn->error; 
    }
    
    // All reviews made by this user are removed from the database
    $sql = "DELETE FROM `bestbasket`.`reviews` WHERE `reviews`.`user_id` = {$_SESSION['user_id']}";
    if ($conn->query($sql) === TRUE) {
        // Redirects to deleted.php
        header("refresh:0;url=deleted.php");
    } else {
        echo "Error" . $conn->error;
    }
}
}

?>

</div>
<?php
}
?>