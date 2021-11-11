<?php
    session_start();
    require_once("db_connect.php");
    if (isset($_GET['request'])) {
        $rid = $_GET['request'];
        $pid = $_SESSION['id'];
        var_dump($rid, $pid);
        $updateRequest = $pdo->prepare("UPDATE `requests` SET `Status` = 'DONE' WHERE `R_ID` = :rid");
        $updateRequest->execute(["rid" => $rid]);
        var_dump($updateRequest);
    }
?>