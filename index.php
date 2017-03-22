<?php

include 'components/navbar.php';

session_start();

?>
<html>
<head>
    <title>BestBasket | Home</title>
</head>
<body>
<center>
<div class="container"> 
    <h1>Welcome to BestBasket</h1>
    
    <form class="form-inline" action="search/search.php" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="s_query" placeholder="Search...">
        </div>
        <button type="submit" class="btn btn-info">Search</button>
    </form>
    
    <h4><a href="/website/add.php">Can't find what you're looking for?</a></h4>
    
</div>
</center>
</body>    
</html>