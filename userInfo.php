<?php
session_start();
if (isset($_SESSION['userSession']) == FALSE)
{
	header("Location: index.php");
}

include("dbconnection.php");

$email = $_SESSION['email'];
$sql = $conn->query("SELECT Age, Weight, HeightFT, HeightIN, Gender, ActivityLvl, Goal, BMR From userinfo where email = '$email'");
$row= $sql->fetch_assoc();

$Age = $row['Age'];
$Weight = $row['Weight'];
$HeightFT = $row['HeightFT'];
$HeightIN = $row['HeightIN'];
$Gender = $row['Gender'];
$ActivityLvl = $row['ActivityLvl'];
$Goal = $row['Goal'];
$BMR = $row['BMR'];


if(isset($_POST['btn-enterInf'])) {

	$email = $_SESSION['email'];
	$Age = strip_tags($_POST['Age']); //
	$Weight = strip_tags($_POST['Weight']); //
	$HeightFT = strip_tags($_POST['HeightFT']);
	$HeightIN = strip_tags($_POST['HeightIN']);
	$Gender = strip_tags($_POST['Gender']);	//
	$ActivityLvl = strip_tags($_POST['ActivityLvl']);	//
	$Goal = strip_tags($_POST['Goal']);	//
	$Meals = strip_tags($_POST['Meals']);	//
	$Calories = strip_tags($_POST['Calories']);	//
	$Fat = strip_tags($_POST['Fat']); //
	$Carbohydrates = strip_tags($_POST['Carbohydrates']); //
	$Protein = strip_tags($_POST['Protein']); //
	$BMR = strip_tags($_POST['BMR']); //

	// $email = $conn->real_escape_string($email);
	$Age = $conn->real_escape_string($Age);
	$Weight = $conn->real_escape_string($Weight);
	$HeightFT = $conn->real_escape_string($HeightFT);
	$HeightIN = $conn->real_escape_string($HeightIN);
	$Gender = $conn->real_escape_string($Gender);
	$ActivityLvl = $conn->real_escape_string($ActivityLvl);
	$Goal = $conn->real_escape_string($Goal);
	$Meals = $conn->real_escape_string($Meals);
	$Calories = $conn->real_escape_string($Calories);
	$Fat = $conn->real_escape_string($Fat);
	$Carbohydrates = $conn->real_escape_string($Carbohydrates);
	$Protein = $conn->real_escape_string($Protein);
	$BMR = $conn->real_escape_string($BMR);


	$check_info = $conn->query("SELECT email FROM userInfo WHERE email='$email'");
	$count=$check_info->num_rows;

	if ($count==0) {
		$query = "INSERT INTO userinfo(email,Age,Weight,HeightFt,HeightIn,Gender,ActivityLvl,Goal,Meals,Calories,Fat,Carbohydrates,Protein,BMR) VALUES('$email', '$Age', '$Weight','$HeightFT','$HeightIN','$Gender','$ActivityLvl', '$Goal', '$Meals', '$Calories', '$Fat','$Carbohydrates','$Protein','$BMR')";
		if ($conn->query($query)) {

			$BMR = (10 * ($Weight * .454)) + 6.25 * ((($HeightFT*12)+$HeightIN)*2.54) - 5 * $Age + $Gender;
			##Calories is TDEE (Total Daily Energy Expenditure)
			$Calories = ($BMR * $ActivityLvl) * $Goal;
			####note that all the values are how many grams a person should be intaking
			#1g of Fat = 9 Calories
			$Fat = (.20 * $Calories)/9;
			#1g Protein = 4 Calories
			$Protein = (.82 * $Weight);
			#1g Carbs = 4 Calories
			$Carbohydrates = (($Calories-($Protein*4)) - ($Fat*9))/4;

			$macros = $conn->query("UPDATE userinfo SET Calories = '$Calories', Fat = '$Fat', Carbohydrates = '$Carbohydrates', Protein = '$Protein', BMR = '$BMR' WHERE email = '$email'");
			$msg = "<div class='alert alert-success'>
			<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Successfully Entered User Data !
			</div>";
		}else {
			$msg = "<div class='alert alert-danger'>
			<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error While Entering Data !
			</div>";
		}
	}
	else {
		$msg = "<div class='alert alert-danger'>
		<span class='glyphicon glyphicon-info-sign'></span> &nbsp; User Information already exists!
		</div>";
	}

}

