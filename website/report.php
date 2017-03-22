<?php

include '../components/navbar.php';
include '../components/dbconnect.php';

$reported_site_id = $_POST['id'];

if(isset($_POST['submit'])) {
    $sql = "UPDATE `bestbasket`.`websites` SET `reports` = `reports` + 1 WHERE `websites`.`id` = $reported_site_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Thank you for your report. The website will be reviewed shortly.";
    }else{
        echo "Error submitting report.";
    }
}

?>