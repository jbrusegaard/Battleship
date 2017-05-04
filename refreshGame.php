<?php
session_start();

$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$conn = new mysqli($dbServer, $username, $password, $dbName);
$sql = "SELECT `turnCount` , `winner` FROM `db319t32`.`turn`";
$result = $conn->query($sql)->fetch_assoc();
$winner =  intval($result['winner']);

if($winner > 0)
{
    echo "game";
}
if($result['turnCount'] % 2 == 1 && $_SESSION['playerNum'] == 1)
{
    echo "done";
}
elseif($result['turnCount'] % 2 == 0 && $_SESSION['playerNum'] == 2)
{
    echo "done";
}

$conn->close();