if(isset($_POST['btn-updateInf'])) {

	$email = $_SESSION['email'];
	$Age = strip_tags($_POST['Age']); //
	$Weight = strip_tags($_POST['Weight']); //
	$HeightFT = strip_tags($_POST['HeightFT']);
	$HeightIN = strip_tags($_POST['HeightIN']);
	$Gender = strip_tags($_POST['Gender']);	//
	$ActivityLvl = strip_tags($_POST['ActivityLvl']);	//
	$Goal = strip_tags($_POST['Goal']);	//
	$Meals = strip_tags($_POST['Meals']);	//
	$Calories = strip_tags($_POST['Calories']);	//
	$Fat = strip_tags($_POST['Fat']); //
	$Carbohydrates = strip_tags($_POST['Carbohydrates']); //
	$Protein = strip_tags($_POST['Protein']); //
	$BMR = strip_tags($_POST['BMR']); //

	// $email = $conn->real_escape_string($email);
	$Age = $conn->real_escape_string($Age);
	$Weight = $conn->real_escape_string($Weight);
	$HeightFT = $conn->real_escape_string($HeightFT);
	$HeightIN = $conn->real_escape_string($HeightIN);
	$Gender = $conn->real_escape_string($Gender);
	$ActivityLvl = $conn->real_escape_string($ActivityLvl);
	$Goal = $conn->real_escape_string($Goal);
	$Meals = $conn->real_escape_string($Meals);
	$Calories = $conn->real_escape_string($Calories);
	$Fat = $conn->real_escape_string($Fat);
	$Carbohydrates = $conn->real_escape_string($Carbohydrates);
	$Protein = $conn->real_escape_string($Protein);
	$BMR = $conn->real_escape_string($BMR);


		$query = "UPDATE userinfo SET Age = '$Age', Weight ='$Weight', HeightFT='$HeightFT', HeightIN='$HeightIN', Gender='$Gender', ActivityLvl='$ActivityLvl', Goal ='$Goal', Meals = '$Meals',  Calories = '$Calories', Fat = '$Fat', Carbohydrates = '$Carbohydrates', Protein = '$Protein', BMR ='$BMR' WHERE email='$email'";
		if ($conn->query($query))
		{
			$BMR = (10 * ($Weight * .454)) + 6.25 * ((($HeightFT*12)+$HeightIN)*2.54) - 5 * $Age + $Gender;
			##Calories is TDEE (Total Daily Energy Expenditure)
			$Calories = ($BMR * $ActivityLvl) * $Goal;
			####note that all the values are how many grams a person should be intaking
			#1g of Fat = 9 Calories
			$Fat = (.20 * $Calories)/9;
			#1g Protein = 4 Calories
			$Protein = (.82 * $Weight);
			#1g Carbs = 4 Calories
			$Carbohydrates = (($Calories-($Protein*4)) - ($Fat*9))/4;
			$macros = $conn->query("UPDATE userinfo SET Calories = '$Calories', Fat = '$Fat', Carbohydrates = '$Carbohydrates', Protein = '$Protein', BMR = '$BMR' WHERE email = '$email'");
			$msg = "<div class='alert alert-success'>
			Updated Information!
			</div>";
		}else
		{
			$msg = "<div class='alert alert-danger'>
			<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error While Updating Information!
			</div>";
		}
	}
		$conn->close();
?>

<!DOCTYPE html>
<head>

	<title>User Information</title>

	<link href="./css/style.css" rel="stylesheet" media="screen">
