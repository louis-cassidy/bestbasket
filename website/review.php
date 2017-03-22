<html>
    <head>
        <script src="/js/jquery.min.js"></script>
        <script src="/node_modules/bootstrap-validator/js/validator.js"></script>
    </head>
</html>


<?php

include '../components/navbar.php';

// Start the session to get the user's variables
session_start();

// Deny access if the user isn't logged in
if(!isset($_SESSION["user_id"]) && empty($_SESSION["user_id"])) {
   echo 'You must be logged in to access this page.';
} else {

// Connect to database and test connection
include '../components/dbconnect.php';

// Retrieve the site's id from the URL
$site_id = $_GET['id'];

// The database is checked to see if the user logged in has made a review for this site before
$sql = "SELECT id FROM reviews WHERE user_id = '{$_SESSION['user_id']}' AND site_id = '$site_id';";
$result = $conn->query($sql);

// If they have made a review for this site before, deny them access to the page
if($result->num_rows > 0){
    echo "You have already reviewed this website.";
} else {

// Select the data from the database for the site being reviewed
$sql = "SELECT name,url,category FROM websites WHERE id = '$site_id';";
$result = $conn->query($sql);

$row = $result->fetch_array(MYSQLI_NUM);

// Assign this data to variables
$site_name = $row[0];
$site_url = $row[1];
$site_category = $row[2];

// If the user has submitted the form, post their information to the database
if(isset($_POST['submit'])) {
    
    $delivery = $_POST['delivery'];
    $value = $_POST['value'];
    $payment = $_POST['payment'];
    $reliability = $_POST['reliability'];
    $comment = $_POST['comment'];
    
    $site_id = $_GET['id'];
    // All of the values are added up and divided by 4 to get the average score
    $pts_total = $delivery + $value + $payment + $reliability;
    $average = $pts_total / 4;
    
    $sql = "INSERT INTO reviews (id, user_id, user_display_name, site_id, site_name, delivery, value, payment, reliability, average, comment) VALUES (NULL, '{$_SESSION['user_id']}', '{$_SESSION['user_display_name']}', '$site_id', '$site_name', '$delivery', '$value', '$payment', '$reliability', '$average', '$comment')";

    if ($conn->query($sql) === TRUE) {
        
        echo "Thank you for your review!";
        // The user gains a point
        $sql = "UPDATE `bestbasket`.`accounts` SET `points` = `points` + 1 WHERE `accounts`.`id` = {$_SESSION['user_id']}";
        $conn->query($sql);
        
        // The new average is worked out -->
        
        $sql = "SELECT average FROM reviews WHERE site_id = '$site_id'";
        $result = $conn->query($sql);
        $count = 0;
        $new_average = 0;

        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $count = $count + 1; // Every review is counted
            $new_average = $new_average + $row[0]; // Total score is counted
        }
        
        $new_average = ($new_average / $count); // Divided to find new average
        // New average saved to database
        $sql = "UPDATE `bestbasket`.`websites` SET `average` = $new_average WHERE `websites`.`id` = $site_id";
        $conn->query($sql);
        
        // --<
        
        // The new total score is worked out
        $sql = "UPDATE `bestbasket`.`websites` SET `total_score` = `total_score` + $average WHERE `websites`.`id` = $site_id";
        $conn->query($sql);
        
    } else {
        echo "Error: " . $conn->error;
    }
}

// If they haven't submitted the form, show the form
else{
?>

<html>
    
<head>
    <title>BestBasket | Review <?=$site_name?></title>
</head>

<div class="container">
    <h2>You are reviewing: <b><?php echo $site_url; ?></b></h2>
    <form name="review" action="<?=$_SERVER['PHP_SELF']?>?id=<?=$site_id?>" method="post" data-toggle="validator">
        <h4>Please rate the following categories from 1 (worst) to 5 (best):</h4>
        <br>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <input type="radio" name="delivery" value="1" checked> 1
                    <input type="radio" name="delivery" value="2"> 2
                    <input type="radio" name="delivery" value="3"> 3
                    <input type="radio" name="delivery" value="4"> 4
                    <input type="radio" name="delivery" value="5"> 5
                    <label> Delivery</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <input type="radio" name="value" value="1" checked> 1
                    <input type="radio" name="value" value="2"> 2
                    <input type="radio" name="value" value="3"> 3
                    <input type="radio" name="value" value="4"> 4
                    <input type="radio" name="value" value="5"> 5
                    <label> Value for money</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <input type="radio" name="payment" value="1" checked> 1
                    <input type="radio" name="payment" value="2"> 2
                    <input type="radio" name="payment" value="3"> 3
                    <input type="radio" name="payment" value="4"> 4
                    <input type="radio" name="payment" value="5"> 5
                    <label> Payment options</label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <input type="radio" name="reliability" value="1" checked> 1
                    <input type="radio" name="reliability" value="2"> 2
                    <input type="radio" name="reliability" value="3"> 3
                    <input type="radio" name="reliability" value="4"> 4
                    <input type="radio" name="reliability" value="5"> 5
                    <label> Reliability</label>
                </div>
            </div>
        </div>
        <h4>Please leave a comment summing up the experience. (140 char max)</h4>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    <textarea class="form-control" name="comment" minlength='12' required></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <input class="btn btn-success" name="submit" type="submit" value="Submit Review">
    </form>    
</div>
</html>

<?php
}
}
}
?>