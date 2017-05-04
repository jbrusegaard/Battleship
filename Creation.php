<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
if($_POST['playerNo']!=1)
{
    if($_POST['playerNo']!=2)
    {
        echo "<script>
    alert('Invalid Player Number!');
    window.location.href = 'index.html';
    </script>";
    }
}
$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$_SESSION['placedShips'] = array();
$conn = new mysqli($dbServer, $username, $password, $dbName);
$_SESSION['playerNum']= $_POST['playerNo'];
$playNum = $_SESSION['playerNum'];
$_SESSION['uname'] = $_POST['uname'];


if ($conn->connect_error)
{
    die("Connection failed: " . $conn->connect_error);
}
else
{
    echo "<h3 align='right'>Welcome: ". $_POST['uname'] ."<br>Player:  ".$_POST['playerNo']."</h3>";
}

$sql = "CREATE TABLE IF NOT EXISTS`db319t32`.`players`(playerNum TINYINT, status VARCHAR(10))";
$conn->query($sql);
$sql = "SELECT `players`.`playerNum`,`players`.`status`FROM `db319t32`.`players`";
$result = $conn->query($sql);
//echo var_dump($result->fetch_assoc());
if(mysqli_num_rows($result) < 1)
{
    $sql = "INSERT INTO `db319t32`.`players`(playerNum, status) VALUES ('1','NotReady')";
    $conn->query($sql);
}
if(mysqli_num_rows($result) < 2)
{
    $sql = "INSERT INTO `db319t32`.`players`(playerNum, status) VALUES ('2','NotReady')";
    $conn->query($sql);
}
$sql ="UPDATE `db319t32`.`players` SET status= 'NotReady' WHERE playerNum= '".$_SESSION['playerNum']."'";
$conn->query($sql);
$sql = "DROP TABLE `db319t32`.`table".$playNum."`";
$conn->query($sql);
$sql = "CREATE TABLE IF NOT EXISTS `db319t32`.`table".$_SESSION['playerNum']."`(divID VARCHAR (2), hasbox VARCHAR (5), shiptype VARCHAR(20), ishit VARCHAR (5))";
$conn->query($sql);
$sql = "DROP TABLE `db319t32`.`ships".$playNum."`";
$conn->query($sql);
$sql = "CREATE TABLE IF NOT EXISTS `db319t32`.`ships".$playNum."`(shipT VARCHAR(20), coordinates VARCHAR(20), isSunk VARCHAR(5))";
$conn->query($sql);
$sql = "DROP TABLE `db319t32`.`turn`";
$conn->query($sql);
$sql = "CREATE TABLE IF NOT EXISTS `db319t32`.`turn`(turnCount VARCHAR(3), winner VARCHAR(1))";
$conn->query($sql);
$sql = "INSERT INTO `db319t32`.`turn`(turnCount, winner) VALUES ('1', '0')";
$conn->query($sql);
$sql =  "DROP TABLE `db319t32`.`playernames`";
$conn->query($sql);
$sql = "CREATE TABLE IF NOT EXISTS `db319t32`.`playernames`(playernum VARCHAR(3), player_name VARCHAR(250))";
$conn->query($sql);
$sql = "INSERT INTO `db319t32`.`playernames`(playernum, player_name) VALUES ('".$_SESSION['playerNum']."','".$_SESSION['uname']."')";
$conn->query($sql);
for($row = 1; $row < 9; $row++) {
    for ($col = 1; $col < 9; $col++) {
        $sql = "INSERT INTO `db319t32`.`table" . $_SESSION['playerNum'] . "`(divID, hasbox, shiptype, ishit) VALUES (" . $row . $col . ",'false','nothing','false')";
        $conn->query($sql);
    }
}
?>
<html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link rel="stylesheet" href="style1.css">
<head>
    <title>Choose Battleship Positions</title>
    <h1>Choose Battleship Positions!</h1>
</head>
<body>
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
            echo "<td id='" . $i . $j . "' class='divClick'>
            <div id='" . $i . $j . "' class='showingDiv'>
            <div id='" . $i . $j . "hidden' class='infodiv'></div>
           <div id='dir" . $i . $j . "' class = 'dirDiv'>
            <select id='sel".$i.$j."'>
            <option value='Default' selected='selected'></option>
            <option value='South'>South</option>>
            <option value='East'>East</option>
            </select>
            </div>
            </div>
            </td>";
        }
    }
    echo "</tr>";
}

 ?>
    <div class="legend" >
        <h3 align="center"><u>Legend: </u></h3><br>
        <label>(a)Aircraft Carrier: 5 Cells</label><br><br>
        <label>(b)BattleShip: 4 Cells</label><br><br>
        <label>(s)Submarine: 3 Cells</label><br><br>
        <label>(d)Destroyer: 3 Cells</label><br><br>
        <label>(p)PatrolBoat: 2 Cells</label><br><br>
    </div>
</table><br><br>
<input  type="button" value="Exit" class="playBtns" onclick="window.location.href='logout.php'">
</body>
<script>
    $(document).ready(function () {
       $(".infodiv").hide();
        $(".dirDiv").hide();
    });

    $(".divClick").on('click',function (e) {
        $("#dir" + e.target.id).toggle();
        $("#sel"+e.target.id).on('change',function ()
        {
            var dir = $("#sel"+e.target.id).val();
            var shipType = prompt("Enter Ship Type(a,b,d,s,p)","");
            shipType = shipType.toLowerCase();
            var cords = e.target.id;
            var row = parseInt(cords.substr(0,1));
            var col = parseInt(cords.substr(1,1));
            var shipSize=0;
            var warns = "none";
            switch (shipType)
            {
                case "a":
                    shipSize = 5;
                    break;
                case "b":
                    shipSize = 4;
                    break;
                case "d":
                    shipSize = 3;
                    break;
                case "s":
                    shipSize = 3;
                    break;
                case "p":
                    shipSize = 2;
                    break;
                default:
                    warns = "Invalid ship type "+ shipType.toString();
                    alert(warns);
                    $("#sel" + row + col).val("Default");
                    break;
            }
            if (dir == "South" && row+shipSize > 9) {
                warns="oob";
            }
            else if(dir =="East" && col + shipSize > 9) {
                warns = "oob";
            }
			
            $.ajax({
                type: 'POST',
                url: "shipCreation.php",
                data: {
                    sSize: shipSize,
                    stype: shipType,
                    direction: dir,
                    cord: cords,
                    toRet: warns
                }
            }).done(function (msg) {
                console.log(msg);
                if (msg.localeCompare("donego") == 0) {
                    window.location.href = 'WaitingForOther.php';
                }
                else if (dir == "South") {
                    if (row + shipSize > 9 || msg.localeCompare("go") != 0) {
                        alert('Invalid Ship Placement');
                        $("#sel" + row + col).val("Default");
                    }
                    else {
                        for (var i = row; i < row + shipSize; i++) {
                            $("#sel" + i + col).hide();
                            $("#" + i + col).html(shipType.toLowerCase());
                        }
                    }
                }
                else if (dir == "East") {
                    if (col + shipSize > 9 || msg.localeCompare("go") != 0) {
                        alert('Invalid Ship Placement');
                        $("#sel" + row + col).val("Default");
                    }
                    else {
                        for (var i = col; i < col + shipSize; i++) {
                            $("#sel" + row + i).hide();
                            $("#" + row + i).html(shipType);
                        }
                    }

                }
            });
        });
    });
</script>
</html>