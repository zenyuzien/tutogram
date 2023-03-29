<?php 

echo "<link rel='stylesheet' href='tmp.css'>";
session_start();
$user = $_SESSION['username'];
$ip= $_GET['IP'];
$_SESSION['IP'] = $ip ;

$servername = "localhost";
$username = "zenyuzien";
$dbname = "match";
$password = "Zenyuzien@123";



include('functions.php');

if($ip=='vs' || $ip == 'vw')
{
    //cho "come here ?";

    $mysqli1 = mysqli_connect($servername, $username, $password,'match');
    $mysqli2 = mysqli_connect($servername, $username, $password,'subdb');
    //$mysqli = new mysqli($servername, $username, $password,$dbname);
    // Check connection
    //if ($mysqli->connect_error) {
      if(mysqli_connect_errno()) {
      die("Connection failed: " . mysqli_connect_error());
    }

    if($ip=='vs') 
    $user=$user."_s";
    else 
    $user=$user."_w";

    $sql = "select * from $user" ;

    if ($result = mysqli_query($mysqli1, $sql) )
    {
        if(mysqli_num_rows($result)>0)
        {
            echo "<br> $user :<br><br>";
            while($row = mysqli_fetch_assoc($result))
            {
                // s5 doesnt exist.
                echo "<br> $row[subject]:";

                if($row['string']=='@')
                {
                    $tab = $row['subject'];
                    echo"grip in entire subject <br>";
                    $sql2 = "select * from $row[subject]" ;
                    echo "Unit:<br>";
                    if($res1 = mysqli_query($mysqli2,$sql2) )
                    if(mysqli_num_rows($res1) >0)
                    while($unit_row = mysqli_fetch_assoc($res1))
                    {
                        echo "$unit_row[unitname]  :<br>" ;
                        $tab1 = $tab."_".$unit_row['unitID'];
                        //echo"acess $tab1 <br>";
                        $sql3= "select sbtname from $tab1";

                        if($res2 = mysqli_query($mysqli2,$sql3) )
                        if(mysqli_num_rows($res2) >0)
                        while($sbt_row = mysqli_fetch_assoc($res2))
                        {
                            echo "$sbt_row[sbtname]  ";
                        }   echo"<br>";
                    }
                }
                else 
                {                    
                    $mybucket = [];
                    $list= [] ;
                    $list[] =  $row['string'];
                    $ulist= [] ; 
                    $ulist = getUnits($list,0,$ulist);
                    $mybucket = getBucket($mybucket,$list,0,$ulist);
                    displaybucket($mysqli2,$row['subject'],$mybucket);
                }
            }
            $mysqli1->close() ;
            $mysqli2->close() ;
        }
        else 
        echo "nothing to display, please update data<br>";
    }
}
else if($ip == 'as' || $ip == 'aw')
include('select_sub.php');
else 
{
    if($ip=='rw')
    header("Location: select_sub.php?limit=1&user=$user&sw=_w");
    else 
    header("Location: select_sub.php?limit=1&user=$user&sw=_s");

    exit();
}


echo "<br><br><br><a class='fcc-btn' href='student_home.php'>GO BACK</a>" ;



?>