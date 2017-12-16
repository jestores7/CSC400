<?php
$servername="localhost";
$username="root";
$password="";
$dbname="csc400";
$conn=new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error)
{
        die("Connection failed: ". $conn->connect_error);
}
else
{
        //echo "<test style=\"color:#0000ff\">Successfully connected to database</test>";
}
?>
