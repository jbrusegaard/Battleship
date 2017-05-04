<?php
session_start();
$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$conn = new mysqli($dbServer, $username, $password, $dbName);
?>
<html>
<link rel="stylesheet" href="style1.css">
<head>
    <title>Winner!</title>
    <h1>Congratulations Player <?php echo $_SESSION['playerNum']; ?> You Won!!!</h1>
    <h2>You have beat <?php
        $sql = "SELECT `playernames`.`playernum`,`playernames`.`player_name`FROM `db319t32`.`playernames` WHERE `playernum` = 1";
        $result = $conn->query($sql);
        $temp = $result->fetch_assoc()['player_name'];
        $sql = "SELECT `playernames`.`playernum`,`playernames`.`player_name`FROM `db319t32`.`playernames` WHERE `playernum` = 2";
        $result = $conn->query($sql);
        $temp2 = $result->fetch_assoc()['player_name'];
        if($_SESSION['playerNum'] == 1){
            echo $temp2;
        }else{
            echo $temp;
        }
        ?></h2>
</head>
<body style="text-align: center">
<input  type="button" value="Exit" onclick="window.location.href='logout.php'">
</body></html>
