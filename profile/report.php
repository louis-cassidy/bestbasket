<?php

include '../components/navbar.php';
include '../components/dbconnect.php';

$reported_user_id = $_POST['id'];

if(isset($_POST['submit'])) {
    $sql = "UPDATE `bestbasket`.`accounts` SET `reports` = `reports` + 1 WHERE `accounts`.`id` = $reported_user_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Thank you for your report. The user will be reviewed shortly.";
    }else{
        echo "Error submitting report.";
    }
}

?>