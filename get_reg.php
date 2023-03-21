<head>
<link rel="stylesheet" href="tmp.css">
</head>
<?php

session_start();

$Subject = $_GET['Subject'];

echo "Your choice is: ".$Subject."<br>";
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


$sql = "select * from $Subject";

echo "
<form method='get' action='recieve_reg.php'>
<select class='cla' name='sbt'> <option  value=$Subject></option> </select>
<br>";


/*
<object data="horse">
<param name="autoplay" value="true">
</object> '
*/

if ($result = mysqli_query($mysqli, $sql) )
{
  if(mysqli_num_rows($result)>0)
  {

    while($row = mysqli_fetch_assoc($result))
      {
        $sub=$row["unitname"];        

        echo "<input type='radio' name='Unit' value= $sub >";
        echo "$sub<br>";
      }
      $tmp = "hola";
     

  }
}


echo '

    <input type="submit">
</form>';

//error_reporting(E_ERROR | E_PARSE);

$mysqli -> close();

?>
