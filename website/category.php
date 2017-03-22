<?php

include '../components/navbar.php';

// Check for no category specified
if (empty($_GET['cat'])) {
    echo "404 error"; 
} else {

// The category is taken from the URL 
$category = $_GET['cat']; 

include '../components/dbconnect.php';

// The details of each website under that category are taken
$sql = "SELECT id,name,average,total_score FROM websites WHERE category = '$category' ORDER BY category DESC, total_score DESC";
$result = $conn->query($sql);

// Check for no results
if($result->num_rows <= 0){
    echo "There are no websites for that category yet. Consider <a href='../add.php'>adding one</a>";
} else {

// Print results in table
?>
<div class='container'>
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Average</th>
            <th>Total Score</th>
        </tr>
    </thead>
    <tbody>

<?php
while ($row = $result->fetch_array(MYSQL_NUM)) {
    printf("<tr><td><a href='/website/view.php/?id=%s'>%s </a></td><td>%s</td><td>%s</td></tr>", $row[0], $row[1], $row[2], $row[3]);
}
}
}
?>

</tbody>
</table>

<head>
    <title>BestBasket | <?=$category?></title>
</head>