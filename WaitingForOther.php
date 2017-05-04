<?php
session_start();
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
<head>
    <link rel="stylesheet" href="style1.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<title>Waiting for Player</title>
    <h1>Waiting for Opponent!</h1>
</head>
<body style="text-align: center">
    <h4>Waiting on Player <?php echo $waiton?> <br>
    </h4>
    <input type="button" id = "logO" value="Exit" onclick="window.location.href='logout.php'">
<script>
setInterval(refresh, 1000);
function refresh() {
    $.ajax({
        type: "POST",
        url: "checkTable.php",
        data: {
            re: 1
        }
    }).done(function (msg) {
        if (msg.localeCompare("done") == 0) {
            window.location.href = 'playerRedirect.php';
        }
    });
}
</script>
</body>
</html>
