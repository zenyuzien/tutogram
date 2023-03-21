
<?php
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

$sql = "select * from subjects";
echo '
<form method="get" action="get_reg.php">';
    

if ($result = mysqli_query($mysqli, $sql) )
{
  if(mysqli_num_rows($result)>0)
  {

    while($row = mysqli_fetch_assoc($result))
      {
        $sub=$row["subjectname"];        

        echo "<input type='radio' name='Subject' value= $sub >";
        echo "$sub<br>";
      }
      $tmp = "hola";
  }
}
else echo"query unsuccesful";  

echo '

    <input type="submit">
</form>';


session_start();
error_reporting(E_ERROR | E_PARSE);
//$_SESSION['regName'] = $regValue;
$Subject = $_SESSION['Subject'] ;
$mysqli -> close();
?>