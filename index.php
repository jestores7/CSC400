<?php
session_start();
include("dbconnection.php");

if (isset($_POST['btn-login'])) {

	$email = strip_tags($_POST['email']);
	$password = strip_tags($_POST['password']);

	$email = $conn->real_escape_string($email);
	$password = $conn->real_escape_string($password);
	$query = $conn->query("SELECT * FROM users WHERE email='$email'");
	$row=$query->fetch_array();
  $user_Status = $row['status'];
	$count = $query->num_rows; // if email/password are correct returns must be 1 row
	$hashPass = $row['password']; 

	if(password_verify($password, $hashPass) && $count==1 && $user_Status == 1)
  {
    $_SESSION['userSession'] = $row['userName'];
		$_SESSION['email'] = $email;
		header("Location: admin.php");
  }
	elseif (password_verify($password, $hashPass) && $count==1 && $user_Status == 0)
  {
		$_SESSION['userSession'] = $row['userName'];
		$_SESSION['email'] = $email;
		header("Location: home.php");
	}
  else {
		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
				</div>";
	}
	$conn->close();
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href="./css/style.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="signin-form">
	<div class="container">
       <form class="form-signin" method="post" id="login-form">
        <h2 class="form-signin-heading">Sign In.</h2><hr />
        <?php
		if(isset($msg)){
			echo $msg;
		}
		?>
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required />
        </div>
     	<hr />
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
			</button>
            <a href="register.php" class="btn btn-default" style="float:right;">Sign Up</a>
        </div>
      </form>
    </div>
</div>
</body>
</html>
