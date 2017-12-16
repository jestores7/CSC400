<?php
include ("dbconnection.php");

$searchTerm = $_GET['term'];

$select =$conn->query("SELECT * FROM nutritiondb WHERE Shrt_Desc LIKE '%".$searchTerm."%' ORDER BY RAND()LIMIT 10");

while ($row = $select->fetch_assoc())
{
 $data[] = $row['Shrt_Desc'];
}
//return json data
echo json_encode($data);
?>
