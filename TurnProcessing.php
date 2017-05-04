<?php
session_start();
$cords = $_POST['cord'];
$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$conn = new mysqli($dbServer, $username, $password, $dbName);
$otherplayer = '0';
if($_SESSION['playerNum'] == '1')
{
    $otherplayer = '2';
}
else if($_SESSION['playerNum'] == '2')
{
    $otherplayer = '1';
}
$sql = "SELECT `db319t32`.`table".$otherplayer."`.`hasbox`,`table".$otherplayer."`.`shiptype`,`table".$otherplayer."`.`ishit`FROM `db319t32`.`table".$otherplayer."`  WHERE divID= ".$cords."";
$result = $conn->query($sql)->fetch_assoc();
if($result['ishit'] == 'true')
{
    $conn->close();
    echo "fail";
}
else
{
    $sql = "UPDATE `db319t32`.`table".$otherplayer."` SET ishit = 'true' WHERE divID= ".$cords."";
    $conn->query($sql);

    $sql = "SELECT `shipT` , `coordinates` , `isSunk` FROM `db319t32`.`ships".$otherplayer."`";
    $shipTemp = $conn->query($sql);
    $ships = array();
    $sunkCount = 0;
    $sunkAShip = false;
    for($index = 0; $index < 5; $index++)
    {
        $ships[$index] = array();
        $temporary = $shipTemp->fetch_assoc();
        array_push($ships[$index], $temporary['shipT']);
        array_push($ships[$index], $temporary['coordinates']);
        array_push($ships[$index], $temporary['isSunk']);
        if($ships[$index][2] == 'false')
        {
            $tempCords = explode(':', $ships[$index][1]);
            $count = 0;
            for($index2 = 0; $index2 < count($tempCords); $index2++)
            {
                $sql = "SELECT `ishit` FROM `db319t32`.`table".$otherplayer."` WHERE `divID`= '".$tempCords[$index2]."'";
                $isHit = $conn->query($sql)->fetch_assoc()['ishit'];
                if($isHit == 'true')
                {
                    $count += 1;
                }
            }

            if($count == count($tempCords))
            {
                $sunkenShip = $ships[$index][0];
                $sql = "UPDATE `db319t32`.`ships".$otherplayer."` SET isSunk= 'true' WHERE `coordinates` = '".$ships[$index][1]."'";
                $conn->query($sql);
                $sunkCount += 1;
                $sunkAShip = true;
            }
        }
        else
        {
            $sunkCount += 1;
        }
    }

    $sql = "SELECT `turnCount` FROM `db319t32`.`turn`";
    $result = $conn->query($sql)->fetch_assoc()['turnCount'];
    $result = intval($result) + 1;
    $sql = "UPDATE `db319t32`.`turn` SET turnCount= '".$result."' ";
    $conn->query($sql);
    //game over condition
    if($sunkCount == 5)
    {
        $sql = "UPDATE `db319t32`.`turn` SET winner= '".$_SESSION['playerNum']."'";
        $conn->query($sql);
        exit("win");
    }
    if($sunkAShip)
    {
        exit($sunkenShip);
    }

    $conn->close();
    echo "done";
}

