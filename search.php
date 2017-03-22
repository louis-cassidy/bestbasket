<html>
    <head><title>BestBasket | Search</title></head>
</html>

<?php

include '../components/navbar.php';

include '../components/dbconnect.php';

$s_query = $_POST['s_query'];

?>
<div class='container'>
<form class="form-inline" action="search.php" method="post">
    <div class="form-group">
        <input type="text" class="form-control" name="s_query" placeholder="Search again...">
    </div>
    <button type="submit" class="btn btn-info">Search</button>
</form>


<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>URL</th>
            <th>Category</th>
            <th>Average score</th>
            <th>Total score</th>
        </tr>
    </thead>
    <tbody>
<?php

$sql = "SELECT id,name,url,category,average,total_score FROM websites
        WHERE name LIKE '%" . $s_query . "%' OR url LIKE '%" . $s_query . "%'
        ORDER BY average DESC, total_score DESC;";
$result = $conn->query($sql);

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    printf ("<tr><td><a href='/website/view.php/?id=%s'>%s </a></td> <td>%s </td> <td>%s </td>
            <td><span class='label label-success'> %s</span></td><td><span class='label label-primary'>%s</span></td></tr>",
            $row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
}

?>