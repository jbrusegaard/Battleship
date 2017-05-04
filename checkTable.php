<?php
session_start();

$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$conn = new mysqli($dbServer, $username, $password, $dbName);
$sql = "SELECT `players`.`playerNum`,`players`.`status`FROM `db319t32`.`players`";
$result = $conn->query($sql);
$temp = $result->fetch_assoc()['status'];
$temp2 = $result->fetch_assoc()['status'];
$conn->close();
if($temp == 'Ready' && $temp2 == 'Ready')
{
    echo "done";
}