<?php
session_start();
?>
<html>
<link rel="stylesheet" href="style1.css">
<head>
    <title>Losing Page</title>
    <h1>Sorry Player <?php echo $_SESSION['playerNum']; ?> You Lost<br>
        Better Luck Next Time</h1>
    <h2>You have lost to <?php
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
<body style="text-align: center"><input  type="button" value="Exit" onclick="window.location.href='logout.php'"></body></html>