</head>
<body>
	<div class="signin-form">
		<div class="container">
			<form class="form-signin" method="post" id="register-form">
				<h2 class="form-signin-heading">Enter/Edit Your Information
				<a href="logout.php?logout" class="btn btn-default" style="float:right;">Log Out</a></h1>
				</h2><hr />
				<ul>
					<li><a href="home.php"></span>&nbsp; Home</a></li>
					<li><a href = "userInfo.php">Enter/Edit User Information </a></li>
					<li>  <a href = "viewUserInfo.php">View Macros/Meals</a></li>
					<li>  <a href = "meals.php">Meals</a></li>
				</ul>
				<br>
				<?php
				if (isset($msg)) {
					echo $msg;
				}
				?>
				<br>
				<div class="form-group">
					<input type="number" class="form-control" placeholder="Age" name="Age" min ="1" max = "100" required  />
					<br>
					Current Age: <?php echo $Age ?>
				</div>
				<br>
				<div class="form-group">
					<input type="number" class="form-control" placeholder="Weight (Pounds)" name="Weight" min ="1" max = "500" required  />
					<br>
					Current Weight (lbs): <?php echo $Weight ?>
				</div>
				<br>
				<div class="form-group">
					<input type="number" class="form-control" placeholder="Height (Feet)" name="HeightFT" min ="1" max = "10" required  />
					<br>
					Current Height(Feet): <?php echo $HeightFT ?>
				</div>
				<br>
				<div class="form-group">
					<input type="number" class="form-control" placeholder="Height (Inches)" name="HeightIN" min ="1" max = "12" required  />
					<br>
					Current Height(Inches): <?php echo $HeightIN ?>
				</div>
				<br>
				<div class="form-group">
					<input type="hidden" class="form-control" placeholder="Meals" name="Meals" value= "1" min ="1" max = "8"   />
				</div>
				<br>

				<div class="form-group">
					<select name="Gender" required  />
					<option value="" disabled selected>Gender</option>
					<option value = "5"> Male </option>
					<option value = "-161"> Female </option>
				</select>
				<br>
				<br>

			</div>
			<br>

			<div class="form-group">
				<select name="ActivityLvl" required/>
				<option value="" disabled selected>Activity level</option>
				<option value = "1.30"> Sedentary </option>
				<option value = "1.65"> Moderate </option>
				<option value = "1.80"> Intense </option>
			</select>
			<br>
			<br>

		</div>
		<br>

		<div class="form-group">
			<select name="Goal" required/>
			<option value="" disabled selected>Goal</option>
			<!-- Decrease Calorie intake by 25%, Maintain or increase by 20% -->
			<option value = ".75"> Lose Weight </option>
			<!-- Approx 1.5 lbs a week -->
			<option value = "1"> Maintain </option>
			<!-- Approx 1.5 lbs a week -->
			<option value = "1.2"> Gain </option>
		</select>
		<br>
		<br>
	</div>
	<br>



	<div class="form-group">
		<input type="hidden" class="form-control" Value="0" name="BMR"  />
	</div>
	<div class="form-group">
		<input type="hidden" class="form-control" Value="0" name="Calories"  />
	</div>
	<div class="form-group">
		<input type="hidden" class="form-control" Value="0" name="Fat"  />
	</div>
	<div class="form-group">
		<input type="hidden" class="form-control" Value="0" name="Carbohydrates"   />
	</div>
	<div class="form-group">
		<input type="hidden" class="form-control" Value="0" name="Protein"  />
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-default" name="btn-enterInf">
			<span class="glyphicon glyphicon-log-in"></span> &nbsp; Enter Data
		</button>
		<button type="submit" class="btn btn-default" name="btn-updateInf">
			<span class="glyphicon glyphicon-log-in"></span> &nbsp; Update Data
		</button>
	</div>
	</div>
</form>

</div>
</div>
</body>
</html>
