<?php
echo "<link rel='stylesheet' href='tmp.css'>";

session_start();
echo "<h1><br>welcome ".$_SESSION['username']."<br></h1>";

echo "<a class='fcc-btn' href='manage_str.php'>MANAGE STRENGTH</a><br><br><br>" ;
echo "<a class='fcc-btn' href='manage_weak.php'>MANAGES WEAKNESSES</a><br><br><br>" ;
echo "<a class='fcc-btn' href='chats.php'>DISPLAY CHATS</a><br><br><br>" ;
echo "<a class='fcc-btn' href='pend_Req.php'>VIEW PENDING REQUESTS</a><br><br><br>" ;

?>