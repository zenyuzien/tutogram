<?php
echo "<link rel='stylesheet' href='tmp.css'>";

session_start();
//error_reporting(E_ERROR | E_PARSE);
$sess= $_SESSION['username'];

echo "<h1><br>welcome ".$sess."<br></h1>";

echo "<form method='get' action='manageSW.php'>" ;

echo "<input type='radio'  name='MAN' value= 'ms' >";
echo "<span class='fcc-btn'>MANAGE STRENGTHS</span><br><br><br>" ;

echo "<input type='radio' name='MAN' value= 'as' >";
echo "<span class='fcc-btn' >MANAGE WEAKNESSES</span><br><br><br>" ;

echo "<input class='fcc-btn wtf'  type='submit' value='Proceed'></form>";

echo "<a class='fcc-btn' href='chats.php'>DISPLAY CHATS</a><br><br><br>" ;
echo "<a class='fcc-btn' href='pend_Req.php?username=$sess'>VIEW PENDING REQUESTS</a><br><br><br>" ;
?>