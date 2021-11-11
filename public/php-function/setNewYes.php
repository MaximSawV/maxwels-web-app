<?php
    require_once("db_connect.php");
    $id = $_GET['news'];
    $setSeenYes = $pdo->prepare("UPDATE `news` SET `Seen` = 'YES' WHERE N_ID = '$id'");
    $setSeenYes->execute() or die();
?>