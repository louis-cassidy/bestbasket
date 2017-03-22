<?php

include '../components/navbar.php';

session_start();

// The session variables are unset and the session is destroyed
session_unset();
session_destroy();

echo "Your account was deleted";
header("refresh:3;url=/home.php");

?>