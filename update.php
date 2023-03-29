<head>
<link rel="stylesheet" href="tmp.css">
</head>
  <?php

/********************************************************** */



/************************************************************* */

  $servername = "localhost";
  $username = "zenyuzien";
  $password = "Zenyuzien@123";
  
  $mysqli1 = mysqli_connect($servername, $username, $password,'match');
  $mysqli2 = mysqli_connect($servername, $username, $password,'subdb');

  //$mysqli = new mysqli($servername, $username, $password,$dbname);
  // Check connection
  //if ($mysqli->connect_error) {
    if(mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
include('functions.php');

$sbt ; 
$sub ; 
$unit ; 
$username ;
$op ;


if(isset($_GET['sub']))
{
  $sbt = $_GET['sbtid'];
  //echo "universal recieval_ $sbt _";
  $sub = $_GET['sub'];
  $unit = $_GET['unitid'];
  $username = $_GET['user'];
  $op = $_GET['sw'];
  if($op == '_s')
  $op = 'rs'; 
  else 
  $op = 'rw';
}
else 
{
  session_start();
  $sbt = $_GET['sbt'];
  //echo "universal recieval_ $sbt _";
  $sub = $_SESSION['sub'];
  $unit = $_SESSION['unit'];
  $username = $_SESSION['username'] ;
  $op = $_SESSION['IP'] ;
}


$nT = 0 ; 
$nU = 0 ; 
$unitID = 0 ;
$sbtID = 0 ;

//echo "$username username :: $sub subject :: $unit unit :: $sbt subtopic , operation $_SESSION[IP] <br>";

$sql1 = "select nU from subjects where (subjectname = '$sub')";
if ($res1 = mysqli_query($mysqli2, $sql1) )
if(mysqli_num_rows($res1)>0)
$row = mysqli_fetch_assoc($res1);

$nU = $row['nU'];

$sql1 = "select unitID,nT from $sub where (unitID = '$unit')";
if ($res1 = mysqli_query($mysqli2, $sql1) )
if(mysqli_num_rows($res1)>0)
$row = mysqli_fetch_assoc($res1);


$nT = $row['nT'];
$unitID = $row['unitID'];

$tmp =$sub."_".$unit ; 
$sql1 = "select sbtID from $tmp where (sbtID = '$sbt')";
if ($res1 = mysqli_query($mysqli2, $sql1) )
if(mysqli_num_rows($res1)>0)
$row = mysqli_fetch_assoc($res1);

$sbtID= $row['sbtID'];

echo "for subject $sub ,the units in sub is $nU , subtopics in $unit is $nT , code of unit is $unitID, code for sbt is $sbtID ";


$tmp;
if($op=='as' || $op=='rs')
{
  //echo "your current strengths are: <br>";
  $tmp  = $username."_s"; ///
}
else 
{
  //echo "your current sweakneses are: <br>";
  $tmp  = $username."_w"; ///
}
/*
$row;
$sql1 = "select * from $tmp";
if ($res1 = mysqli_query($mysqli_match, $sql1) )
if(mysqli_num_rows($res1)>0)
while($row = mysqli_fetch_assoc($res1))
{
  echo "$row[subject] :: $row[string] <br>";
}*/

$sql ; 

$subexists = 0 ;
$sql1 = "select * from $tmp"; 
if ($res1 = mysqli_query($mysqli1, $sql1) )
if(mysqli_num_rows($res1)>0)
while($row = mysqli_fetch_assoc($res1))
{
  if($sub == $row['subject']){
  $subexists =1 ; echo "sub found";}
}

if($subexists == 1)
{
  $sql1 = "select * from $tmp where (subject='$sub')";
  if ($res1 = mysqli_query($mysqli1, $sql1) )
  if(mysqli_num_rows($res1)>0)
  {
    $row = mysqli_fetch_assoc($res1);
    echo "existing string : $row[string] <br>";
    $tmpstr ;
    if($op == 'aw' || $op == 'as')
    $tmpstr = updateStr($nT,$nU,$unit,$sbt,$row['string']);
    else 
    $tmpstr = deleteStr($mysqli2,$sub,$nT,$nU,$unit,$sbt,$row['string']);
   // echo "the new stirng is $tmpstr <br>";
    if($tmpstr == $row['string'])
    {
      echo"no change";
      ;
    }
    else 
    {
      echo "the updated will be _".$tmpstr."_<br>" ;
      $sql = "update $tmp set string = '$tmpstr' where subject = '$sub' " ; 
      echo"<br>$sql<br>";
      if ($res1 = mysqli_query($mysqli1, $sql) )
      echo "<br>succes !";

      $sql ="select string from $tmp where subject ='$sub'"; 
      if($result = mysqli_query($mysqli1, $sql) )
      if(mysqli_num_rows($result)>0)
      {
          $row = mysqli_fetch_assoc($result);
          echo "_ $row[string] _";
          if($row['string']=='')
          {
              $sql ="delete from $tmp where subject ='$sub'"; 
              if($result = mysqli_query($mysqli1, $sql) )
              echo "success";
          }
      }
    }
  }
}
else 
{
  echo "new entry <br>";
  $tmpstr=  "*".$unit."#".$sbt ; 
  echo "new entry $tmpstr";
  $sql = "insert into $tmp values('$sub','$tmpstr')";
  echo"<br>$sql<br>";
  if ($res1 = mysqli_query($mysqli1, $sql) )
  echo "<br>succes !";

}

echo "<br><br><br><a class='fcc-btn' href='student_home.php'>GO BACK</a>" ;

Ualgo($mysqli1,$username);
/********************************************** U algo ******** */

$mysqli1->close() ;
$mysqli2->close() ;


?>