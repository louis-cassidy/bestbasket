<html>
    <head><title>BestBasket | Reports</title></head>
</html>

<?php

include '../components/navbar.php';
include '../components/dbconnect.php';

session_start();
if ($_SESSION['user_type'] != 'admin'){
    echo "You must be an admin to view this page";
} else {

// All sites that have been reported are displayed, ordered by most reports first
$sql = "SELECT id,display_name,reports FROM accounts WHERE reports > 0 ORDER BY reports DESC";
$result = $conn->query($sql);
?>
<div class="container">
<h1>Reported Users</h1>
<table class="table">
    <thead>
        <tr>
            <th>Display Name</th>
            <th>Reports</th>
            <th>View profile</th>
        </tr>
    </thead>
    <tbody>

<?php
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    printf ("<tr><td>%s</td><td>%s</td><td><a href='/profile/view.php/?id=%s'>View</a></td></tr>", $row[1], $row[2], $row[0], $row[0]);
}
?>

    </tbody>
</table>

<!-- The table is created -->
<h1>Reported Websites</h1>
<table class="table">
    <thead>
        <tr>
            <th>Site Name</th>
            <th>Reports</th>
            <th>View site</th>
        </tr>
    </thead>
    <tbody>

<?php
$sql = "SELECT id,name,reports FROM websites WHERE reports > 0 ORDER BY reports DESC";
$result = $conn->query($sql);
while ($row = $result->fetch_array(MYSQLI_NUM)) {
    // The body of the table is continually filled as long as there are still results being returned
    printf ("<tr><td>%s</td><td>%s</td><td><a href='/profile/view.php/?id=%s'>View</a></td></tr>",
    $row[1], $row[2], $row[0], $row[0]);
}
}
?>

<!-- The table is ended -->
    </tbody>
</table>
</div>