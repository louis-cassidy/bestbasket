<html>
    <head>
        <script src="/js/jquery.min.js"></script>
        <script src="/node_modules/bootstrap-validator/js/validator.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <title>BestBasket | Register</title>
    </head>

<?php
include '../components/navbar.php';

session_start();
// Check if the session variables are filled and not empty. If they are, prompt the user to logout
if(isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
   echo 'You are already logged in! If you want to create another account, please <a href="logout"> logout</a> first.';
} else {
?>

<body>
<div class="container">
<!-- The form is created and will post its data to register.php upon being submitted -->    
<form name="register" action="<?=$_SERVER['PHP_SELF']?>" method="post" data-toggle="validator">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <label>Display Name:</label>
                <input class="form-control" name="display_name" type="text" pattern=".{3,12}" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
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
                <input class="form-control" name="password" id="password" type="password" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <label>Confirm Password</label>
                <input class="form-control" name="password_confirm" type="password" data-match="#password" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    
    <div class="g-recaptcha" data-sitekey="6LeWUAwUAAAAAIw_aXJzW6WhLtsbj1OztSXKDyys"></div>
    
    <input class="btn btn-success" name="submit" type="submit" value="Register">
</form>  
</div>
</body>

<?php

include '../components/dbconnect.php';
require_once '../vendor/swiftmailer/swiftmailer/lib/swift_required.php';

// Errors while connecting to the database are checked for
if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}

if(isset($_POST['submit'])) {
    
    $secret = "6LeWUAwUAAAAAI4zg0jXrrJ9_Z-sdvzDDtpe3evn";
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    
    if($responseData->success){
    
        // The POSTed values from the form are retrieved and saved to variables
        $display_name = $_POST['display_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $type = 'member';
        
        // The password is hashed so that it isn't stored in the database as plain text
        $password = md5($password);
        
        $confirm_code = uniqid();
        $confirmed = 0;
        
        // The values are submitted to the database
        $sql = "INSERT INTO accounts (id, type, display_name, email, password, confirm_code, confirmed) VALUES (NULL, '$type', '$display_name', '$email', '$password', '$confirm_code', '$confirmed')";
        
        // Set up email server connection
        $transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
        ->setUsername('automail.bestbasket@gmail.com')
        ->setPassword('CSepass1');
    
        $mailer = Swift_Mailer::newInstance($transport);
    
        // Message is created
        $message = Swift_Message::newInstance('Please confirm your email')
        ->setFrom(array('automail.bestbasket@gmail.com' => 'BestBasket'))
        ->setTo(array($email))
        ->setBody('Hi ' . $display_name . ', <br>Thanks for signing up for an account with BestBasket. Please <a href="https://bestbasket-louiscassidy.c9users.io/account/confirm.php/?code=' . $confirm_code . '">click here</a> to confirm your account.', 'text/html');
    
        $result = $mailer->send($message);
        
        // The user is shown a message based on whether the account creation was sucessful or not
        if ($conn->query($sql) === TRUE) {
            echo "Please follow the instructions sent to your email address to confirm your account.";
        } else {
            echo "Error: " . $conn->error;
        }
        
        // The connection is closed
        $conn->close();
    } else {
        echo "There was an error authenticating you.";
    }
}
}
?>

</html>