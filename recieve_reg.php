<head>
<link rel="stylesheet" href="tmp.css">
</head>
<?php

session_start();

//<p><a href="set_reg.php">Back to set_reg.php</a>


$servername = "localhost";
$username = "zenyuzien";
$dbname = "subjectdb";
$password = "Zenyuzien@123";

$mysqli = mysqli_connect($servername, $username, $password,$dbname);
//$mysqli = new mysqli($servername, $username, $password,$dbname);
// Check connection
//if ($mysqli->connect_error) {
  if(mysqli_connect_errno()) {
  die("Connection failed: " . mysqli_connect_error());
}
$bg_color = "#0fa0f0"; // Red background color 
$font = "#ffffff" ;
echo "<body style='background-color: $bg_color;'>"; 
echo "<body style='font color: $font;'>"; 


$Subject = $_GET['sbt'];
$Unit = $_GET['Unit'];

echo "got:".$Subject."  ".$Unit."<br>" ;
$str = $Subject."_".$Unit ; 

$sql = "select * from $str";
echo "
<form method='get' action='update.php'>
<select class='cla' name='sub'> <option  value=$Subject></option> </select>
<select class='cla' name='unit'> <option  value=$Unit></option> </select>
";

if ($result = mysqli_query($mysqli, $sql) )
{
  if(mysqli_num_rows($result)>0)
  {
    while($row = mysqli_fetch_assoc($result))
      {
        $sub=$row["subtopicname"];        

        echo "<input type='radio' name='sbt' value= $sub >";
        echo "$sub<br>";
      }
  }
}

echo "<input type='submit'>
</form>";
$mysqli -> close();
/*
session_start();
error_reporting(E_ERROR | E_PARSE);
$_SESSION['regName'] = $regValue;*/
?>
