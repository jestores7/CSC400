<?php
session_start();
if (isset($_SESSION['userSession']) == FALSE)
{
  header("Location: index.php");
}
include("dbconnection.php");



$email = $_SESSION['email'];
$sql = $conn->query("SELECT * From userinfo where email = '$email'");
$row= $sql->fetch_assoc();

$Calories = $row['Calories'];
$Fat= $row['Fat'];
$Carbohydrates = $row['Carbohydrates'];
$Protein = $row['Protein'];
#The BMR Formula is used by the ADA (American Dietetic Assc). Known as Mifflin - St Jeor Fromula

$sql = $conn->query("SELECT email, sum(Protein) as SumPro, sum(Calories) as SumCal, SUM(Carbohydrates) as SumCar, SUM(Fat) as SumFat  FROM `meals` WHERE email = '$email'");
$row= $sql->fetch_assoc();
$SumPro = $row['SumPro'];
$SumCal = $row['SumCal'];
$SumCar = $row['SumCar'];
$SumFat = $row['SumFat'];


if(isset($_POST['btn-DelAllfood']))
{
  $query = "DELETE FROM meals WHERE email='$email'";
  if ($conn->query($query))
  {
    $msg =
    "<br>
    <div class='alert alert-success'>
    Emptied Your Planner!
    </div>";
  }else
  {
    $msg = "<div class='alert alert-danger'>
    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error While Emptying Planner!
    </div>";
  }
}

if(isset($_POST['btn-Delfood']))
{
  $DeleteFoodID = strip_tags($_POST['DeleteFoodID']); //
  $query = "DELETE FROM meals WHERE email='$email' AND MealID='$DeleteFoodID'";
  if ($conn->query($query))
  {
    $msg =
    "<br>
    <div class='alert alert-success'>
    Deleted From Your Planner!
    </div>";
  }else
  {
    $msg = "<div class='alert alert-danger'>
    <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Error While Deleting from Planner!
    </div>";
  }
}
$conn->close();
?>
<!DOCTYPE html>
<head>
  <title>View User Information</title>
  <link href="./css/style.css" rel="stylesheet" media="screen">

</head>
<body>
  <div class="signin-form">
    <div class="container">
      <form class="form-signin" method="post" id="register-form">
        <h2 class="form-signin-heading">View User Information
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

      <table>
        <caption> Your Total Macros </caption>
              <tr>
                <th>Calories</th>
                <th>Fat</th>
                <th>Carbohydrates</th>
            		<th>Protein</th>
              </tr>
              <tr>
                <td><?php echo round($Calories); ?></td>
                <td><?php echo round($Fat); ?></td>
                <td><?php echo round($Carbohydrates); ?></td>
            		<td><?php echo round($Protein); ?></td>
              </tr>
            </table>
            <br>


        <table>

          <caption> Remaining Macros </caption>
                <tr>
                  <th>Calories</th>
                  <th>Fat</th>
                  <th>Carbohydrates</th>
              		<th>Protein</th>
                </tr>
                <tr>
                  <td>
                  <?php
                  $color = "#000000";
                  $RemCal = round($Calories - $SumCal);
                  if ($RemCal < 0){
                    $color = "red";}
                   echo "<span style=\"color: $color\">$RemCal</span>";;
                  ?></td>
                  <td><?php
                  $color = "#000000";
                  $RemFat = round($Fat - $SumFat);
                  if ($RemFat < 0){
                    $color = "red";}
                   echo "<span style=\"color: $color\">$RemFat</span>";;
                  ?></td>
                  <td><?php
                  $color = "#000000";
                  $RemCar =  round($Carbohydrates - $SumCar);
                  if ($RemCar < 0){
                    $color = "red";}
                   echo "<span style=\"color: $color\">$RemCar</span>";;
                  ?></td>
              		<td><?php
                  $color = "#000000";
                  $RemPro = round($Protein - $SumPro);
                  if ($RemPro < 0){
                    $color = "red";}
                   echo "<span style=\"color: $color\">$RemPro</span>";;
                  ?></td>
                </tr>
              </table>
              <br><br>
              <?php
      					include("dbconnection.php");

      					$email = $_SESSION['email'];
      					$sql = $conn->query("SELECT * FROM meals WHERE email='$email' ORDER BY MealId ASC");
      					echo("<table>");
                echo("<caption>Meal Planner</caption>");
      					echo "<tr><th>Meal ID</th><th>Food</th><th>Calories</th><th>Fat</th><th>Carbohydrates</th><th>Protein</th><th>Serving Size</th></tr>";
      					while ($row= $sql->fetch_assoc()) {
      						$MealId = $row['MealId'];
      						$Food = $row['Food'];
      						$Calories = $row['Calories'];
      						$Protein = $row['Protein'];
      						$Fat = $row['Fat'];
      						$Carbohydrates	 = $row['Carbohydrates'];
                  $ServingSize = $row['Description'];

      						echo "<tr><td>".$MealId."</td><td>".$Food."</td><td>".$Calories."</td><td>".$Fat."</td><td>".$Carbohydrates."</td><td>".$Protein."</td><td>".$ServingSize."</td></tr>";
      					}
      					echo("</table>");
      				?>

        <br>
        <p>Enter Meal Id</p>
        <input type="text" name = "DeleteFoodID">
        <button type="submit" name = "btn-Delfood"> Delete </button>
        <br>
        <br>
        <br>
        <button type="submit" name = "btn-DelAllfood" class="btn warning"> EMPTY MEAL PLANNER </button>
    </form>
  </div>
</div>
</body>
</html>
