<?php
session_start();
?>
<html>
<link rel="stylesheet" href="style1.css">
<head>
    <title>Winner!</title>
    <h1>Congratulations Player <?php echo $_SESSION['playerNum']; ?> You Won!!!</h1>
</head>
<body style="text-align: center">
<input  type="button" value="Exit" onclick="window.location.href='logout.php'">
</body></html>
