<?php
session_start();
if (isset($_SESSION['userSession'])!="") {
	header("Location: home.php");
}
include("dbconnection.php");

if(isset($_POST['btn-signup'])) {

	$uname = strip_tags($_POST['userName']);
	$email = strip_tags($_POST['email']);
	$upass = strip_tags($_POST['password']);
	$hashPass = password_hash($upass, PASSWORD_DEFAULT);
	$status = strip_tags($_POST['status']);

	$uname = $conn->real_escape_string($uname);
	$email = $conn->real_escape_string($email);
	$upass = $conn->real_escape_string($upass);
	$status = $conn->real_escape_string($status);

	$check_email = $conn->query("SELECT email FROM users WHERE email='$email'");
	$count=$check_email->num_rows;

	if ($count==0) {

		$query = "INSERT INTO users(userName,email,password,status) VALUES('$uname','$email','$hashPass','$status')";

		if ($conn->query($query)) {
			$msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
					</div>";
		}else {
			$msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
					</div>";
		}

	} else {


		$msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry email already taken !
				</div>";

	}

	$conn->close();
}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login & Registration System</title>
<link href="./css/style.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="signin-form">
	<div class="container">
       <form class="form-signin" method="post" id="register-form">
        <h2 class="form-signin-heading">Sign Up</h2><hr />
        <?php
		if (isset($msg)) {
			echo $msg;
		}
		?>
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="userName" required  />
        </div>
        <div class="form-group">
        <input type="email" class="form-control" placeholder="Email address" name="email" required  />
        <span id="check-e"></span>
        </div>
        <div class="form-group">
        <input type="password" class="form-control" placeholder="Password" name="password" required  />
        </div>
				<div class="form-group">
        <input type="hidden" class="form-control" value="0" name="status" required  />
        </div>
     	<hr />
        <div class="form-group">
            <button type="submit" class="btn btn-default" name="btn-signup">
    		<span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
			</button>
            <a href="index.php" class="btn btn-default" style="float:right;">Log In Here</a>
        </div>
      </form>
    </div>
</div>
</body>
</html>
