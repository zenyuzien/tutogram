<?php 
echo "pend";
echo "<link rel='stylesheet' href='tmp.css'>";

    $user = $_GET['username'] ;
    echo"<h1>welcome $user</h1><br>";

$servername = "localhost";
$username = "zenyuzien";
$dbname = "match";
$password = "Zenyuzien@123";

$mysqli = mysqli_connect($servername,$username,$password,$dbname);


$sql = "select * from matches where (U1='$user')OR(U2='$user')" ;
if ($result = mysqli_query($mysqli, $sql) )
if(mysqli_num_rows($result)>0)
while($row = mysqli_fetch_assoc($result))
{
    $u2 = $row['U1']; 
    if($row['U1']==$user)
    $u2 = $row['U2'];

    if($row['U12']!=1 || $row['U21'] !=1)
    {
        
        if // 1 0
        (
            ($row['U1']==$user  && $row['U12']== 1 && $row['U21']== 0 )
            ||
            ($row['U2']==$user  && $row['U21']== 1 && $row['U12']== 0 )
        )
        echo "<h4>match status with $u2 agreement pending...</h4><br>";
        else
        if($row['U1']==$user)
        {
            $tmp = 'U1' ; 
            echo"<h4>match status with $u2 : approve pending </h4><a class=fcc-btn href='approve.php?u1=$user&usr=$tmp&u2=$u2'>APPROVE</a><br>"; // 0 0 or 0 1
        }
        else 
        {
            $tmp = 'U2';
            echo"<h4>match status with $u2 : approve pending </h4><a class=fcc-btn href='approve.php?u1=$user&usr=U2&u2=$u2'>APPROVE</a><br>"; // 0 0 or 0 1
        
        }
        
    }
    else
    echo "<h4>match status with $u2 : match </h4><a class=fcc-btn href='chat.php?u1=$user&u2=$u2'>GO TO CHAT</a><br>" ; // 1 1 
}
else 
{
    echo "<h4>you don't have pending matches</h4><br>" ;
}

$mysqli->close();

?>