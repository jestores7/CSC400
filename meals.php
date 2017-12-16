<?php
session_start();
if (isset($_SESSION['userSession']) == FALSE)
{
	header("Location: index.php");
}
include("dbconnection.php");
$email = $_SESSION['email'];


if(isset($_POST['own-food']))
{
	// $sql = $conn->query("SELECT * From nutritiondb");

	$Food = strip_tags($_POST['Food']);
	$Calories = strip_tags($_POST['Calories']);
	$Protein = strip_tags($_POST['Protein']);
	$Carbohydrates = strip_tags($_POST['Carbohydrates']);
	$Fat = strip_tags($_POST['Fat']);
	$Desc = strip_tags($_POST['Desc']);

	$Food = $conn->real_escape_string($Food);
	$Calories = $conn->real_escape_string($Calories);
	$Protein = $conn->real_escape_string($Protein);
	$Carbohydrates = $conn->real_escape_string($Carbohydrates);
	$Fat = $conn->real_escape_string($Fat);
	$Desc = $conn->real_escape_string($Desc);

  $query = "INSERT INTO meals(email,Food, Calories, Protein, Carbohydrates, Fat, Description) VALUES('$email','$Food','$Calories','$Protein','$Carbohydrates','$Fat','$Desc')";
  if ($conn->query($query))
  {
    $msg =
    "<br>
    <div class='alert alert-success'>
    Inserted Into Your Planner!
    </div>";
  }else
  {
    $msg = "<div class='alert alert-danger'>
    <span class='glyphicon glyphicon-info-sign'></span>Error While Inserting into Planner!
    </div>";
  }
}

if(isset($_POST['btn-food']))
{
	// $sql = $conn->query("SELECT * From nutritiondb");
	$EnteredFood = strip_tags($_POST['EnteredFood']);
	$sql = $conn->query("SELECT Shrt_Desc, Energ_Kcal, `Protein_(g)`, `Lipid_Tot_(g)`, `Carbohydrt_(g)`, GmWt_Desc2 From nutritiondb where Shrt_Desc='$EnteredFood'");
	$row= $sql->fetch_assoc();
	$Desc = $row['GmWt_Desc2'];
	$Food = $row['Shrt_Desc'];
	$Calories = $row['Energ_Kcal'];
	$Protein = $row['Protein_(g)'];
	$Fat = $row['Lipid_Tot_(g)'];
	$Carbohydrates = $row['Carbohydrt_(g)'];


	$Food = $conn->real_escape_string($Food);

  $query = "INSERT INTO meals(email,Food, Calories, Protein, Carbohydrates, Fat, Description) VALUES('$email','$Food','$Calories','$Protein','$Carbohydrates','$Fat','$Desc')";
  if ($conn->query($query))
  {
    $msg =
    "<br>
    <div class='alert alert-success'>
    Inserted Into Your Planner!
    </div>";
  }else
  {
    $msg = "<div class='alert alert-danger'>
    <span class='glyphicon glyphicon-info-sign'></span>Error While Inserting into Planner!
    </div>";
  }
}
$conn->close();
?>
<!DOCTYPE html>
<head>
  <title>View Meals</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link href="./css/style.css" rel="stylesheet" media="screen">
	<script>
		$(function()
		{
		 $( "#Shrt_Desc" ).autocomplete({
		  source: 'autocomplete.php',
			minLength: 3
		 });
		});
		</script>


</head>
<body>
  <div class="signin-form">
    <div class="container">

        <h2 class="form-signin-heading">Meals
        <a href="logout.php?logout" class="btn btn-default" style="float:right;">Log Out</a></h1>
      </h2><hr />
			<ul>
				<li><a href="home.php"></span>Home</a></li>
				<li><a href = "userInfo.php">Enter/Edit User Information </a></li>
				<li>  <a href = "viewUserInfo.php">View Macros/Meals</a></li>
				<li>  <a href = "meals.php">Meals</a></li>
			</ul>
        <br>
				<?php
				if (isset($msg)) {
					echo $msg;
				} ?>
				<form method="post">
				<div class="ui-widget">
				 <p>Enter Food</p>
				 <input type="text" id="Shrt_Desc" name = "EnteredFood">
				 <button type="submit" name = "btn-food"> Submit </button>
				</div>
			</form>
				<br>
				<form  method="post">
				<?php
				if(isset($_POST['btn-Sugg']))
				{
					include("dbconnection.php");

					$email = $_SESSION['email'];
					$sql = $conn->query("SELECT email, sum(Protein) as SumPro, sum(Calories) as SumCal, SUM(Carbohydrates) as SumCar, SUM(Fat) as SumFat  FROM `meals` WHERE email = '$email'");
					$row= $sql->fetch_assoc();
					$SumPro = $row['SumPro'];
					$SumCal = $row['SumCal'];
					$SumCar = $row['SumCar'];
					$SumFat = $row['SumFat'];

					$sql = $conn->query(
					"SELECT `Shrt_Desc`,`Energ_Kcal`, `Protein_(g)`,`Lipid_Tot_(g)`,`Carbohydrt_(g)`,`GmWt_Desc2`FROM userinfo AS u, nutritiondb AS n\n" . "	
					WHERE n.`Protein_(g)` < (u.`Protein` - '$SumPro') AND n.`Carbohydrt_(g)` < (u.`Carbohydrates` - '$SumCar')
					AND n.`Energ_Kcal` < (u.`Calories` - '$SumCal')
					AND n.`Lipid_Tot_(g)` < (u.`Fat` - '$SumFat')
					AND `GmWt_Desc2` <> \" \"\n" . "
					ORDER BY RAND() LIMIT 5");
					echo("<table>");
					echo "<tr><th>Food</th><th>Calories</th><th>Fat</th><th>Carbohydrates</th><th>Protein</th><th>Serving Size</th></tr>";
					$first_row = true;

					while ($row= $sql->fetch_assoc()) {

						$Shrt_Desc = $row['Shrt_Desc'];
						$Energ_Kcal = $row['Energ_Kcal'];
						$Protein_ = $row['Protein_(g)'];
						$Lipid_Tot_ = $row['Lipid_Tot_(g)'];
						$Carbohydrt_ = $row['Carbohydrt_(g)'];
						$GmWt_Desc2	 = $row['GmWt_Desc2'];


						echo "<tr><td>".$Shrt_Desc."</td><td>".$Energ_Kcal."</td><td>".$Lipid_Tot_."</td><td>".$Carbohydrt_."</td><td>".$Protein_."</td><td>".$GmWt_Desc2."</td></tr>";

					}
					echo("</table>");
				}

				?>
				<br>
				<button type="submit" name="btn-Sugg"> Suggestions </button>
				<br>
				<br>
				</form>

				<form method="post">
				<div class="form-group">
				<input type="text" class="form-control" placeholder="Food" name="Food" required  />
				</div>
				<div class="form-group">
				<input type="number" class="form-control" placeholder="Calories" name="Calories" required  />
				</div>
				<div class="form-group">
				<input type="number" class="form-control" placeholder="Protein" name="Protein" required  />
				</div>
				<div class="form-group">
				<input type="number" class="form-control" placeholder="Carbohydrates" name="Carbohydrates" required  />
				</div>
				<div class="form-group">
				<input type="number" class="form-control" placeholder="Fat" name="Fat" required  />
				</div>
				<div class="form-group">
				<input type="hidden" class="form-control" value="" name="Desc" required  />
				</div>
				<button type="submit" name="own-food"> Enter Own Food </button>
			</form>

			</div>
		</div>


</body>
</html>
