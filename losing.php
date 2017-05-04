<?php
session_start();
?>
<html>
<link rel="stylesheet" href="style1.css">
<head>
    <title>Losing Page</title>
    <h1>Sorry Player <?php echo $_SESSION['playerNum']; ?> You Lost<br>
        Better Luck Next Time</h1></head>
<body style="text-align: center"><input  type="button" value="Exit" onclick="window.location.href='logout.php'"></body></html>