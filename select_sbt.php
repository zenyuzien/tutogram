<head>
<link rel="stylesheet" href="tmp.css">
</head>
<?php

function getSbts($str,$unit)
{
  for($i = 0 ; $i < strlen($str); $i++)
  {
     // echo "str[$i] = $str[$i] <br>";

      if($str[$i]=='*')
      {
        $i=$i+1;//
       // echo "new tmpunit<br>";
          $tmpunit="";
          while($str[$i]!='@' && $str[$i]!='#')
          {
            //echo "str[$i] = $str[$i] <br>";
            $tmpunit=$tmpunit.$str[$i]; 
            $i++;
          }
         // echo "recieved tmpunit $tmpunit <br>";
          if($tmpunit==$unit)
          {
            if($str[$i]=='@')
            {
              $x = []; $x[] = '@' ; 
              return $x;
            }
            else if($str[$i]=='#')
            {
              $list=[];
              $i++;
              while($i<strlen($str) && $str[$i]!='*')
              {
                $tmpsbt="";
                while($i<strlen($str) && $str[$i]!='*' && $str[$i] != '#'){
                  $tmpsbt=$tmpsbt. $str[$i] ;
                  $i++;

                }

                echo "reciecved $tmpsbt ($i)";
                $list[] = $tmpsbt;  
                
                if($i>= strlen($str) || $str[$i] == '*')
                return $list ;
                else 
                $i++;
              }
              return $list; 
            }
          }
          else
          {
            while($i<strlen($str) && $str[$i]!='*')
            {
              //echo "str[$i] = $str[$i] <br>";
              $i++;
            }$i--;
          }
      }
  }
}

session_start();
$servername = "localhost";
$username = "zenyuzien";
$password = "Zenyuzien@123";

$mysqli1 = mysqli_connect($servername, $username, $password,'match');
$mysqli2 = mysqli_connect($servername, $username, $password,'subdb');

if(isset($_GET['sub']))
{
  
  $row ;
  $tmp = $_GET['user'].$_GET['sw'];
  $sql ="select string from $tmp where subject='$_GET[sub]'";
  
  $str ; 
  if ($result = mysqli_query($mysqli1, $sql) )
  if(mysqli_num_rows($result)>0)
  ($str = mysqli_fetch_assoc($result));

  $tmplist = [];
  if($str['string']=='@')
  {
    $tmp  = $_GET['sub']."_".$_GET['unitid'];
    goto gf1 ; 
  }
  $tmplist = getSbts($str['string'], $_GET['unitid']) ; //** */
  $c = count($tmplist);
  echo "count: $c  select subtopic :<br><br>";
  $tmp  = $_GET['sub']."_".$_GET['unitid'];
  if($tmplist[0]=='@')
  {
    gf1:;
    $sql ="select * from $tmp" ; 
    if ($result = mysqli_query($mysqli2, $sql))
    if(mysqli_num_rows($result)>0)
    while($row = mysqli_fetch_assoc($result))
    echo "<a  class='fcc-btn' href='update.php?sub=$_GET[sub]&user=$_GET[user]&sw=$_GET[sw]&unitid=$_GET[unitid]&sbtid=$row[sbtID]' >$row[sbtname]</a><br><br>";
  }
  else 
  
  for($i = 0 ; $i< count($tmplist) ; $i++)
  {
    $sql ="select * from $tmp where sbtID = '$tmplist[$i]'";
    if ($result = mysqli_query($mysqli2, $sql))
    if(mysqli_num_rows($result)>0)
    $row = mysqli_fetch_assoc($result);
    echo "<a  class='fcc-btn' href='update.php?sub=$_GET[sub]&user=$_GET[user]&sw=$_GET[sw]&unitid=$_GET[unitid]&sbtid=$row[sbtID]' >$row[sbtname]</a>";
       
  }
  $mysqli1 -> close();
  $mysqli2 -> close();
}

else
{
      
//$mysqli = new mysqli($servername, $username, $password,$dbname);
// Check connection
//if ($mysqli->connect_error) {
  if(mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
  }
  
  $Subject = $_SESSION['sub'];
  $Unit = $_GET['unit'];
  $_SESSION['unit'] = $Unit ; 
  
  echo "got:".$Subject."  ".$Unit."<br>" ;
  $str = $Subject."_".$Unit ; 
  
  $sql = "select * from $str";
  echo "
  <form method='get' action='update.php'>
  ";
  echo "<link rel='stylesheet' href='tmp.css'>";
  
  if ($result = mysqli_query($mysqli2, $sql) )
  {
    if(mysqli_num_rows($result)>0)
    {
      while($row = mysqli_fetch_assoc($result))
        {
          echo "<input class='fcc-btn' type='radio' name='sbt' value= $row[sbtID] >";
          echo "$row[sbtname]<br>";
        }
    }
  }
  
  echo "<input class='fcc-btn' type='submit'>
  </form>";
}


//$mysqli1 -> close();
?>
