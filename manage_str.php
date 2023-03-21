<?php 
echo "<link rel='stylesheet' href='tmp.css'>";

session_start();
echo "<h1><br>welcome " .$_SESSION['username'] . "</h1>";
echo "<h1>Strengths</h1><br>";

$servername = "localhost";
$username = "zenyuzien";
$dbname = "match";
$password = "Zenyuzien@123";

$mysqli = mysqli_connect($servername, $username, $password,$dbname);
//$mysqli = new mysqli($servername, $username, $password,$dbname);
// Check connection
//if ($mysqli->connect_error) {
  if(mysqli_connect_errno()) {
  die("Connection failed: " . mysqli_connect_error());
}

$user = $_SESSION['username']."_s" ;
$sql = "select * from $user";

    

if ($result = mysqli_query($mysqli, $sql) )
{
  if(mysqli_num_rows($result)>0)
  {
    while($row = mysqli_fetch_assoc($result))
    {
        echo "subject: $row[Subject] , string: $row[String] <br>" ;
    }
  }
}    




?>