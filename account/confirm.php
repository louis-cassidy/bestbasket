<?php

include '../components/dbconnect.php';

$code = $_GET['code']; // The code in the URL is saved to a variable

$sql = "SELECT id FROM accounts WHERE confirm_code = '$code'";
$result = $conn->query($sql);

$row = $result->fetch_array(MYSQL_NUM);
$id = $row[0];

if ($result->num_rows == 0) {
    // If there are no matches in the database, it's invalid
    echo "That link is invalid."; 
} else {
    // If there is a match, the confirmed column for that account is updated to 1
    $sql = "UPDATE `bestbasket`.`accounts` SET `confirmed` = '1' WHERE `accounts`.`id` = $id";
    $result = $conn->query($sql);
    echo "Thank you for confirming your email address. You can now <a href='/login.php'>login</a>";
}
?>

<html>
    <head>
        <title>BestBasket | Confirm</title>
    </head>
</html>
