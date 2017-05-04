<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
$shipType = $_POST['stype'];
$cords = $_POST['cord'];
$warning1 = $_POST['toRet'];
$cords2 = str_split($cords);
$direction = $_POST['direction'];
$size = $_POST['sSize'];
$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$playNum = $_SESSION['playerNum'];
$conn = new mysqli($dbServer, $username, $password, $dbName);
$temp2="go";
$temp = "";

$sql = "SELECT shipT FROM `db319t32`.`ships".$_SESSION['playerNum']."`";
$num = mysqli_num_rows($conn->query($sql));
$test = $conn->query($sql);
for($index = 0; $index < $num; $index++)
{
    $tempString = $test->fetch_assoc()['shipT'];
    switch($tempString)
    {
        case "AirCraftCarrier":
            if($shipType == 'a')
            {
                exit("stop");
            }
            break;
        case "BattleShip":
            if($shipType == 'b')
            {
                exit("stop");
            }
            break;
        case "Destroyer":
            if($shipType == 'd')
            {
                exit("stop");
            }
            break;
        case "Submarine":
            if($shipType == 's')
            {
                exit("stop");
            }
            break;
        case "PatrolBoat":
            if($shipType == 'p')
            {
                exit("stop");
            }
            break;
    }
}

if($direction == "South")
{
    for($row = $cords2[0]; $row < $cords2[0] + $size; $row++)
    {
        $sql = "SELECT `table".$_SESSION['playerNum']."`.`hasbox` FROM `db319t32`.`table".$_SESSION['playerNum']."` WHERE `divID`= ".$row.$cords2[1]."";
        $temp = $conn->query($sql)->fetch_assoc()['hasbox'];
        if($temp == 'true')
        {
            $temp2 = 'stop';
            break;
        }
    }
}
else if($direction == "East")
{
    for($col = $cords2[1]; $col < $cords2[1] + $size; $col++)
    {
        $sql = "SELECT `table" . $_SESSION['playerNum'] . "`.`hasbox` FROM `db319t32`.`table" . $_SESSION['playerNum'] . "` WHERE `divID`= " . $cords2[0].$col . "";
        $temp = $conn->query($sql)->fetch_assoc()['hasbox'];
        if($temp == 'true')
        {
            $temp2 = 'stop';
            break;
        }
    }
}
if(strcmp($warning1,"none")==0 && $temp2 != 'stop')
{
    $temp = "";
    switch ($shipType) {
        case 'a':
            if ($direction == "South") {
                for ($row = $cords2[0]; $row < $cords[0] + 5; $row++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'a' WHERE divID= '" . $row . $cords[1] . "'";
                    $conn->query($sql);
                    $temp .= $row . $cords[1] . ":";
                }
            } else if ($direction == "East") {
                for ($col = $cords[1]; $col < $cords[1] + 5; $col++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'a' WHERE divID= '" . $cords[0] . $col . "'";
                    $conn->query($sql);
                    $temp .= $cords[0] . $col . ":";
                }
            }
            $temp = rtrim($temp, ":");
            $sql = "INSERT INTO `db319t32`.`ships" . $playNum . "`(`shipT`,`coordinates`,`isSunk`) VALUES('AirCraftCarrier','" . $temp . "','false')";
            $conn->query($sql);
            break;
        case 'b':
            if ($direction == "South") {
                for ($row = $cords2[0]; $row < $cords[0] + 4; $row++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'b' WHERE divID= '" . $row . $cords[1] . "'";
                    $conn->query($sql);
                    $temp .= $row . $cords[1] . ":";
                }
            } else if ($direction == "East") {
                for ($col = $cords[1]; $col < $cords[1] + 4; $col++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'b' WHERE divID= '" . $cords[0] . $col . "'";
                    $conn->query($sql);
                    $temp .= $cords[0] . $col . ":";
                }
            }
            $temp = rtrim($temp, ":");
            $sql = "INSERT INTO `db319t32`.`ships" . $playNum . "`(`shipT`,`coordinates`, `isSunk`) VALUES('BattleShip','" . $temp . "','false')";
            $conn->query($sql);
            break;
        case 'd':
            if ($direction == "South") {
                for ($row = $cords2[0]; $row < $cords[0] + 3; $row++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'd' WHERE divID= '" . $row . $cords[1] . "'";
                    $conn->query($sql);
                    $temp .= $row . $cords[1] . ":";
                }
            } else if ($direction == "East") {
                for ($col = $cords[1]; $col < $cords[1] + 3; $col++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'd' WHERE divID= '" . $cords[0] . $col . "'";
                    $conn->query($sql);
                    $temp .= $cords[0] . $col . ":";
                }
            }
            $temp = rtrim($temp, ":");
            $sql = "INSERT INTO `db319t32`.`ships" . $playNum . "`(`shipT`,`coordinates`, `isSunk`) VALUES('Destroyer','" . $temp . "','false')";
            $conn->query($sql);
            break;
        case 's':
            if ($direction == "South") {
                for ($row = $cords2[0]; $row < $cords[0] + 3; $row++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 's' WHERE divID= '" . $row . $cords[1] . "'";
                    $conn->query($sql);
                    $temp .= $row . $cords[1] . ":";
                }
            } else if ($direction == "East") {
                for ($col = $cords[1]; $col < $cords[1] + 3; $col++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 's' WHERE divID= '" . $cords[0] . $col . "'";
                    $conn->query($sql);
                    $temp .= $cords[0] . $col . ":";
                }
            }
            $temp = rtrim($temp, ":");
            $sql = "INSERT INTO `db319t32`.`ships" . $playNum . "`(`shipT`,`coordinates`, `isSunk`) VALUES('Submarine','" . $temp . "','false')";
            $conn->query($sql);
            break;
        case 'p':
            if ($direction == "South") {
                for ($row = $cords2[0]; $row < $cords[0] + 2; $row++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'p' WHERE divID= '" . $row . $cords[1] . "'";
                    $conn->query($sql);
                    $temp .= $row . $cords[1] . ":";
                }
            } else if ($direction == "East") {
                for ($col = $cords[1]; $col < $cords[1] + 2; $col++) {
                    $sql = "UPDATE `db319t32`.`table" . $_SESSION['playerNum'] . "` SET hasbox= 'true', shiptype= 'p' WHERE divID= '" . $cords[0] . $col . "'";
                    $conn->query($sql);
                    $temp .= $cords[0] . $col . ":";
                }
            }
            $temp = rtrim($temp, ":");
            $sql = "INSERT INTO `db319t32`.`ships" . $playNum . "`(`shipT`,`coordinates`, `isSunk`) VALUES('PatrolBoat','" . $temp . "','false')";
            $conn->query($sql);
            break;
    }
    $sql = "SELECT `ships" . $_SESSION['playerNum'] . "`.`shipT`,`ships" . $_SESSION['playerNum'] . "`.`coordinates`FROM `db319t32`.`ships" . $_SESSION['playerNum'] . "`;";
//    echo mysqli_num_rows($conn->query($sql));
    if (mysqli_num_rows($conn->query($sql)) == '5') {
        $sql = "UPDATE `db319t32`.`players` SET status= 'Ready' WHERE playerNum= " . $_SESSION['playerNum'] . " ";
        $conn->query($sql);
        echo "done";
    }

}

echo $temp2;
