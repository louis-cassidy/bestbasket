<?php

include '../components/navbar.php';

if (empty($_GET['id'])) {
    echo "404 error"; // If the user has arrived at the page by typing the URL and not specifying a site ID, give a 404 error
} else {
$siteid = $_GET['id']; // The site ID found in the URL is saved in a variable

include '../components/dbconnect.php';

$sql = "SELECT name,url,category FROM websites WHERE id = '$siteid';"; // The requested site's information is selected from the database
$result = $conn->query($sql);

// If there are no results, the site does not exist in the database so a 404 error is given
if($result->num_rows <= 0){
    echo "404 error";
} else {

// If results are found, they are put into an array and then saved to variables
$row = $result->fetch_array(MYSQL_NUM);
$sitename = $row[0];
$siteurl = $row[1];
$sitecategory = $row[2];

// The site's details can be echoed to the page
echo "<div class='container'><h1>" . $sitename . "'s reviews <small> " . $siteurl . "</small></h1>";

// The average and total scores are found
$sql = "SELECT average,total_score FROM websites WHERE id = '$siteid';";
$result = $conn->query($sql);
$row = $result->fetch_array(MYSQL_NUM);

$site_average = $row[0];
$site_total = $row[1];

?>
<h4>Average: <span class="label label-success"><?=$site_average?></span></h4>
<h4>Total: <span class="label label-primary"><?=$site_total?></span></h4>
<?php
echo "<a class='btn btn-warning btn-xs' href='/website/review.php/?id=" 
. $siteid . 
"' role='button'><i class='fa fa-pencil' aria-hidden='true'></i>Review this site</a><br><br>";

?>
<form name="report" action="../report.php" method="POST">
    <input type="hidden" name="id" value="<?=$siteid?>">
    <button name="submit" class="btn btn-danger btn-xs" type="submit"><i class="fa fa-flag" aria-hidden="true"></i> Report this site</button>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>User</th>
            <th>Delivery / 5</th>
            <th>Value for money / 5</th>
            <th>Payment options / 5</th>
            <th>Reliability / 5</th>
            <th>Overall / 5</th>
            <th>Comment</th>
            <?php
            if ($_SESSION["user_type"] == 'admin'){
                ?>
                <th>Delete</th>
                <?php
            }
            ?>
        </tr>
    </thead>
    <tbody>
<?php
$sql = "SELECT * FROM reviews WHERE site_id = '$siteid';";
$result = $conn->query($sql);

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    printf ("<tr><td><a href='/profile/view.php/?id=%s'>%s</a></td><td>%s</td> <td>%s</td> <td>%s</td> <td>%s</td> <td><code>%s</code></td> <td>%s</td>",
    $row[1], $row[2], $row[5], $row[6], $row[7], $row[8], $row[9], $row[10]);
    if ($_SESSION["user_type"] == 'admin') {
?>
<td>
<form method="post">
    <input class="btn btn-danger btn-xs" type='submit' name='submit' value='Delete'>
</form>
</td>
<?php
    if(isset($_POST['submit'])){
        $sql = "DELETE FROM `bestbasket`.`reviews` WHERE `reviews`.`id` = $row[0]";
        $result = $conn->query($sql);
        header("refresh:0");
    }
    }
    ?>
    </tr>
    <?php
}
} 
}
?>

<html>
    <head>
        <title>BestBasket | <?=$sitename?>'s reviews</title>
    </head>
</html>