<?php 
echo "<link rel='stylesheet' href='tmp.css'>";

session_start();
error_reporting(E_ERROR | E_PARSE);
//$_SESSION['username']= $_GET['username'];
echo "<h1><br>welcome " .$_SESSION['username'] . "..</h1>";
if($_GET['MAN'] == 'ms')
echo "<h1>Strengths</h1><br>";
else
echo "<h1>Weaknesses</h1><br>";


$servername = "localhost";
$username = "zenyuzien";
$dbname = "match";
$password = "Zenyuzien@123";


echo "<form method='get' action='modifySW.php'>" ;

if($_GET['MAN'] == 'ms')
{
  
  echo "<input type='radio'  name='IP' value= 'vs' >";
  echo "<span class='fcc-btn'>VIEW STRENGTHs</span><br><br><br>" ;
  echo "<input type='radio' name='IP' value= 'as' >";
  echo "<span class='fcc-btn' >ADD STRENGTH</span><br><br><br>" ;
  echo "<input type='radio' name='IP' value= 'rs' >";
  echo "<span class='fcc-btn' >REMOVE STRENGTH</span><br><br><br>" ;
  echo "<input class='fcc-btn wtf'  type='submit' value='Proceed'>";
}
else
{
  echo "<input type='radio'  name='IP' value= 'vw' >";
  echo "<span class='fcc-btn'>VIEW WEAKNESSES</span><br><br><br>" ;
  echo "<input type='radio' name='IP' value= 'aw' >";
  echo "<span class='fcc-btn' >ADD WEAKNESS</span><br><br><br>" ;
  echo "<input type='radio' name='IP' value= 'rw' >";
  echo "<span class='fcc-btn' >REMOVE WEAKNESS</span><br><br><br>" ;
  echo "<input class='fcc-btn wtf'  type='submit' value='Proceed'></form>";
}




echo "<br><br><br><a class='fcc-btn' href='student_home.php'>GO BACK</a>" ;
echo"</form>";

?>