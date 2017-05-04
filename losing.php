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
    <title>Losing Page</title>
    <h1>Sorry Player <?php echo $_SESSION['uname']; ?> You Lost<br>
        Better Luck Next Time</h1>
    <h1>You have lost to <?php
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
        ?>!</h1>
</head>
<body style="text-align: center"><input  type="button" value="Exit" onclick="window.location.href='logout.php'"></body></html>