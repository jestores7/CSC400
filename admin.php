<?php
session_start();
if (isset($_SESSION['userSession']) == FALSE)
{
	header("Location: index.php");
}

include("dbconnection.php");
?>

<!DOCTYPE html>
<html>
<title> Admin Page </title>
<link href="./css/style.css" rel="stylesheet" media="screen">
  <Body>
    <h1> Welcome <?php echo $_SESSION['userSession'] ?>!! </h1>
  </Body>
	<div class="form-group">
		<a href="adminRegistration.php" class="btn btn-default">Create an Admin</a>
		<a href="logout.php?logout" class="btn btn-default" style="float:right;">Log Out</a>
	</form>
</html>
