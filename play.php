<?php
session_start();
$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$conn = new mysqli($dbServer, $username, $password, $dbName);
?>

<html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" href="style1.css">
<head>
    <title>Play Game</title>
    <h1>Click Square to Fire!</h1>
</head>
<body>
<table class="container">
    <?php

    $otherplayer = '0';
    if($_SESSION['playerNum'] == '1')
    {
        $otherplayer = '2';
    }
    else if($_SESSION['playerNum'] == '2')
    {
        $otherplayer = '1';
    }
    for ($i =0; $i<9;$i++) {
        echo "<tr>";
        for($j=0;$j<9;$j++)
        {
            if($i ==0 || $j == 0)
            {
                if($j== 0)
                {
                    echo "<td><div>".$i."</div></td>";
                }
                else if($i == 0)
                {
                    echo "<td><div>"
                        .$j.
                        "</div></td>";
                }
            }
            else
            {
                $sql = "SELECT `table".$otherplayer."`.`hasbox`,`table".$otherplayer."`.`shiptype`,`table".$otherplayer."`.`ishit`FROM `db319t32`.`table".$otherplayer."` WHERE `divID`= ".$i.$j;
                $result = $conn->query($sql);
                $temp = $result->fetch_assoc();
                $temp2 ="";
                $styleC = "style = 'background-color: #323c50'";
                if($temp['hasbox'] == 'true')
                {
                    if($temp['ishit'] == 'true')
                    {
                        $styleC = "style = 'background-color: #ff2a2a'";
                    }
                }
                if($temp['ishit'] == 'true' && $temp['hasbox'] == 'false')
                {
                    $styleC = "style = 'background-color: #FFFFFF'";
                }
                echo "<td ".$styleC." id='" . $i . $j . "' class='divClick'>
            <div id='" . $i . $j . "' class='infodiv'></div>".$temp2."
            </td>";
            }
        }
        echo "</tr>";
    }


    ?>
</table>
</body>
<script>
    $(document).ready(function () {
        $(".infodiv").hide();
    });
    $(".divClick").on('click',function (e) {

        var cords = e.target.id;
        $.ajax({
            type: 'POST',
            url: "TurnProcessing.php",
            data:
            {
                cord: cords
            }
        }).done(function (msg)
        {
            console.log(msg);
            if(msg.localeCompare("win") ==0)
            {
                window.location.href = 'win.php';
            }
            if(msg.localeCompare("done")==0)
            {
                window.location.href = 'WaitPage.php';
            }
            if(msg.localeCompare("fail") ==0)
            {
                alert('Spot has already been hit!');
            }
            switch(msg)
            {
                case "AirCraftCarrier":
                    alert("You sunk their " + msg);
                    window.location.href = 'WaitPage.php';
                    break;
                case "BattleShip":
                    alert("You sunk their " + msg);
                    window.location.href = 'WaitPage.php';
                    break;
                case "Destroyer":
                    alert("You sunk their " + msg);
                    window.location.href = 'WaitPage.php';
                    break;
                case "Submarine":
                    alert("You sunk their " + msg);
                    window.location.href = 'WaitPage.php';
                    break;
                case "PatrolBoat":
                    alert("You sunk their " + msg);
                    window.location.href = 'WaitPage.php';
                    break;
            }
        });
    });
</script>
</html>
