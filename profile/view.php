<?php

include '../components/navbar.php';
include '../components/dbconnect.php';

session_start();

if (empty($_GET['id'])) {
    echo "404 error"; 
} else {
    
$user_id = $_GET['id'];

$sql = "SELECT type,display_name FROM accounts WHERE id = '$user_id';";
$result = $conn->query($sql);

if($result->num_rows <= 0){
    echo "404 error";
} else {
    
$row = $result->fetch_array(MYSQL_NUM);
$user_type = $row[0];
$user_display_name = $row[1];

?>

<html>
    
<head>
    <title><?=$user_display_name?>'s profile</title>
</head>

<body>
<div class="container">
<h1><?=$user_display_name?>'s profile <small><?=$user_type?></small></h1>

<?php
include '../components/calculate-awards.php';
?>

<!-- This form allows a profile to be reported -->
<form name="report" action="../report.php" method="POST">
    <input type="hidden" name="id" value="<?=$user_id?>">
    <br>
    <button name="submit" class="btn btn-danger btn-xs" type="submit">
        <i class="fa fa-flag" aria-hidden="true"></i> Report this user
    </button>
</form>

<h3>Reviews by <?=$user_display_name?>:</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Website</th>
            <th>Overall / 5</th>
            <th>Comment</th>
        </tr>
    </thead>
    <tbody>
<?php

$sql = "SELECT site_id,site_name,average,comment FROM reviews WHERE user_id = '$user_id';";
$result = $conn->query($sql);

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    printf ("<tr><td><a href='/website/view.php/?id=%s'>%s</a></td> <td><code>%s</code></td> <td>%s</td></tr>", $row[0], $row[1], $row[2], $row[3]);
}
}
}

?>
</div>
</body>
    
</html>