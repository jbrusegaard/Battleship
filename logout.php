<?php
session_start();
$username = "root";
$password = "root";
$dbServer = "localhost";
$dbName   = "db319t32";
$conn = new mysqli($dbServer, $username, $password, $dbName);
$sql = "UPDATE `db319t32`.`players`
SET status = 'NotReady'
WHERE playerNum = '".$_SESSION['playerNum']."'";
$conn->query($sql);
$conn->close();
session_destroy();

echo "<script> window.location.href = 'index.html'</script>";
