<?php 

$u1 = $_GET['u1']    ;
$user = $_GET['usr'];
$u2 = $_GET['u2']    ;

$servername = "localhost";
$username = "zenyuzien";
$dbname = "match";
$password = "Zenyuzien@123";

$mysqli = mysqli_connect($servername,$username,$password,$dbname);

$tmp = 'U12';
if($user == 'U2')
$tmp = 'U21' ; 
$sql = "update matches set $tmp = 1" ;

if ($result = mysqli_query($mysqli, $sql) )
if(mysqli_num_rows($result)>0)
echo"good";

//echo "recieved $u1 $u2 " ;
$mysqli -> close() ;

?>


