<?php

include '../components/dbconnect.php';

// The points for the user are found in the database
$sql = "SELECT points FROM accounts WHERE id = $user_id";
$result = $conn->query($sql);
$row = $result->fetch_array(MYSQL_NUM);
$pts = $row[0];

// Awards //
// 0 = New user
// 1 = New reviewer
// 3 = Reviewer
// 5 = Experienced reviewer
// 10 = Frequent reviewer
// 20 = Top contributer

// Each statement checks for their points and sets the badge
if ($pts == 0){
?>
<span class="label label-default">New user</span>
<?php
} elseif ($pts < 3){
?>
<span class="label label-primary">New reviewer</span>
<?php
} elseif ($pts < 5){
?>
<span class="label label-success">Reviewer</span>
<?php
} elseif ($pts < 10){
?>
<span class="label label-info">Experienced reviewer</span>
<?php
} elseif ($pts < 20){
?>
<span class="label label-warning">Frequent reviewer</span>
<?php
} else {
?>
<span class="label label-danger">Top contributer</span>
<?php
}

?>
