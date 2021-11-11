<?php
    session_start();
    require_once("db_connect.php");
    if (isset($_GET['request'])) {
        $rid = $_GET['request'];
        $pid = $_SESSION['id'];
        var_dump($rid, $pid);
        $updateRequest = $pdo->prepare("UPDATE `requests` SET `Working_on` = '$pid', `Status` = 'IN PROGRESS' WHERE `R_ID` = '$rid'");
        $updateRequest->execute();
        var_dump($updateRequest);
    }
?>
