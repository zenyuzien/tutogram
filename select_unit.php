<head>
<link rel="stylesheet" href="tmp.css">
</head>
<?php

session_start();
echo "<link rel='stylesheet' href='tmp.css'>";


$servername = "localhost";
$username = "zenyuzien";
$dbname = "subdb";
$password = "Zenyuzien@123";
function getUnits($strings_of_u, $i, $uu )
{
  for($j = 0 ; $j < strlen($strings_of_u[$i]) ; $j++) //*U1#T1*U2#T1#T2
        {
           // if($j==0) echo"<br>iterating ".$strings_of_u[$i]."<br>";

            if($j==0 && ($strings_of_u[$i][$j]== '@'))
            {
             //   echo "yes";
                $uu[] = "@";
                break;
            } 

            else
            {
                if($j==0)
                $j++; 
                $tmp = "";
                while($j < strlen($strings_of_u[$i]) && ($strings_of_u[$i][$j] != '@' && $strings_of_u[$i][$j] != '#' ) )
                {
                  $tmp = $tmp . $strings_of_u[$i][$j++];
                 // echo "tmp:" . $tmp . "<br>";
                }
                //echo "final tmp:" . $tmp . "<br>";
                $uu[] = $tmp;
                while( ( $j < strlen($strings_of_u[$i]) ) && $strings_of_u[$i][$j] != '*')
                {
                  $j++;
                } 
            }
            
            
        }
  return $uu;
}

if(isset($_GET['sub']))
{
  
  $mysqli1 = mysqli_connect($servername, $username, $password,'match');
  $mysqli2 = mysqli_connect($servername, $username, $password,'subdb');
  
  $tmp = $_GET['user'].$_GET['sw'];
  $sql ="select string from $tmp where subject='$_GET[sub]'";
  
  $row ; 
  if ($result = mysqli_query($mysqli1, $sql) )
  if(mysqli_num_rows($result)>0)
  ($row = mysqli_fetch_assoc($result));
  $tmplist = [];
  $tmplist[] = $row['string'];
  $list = [] ; 
  $list = getUnits($tmplist,0,$list);
  
  echo "select unit :<br><br>";

  if($list[0]=='@')
  {
    // getting all units details alltogether for given subject $mysqli2 = mysqli_connect($servername, $username, $password,$dbname);
   // $mysqli2 = mysqli_connect($servername, $username, $password,$dbname);
   
    $sql ="select * from $_GET[sub]" ; 
    if ($result = mysqli_query($mysqli2, $sql))
    if(mysqli_num_rows($result)>0)
    while($row = mysqli_fetch_assoc($result))
    {
      echo "<a  class='fcc-btn' href='select_sbt.php?sub=$_GET[sub]&user=$_GET[user]&sw=$_GET[sw]&unitid=$row[unitID]' >
      $row[unitname]
      </a><br><br>";
    }
  }
  else 
  {
  //  $mysqli2 = mysqli_connect($servername, $username, $password,$dbname);
    for($i = 0 ; $i < count($list) ; $i++)
    {
      // getting real name for given id
      $sql ="select * from $_GET[sub] where unitID = '$list[$i]'" ;
      if ($result = mysqli_query($mysqli2, $sql))
      if(mysqli_num_rows($result)>0)
      while($row = mysqli_fetch_assoc($result))
      {
        echo "<a  class='fcc-btn' href='select_sbt.php?sub=$_GET[sub]&user=$_GET[user]&sw=$_GET[sw]&unitid=$row[unitID]' >
        $row[unitname]
        </a><br><br>";
  
      }
    }
  }
  $mysqli1 -> close();
  $mysqli2 -> close();
}
  
 
    //echo "<a  class='fcc-btn' href='select_unit.php?sub=$row[subject]&user=$_GET[user]&sw=$_GET[sw]' >$row[subject]</a><br><br>";
  
else 
{
  $Subject = $_GET['Subject'];
  $_SESSION['sub'] = $Subject ;
  
  echo "Your choice is: ".$Subject."<br>";
  //<p><a href="set_reg.php">Back to set_reg.php</a>
  
  
  $mysqli = mysqli_connect($servername, $username, $password,$dbname);
  
  //$mysqli = new mysqli($servername, $username, $password,$dbname);
  // Check connection
  //if ($mysqli->connect_error) {
    if(mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
  }
  $sql = "select * from $Subject";
  
  echo "
  <form method='get' action='select_sbt.php'>
  <br>";
  
  if ($result = mysqli_query($mysqli, $sql) )
  {
    if(mysqli_num_rows($result)>0)
    {
      while($row = mysqli_fetch_assoc($result))
        {
          
          $tmp = $row['unitID'];
          echo "<input class='fcc-btn' type='radio' name='unit' value=$tmp >";
          
          echo "$row[unitname]<br>";
        }
    }
  }
  
  
  echo '
  <input class="fcc-btn" type="submit">
  </form>';
  
  //error_reporting(E_ERROR | E_PARSE);
  
  $mysqli -> close();
}




      

?>
