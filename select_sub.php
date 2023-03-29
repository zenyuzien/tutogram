
<?php

$servername = "localhost";
$username = "zenyuzien";
$dbname = "subdb";
$password = "Zenyuzien@123";

echo "<link rel='stylesheet' href='tmp.css'>";
echo "subjects:<br><br>";

if(isset($_GET['limit']))
{
  
  $mysqli1 = mysqli_connect($servername, $username, $password,'match');
  
  $tmp = $_GET['user'].$_GET['sw'];
  $sql ="select subject from $tmp";
  
  if ($result = mysqli_query($mysqli1, $sql) )
  if(mysqli_num_rows($result)>0)
  while($row = mysqli_fetch_assoc($result))
  {
    echo "<a  class='fcc-btn' href='select_unit.php?sub=$row[subject]&user=$_GET[user]&sw=$_GET[sw]' >$row[subject]</a><br><br>";
  }
  $mysqli1 -> close();
}
else 
{
            
  $mysqli = mysqli_connect($servername, $username, $password,$dbname);
  //$mysqli = new mysqli($servername, $username, $password,$dbname);
  // Check connection
  //if ($mysqli->connect_error) {
    if(mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
  } 

  $sql = "select * from subjects";    

  echo"<form method='GET' action= 'select_unit.php'>";
  if ($result = mysqli_query($mysqli, $sql) )
  {
    if(mysqli_num_rows($result)>0)
    {

      while($row = mysqli_fetch_assoc($result))
        {
          $sub=$row["subjectname"];        

          echo "<input class='fcc-btn' type='radio' name='Subject' value= $sub >";
          echo "$sub<br>";
        }
        $tmp = "hola";
    }
  }
  else echo"query unsuccesful";  

  echo '<br><input  class="fcc-btn" value="Proceed" type="submit"></form>';


  error_reporting(E_ERROR | E_PARSE);
  session_start();
  $mysqli -> close();
}

?>