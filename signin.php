

<?php 

$username = 'U2' ;

session_start();
$_SESSION['username'] = $username;
echo "<a href='student_home.php'>link</a>" ;
?>