<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$conn = new mysqli($dbServer, $username, $password, $dbName);
$playerNo = $_SESSION['playerNum'];
$waiton = 0;
if($_SESSION['playerNum']==1)
{
    $waiton = 2;
}
else
{
    $waiton =1;
}
?>
    <html>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style1.css">
    <head>
        <title>Waiting for Move</title>
        <h1>Waiting for Player <?php echo $waiton?></h1>
    </head>
    <body>
    <label>Your Board<br></label>
    <table class="container" align="left">
<?php
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
            $sql = "SELECT `table".$_SESSION['playerNum']."`.`hasbox`,`table".$_SESSION['playerNum']."`.`shiptype`,`table".$_SESSION['playerNum']."`.`ishit`FROM `db319t32`.`table".$_SESSION['playerNum']."` WHERE `divID`= ".$i.$j;
            $result = $conn->query($sql);
            $temp = $result->fetch_assoc();
            $temp2 = "";
            $styleC = "style = 'background-color: #323c50'";
            if($temp['hasbox'] == 'true')
            {
                $temp2 = $temp['shiptype'];
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

            ".$temp2."

            </td>";
        }
    }
    echo "</tr>";
}
$otherplayer = '0';
if($_SESSION['playerNum'] == '1')
{
    $otherplayer = '2';
}
else if($_SESSION['playerNum'] == '2')
{
    $otherplayer = '1';
}
 ?>
    </table><br>
    <label>Player <?php echo $otherplayer;?>'s Board</label>
    <table>
    <?php

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
                    $styleC = "style = 'background-color: #323c50'";
                    $temp2 ="";
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
                    echo "<td ".$styleC." id='" . $i . $j . "' class='divClick'>".$temp2."
          
            </td>";
                }
            }
            echo "</tr>";
        }
        ?>
    </table>
    </body>
    <script>
        setInterval(refresh, 1000);
        function refresh() {
            $.ajax({
                type: "POST",
                url: "refreshGame.php",
                data: {
                    re: 1
                }
            }).done(function (msg) {
                if(msg.localeCompare("gamedone") == 0)
                {
                    window.location.href = 'losing.php';
                }
                if (msg.localeCompare("done") == 0) {
                    window.location.href = 'play.php';
                }
            });
        }
    </script>
    </html>
