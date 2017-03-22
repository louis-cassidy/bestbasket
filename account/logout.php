<?php

include '../components/navbar.php';

session_start();

// The session variables are unset and the session is destroyed
session_unset();
session_destroy();

echo "You have been logged out. Redirecting...";
header("refresh:2;url=/index.php");

?>

<html>
    <head>
        <title>BestBasket | Logout</title>
    </head>
</html>