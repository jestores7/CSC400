<?php
session_start();
$values = null;
include ("dbconnection.php");
?>

<!DOCTYPE html>
<html>
<head>
<title> Users Page </title>
<link href="./css/style.css" rel="stylesheet" media="screen">
</head>

  <body>
    <div class="container">
    <h2> Welcome  <?php echo $_SESSION['userSession'] ?>!!
      <a href="logout.php?logout" class="btn btn-default" style="float:right;">Log Out</a></h1>
    </h2><hr/>
    <header>
      <nav>
        <ul>
          <li><a href="home.php"></span>&nbsp; Home</a></li>
          <li><a href = "userInfo.php">Enter/Edit User Information </a></li>
          <li>  <a href = "viewUserInfo.php">View Macros/Meals</a></li>
          <li>  <a href = "meals.php">Meals</a></li>
        </ul>
      </nav>
    </header>
  </div>
</body>
</html>
