<?php
session_start();
$playerNum = $_SESSION['playerNum'];
if($playerNum == 1)
{
    echo "<script>
        window.location.href = 'play.php';
</script>";
}
else{
    echo "<script>
        window.location.href = 'WaitPage.php';
</script>";
}