<?php
$servername = "localhost";
$username = "louiscassidy";
$password = "";
$dbname = "bestbasket";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error: " . $conn->connect_error);
}
?>