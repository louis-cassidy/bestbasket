<head>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/components/font-awesome-4.7.0/css/font-awesome.min.css">
</head>


<?php
session_start();

if(!isset($_SESSION['user_id']) or empty($_SESSION['user_id'])){
?>

<!-- This is the navbar that will be displayed to a user that is not logged in -->  
<nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/index.php">Home</a></li>
      <li><a href="/explore.php">Explore</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/account/login.php">Login</a></li>
          <li><a href="/account/register.php">Register</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<?php
} else {
?>
    
<!-- This is the navbar that will be displayed to a user that is logged in --> 
<nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <ul class="nav navbar-nav navbar-right">
      <li><a href="/index.php">Home</a></li>
      <li><a href="/explore.php">Explore</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?=$_SESSION["user_display_name"]?>'s account <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/profile/me.php">Your profile</a></li>
          <li><a href="/account/settings.php">Account settings</a></li>
          <li><a href="/account/logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<?php
}
?>