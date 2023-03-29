<?php

echo "<link rel='stylesheet' href='tmp.css'>";
$servername = "localhost";
$username = "zenyuzien";
$dbname = "match";
$password = "Zenyuzien@123";


$mysqli = mysqli_connect($servername,$username,$password,$dbname);

include('functions.php');
Ualgo($mysqli,'U1');

$mysqli->close() ;


?>