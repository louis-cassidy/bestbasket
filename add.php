<html>
    <head>
        <script src="/js/jquery.min.js"></script>
        <script src="/node_modules/bootstrap-validator/js/validator.js"></script>
        <title>BestBasket | Add Website</title>
    </head>
</html>

<?php
include '../components/navbar.php';

session_start();
// Check if the session variables are filled. If they aren't, deny access.
if(!isset($_SESSION["user_id"]) && empty($_SESSION["user_id"])) {
   echo 'You must be logged in to access this page.';
} else {
?>

<html>
<div class="container">
<form name="add" action="<?=$_SERVER['PHP_SELF']?>" method="post" data-toggle="validator">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <label>Website name:</label>
                <input style="text-transform: capitalize;" class="form-control" type="text" name="name" data-error="You must fill this in!" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <label>URL:</label>
                <input class="form-control" type="url" name="url" data-error="Please enter a URL in the format: http://example.com" required>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">
                <label>Category:</label>
                <select class="form-control" name="category">
                    <option value="books">Books & Audio Books</option>
                    <option value="movies_tv_music">Movies, TV & Music</option>
                    <option value="electronics">Electronics</option>
                    <option value="home_garden_diy">Home, Garden & DIY</option>
                    <option value="toys_children">Toys & Children</option>
                    <option value="clothes_shoes_jewellery">Clothes, Shoes & Jewellery</option>
                    <option value="sports_outdoors">Sports & Outdoors</option>
                    <option value="beauty_health">Beauty & Health</option>
                    <option value="groceries">Groceries</option>
                    <option value="cars">Cars</option>
                    <option value="work_business">Work & Business</option>
                    <option value="variety">Variety</option>
                    <option value="other">Other</option>
                </select>
            </div>
        </div>
    </div>
    <input class="btn btn-info" type="submit" name="submit">
</form>
</div>
</html>

<?php
include '../components/dbconnect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $url = $_POST['url'];
    $category = $_POST['category'];
    
    $sql = "INSERT INTO websites (id, name, url, category) VALUES (NULL, '$name', '$url', '$category')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Website added";
    }else{
        echo "Error";
    }
    
    $conn->close();
}
}
?>