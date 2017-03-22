<?php

include '../components/navbar.php';
include '../components/dbconnect.php';

session_start();

$user_id = $_SESSION['user_id'];
?>

<html>
    
<head>
    <title><?=$_SESSION['user_display_name']?>'s profile</title>
</head>

<body>
<div class="container">
<h1><?=$_SESSION['user_display_name']?>'s profile <small><?=$_SESSION['user_type']?></small></h1>
<?php
include '../components/calculate-awards.php';
?>
<h3>Reviews by <?=$_SESSION['user_display_name']?>:</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Website</th>
            <th>Overall / 5</th>
            <th>Comment</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
<?php

$sql = "SELECT id,site_id,site_name,average,comment FROM reviews WHERE user_id = '$user_id';";
$result = $conn->query($sql);

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    printf ("<tr><td><a href='/website/view.php/?id=%s'>%s</a></td> <td><code>%s</code></td> <td>%s</td><td>", $row[1], $row[2], $row[3], $row[4]);
?>

<form method="post">
    <input class="btn btn-danger btn-xs" type='submit' name='submit' value='Delete'>
</form>

<?php
if(isset($_POST['submit'])){
    $sql = "DELETE FROM `bestbasket`.`reviews` WHERE `reviews`.`id` = $row[0]";
    $result = $conn->query($sql);
    header("refresh:0");
}
}
?>
</div>
</body>
    
</html>

<!--
$sql = "SELECT id,site_id,site_name,overall,comment FROM reviews WHERE user_id = '$user_id';";
$result = $conn->query($sql);

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    printf ("<tr>
    <td><a href='/website/view.php/?id=%s'>%s</a></td>
    <td><code>%s</code></td>
    <td>%s</td>
    <td><form method='post'>
        <input name='request_delete' type='hidden' value='%s'>
        <input class='btn btn-danger btn-xs' type='submit' name='submit' value='Delete'>
    </form>", 
    $row[1], $row[2], $row[3], $row[4], $row[0]);

if(isset($_POST['submit'])){
    $request_delete = $_POST['request_delete'];
    $sql = "DELETE FROM `bestbasket`.`reviews` WHERE `reviews`.`id` = $request_delete";
    $result = $conn->query($sql);
    header("refresh:0");
}
}
-->