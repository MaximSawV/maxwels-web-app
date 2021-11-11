<?php
    require_once("db_connect.php");
    if(isset($_GET['newDate'])){
        $newDeadline = $_GET['newDate'];
    }
    $rid = $_GET['request'];
    $method = $_GET['method'];
    if ($_GET['method'] == "edit") {
        $updateDate = $pdo->prepare("UPDATE `requests` SET `Deadline` = '$newDeadline' WHERE `R_ID` = '$rid'");
        $updateDate->execute() or die();
    }

    if ($_GET['method'] == "delete") {
        $deleteRequest = $pdo->query("DELETE FROM `requests` WHERE `R_ID` = '$rid'");
        $deleteRequest->execute() or die();
    }
?>
