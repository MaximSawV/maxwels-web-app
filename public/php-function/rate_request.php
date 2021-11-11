<?php
    require_once("db_connect.php");
    $rid = $_GET['request'];
    $nid = $_GET['news'];
    $rating = $_GET['satisfied'];
    var_dump($rid, $nid, $rating);
    $rate = $pdo->prepare("UPDATE `requests` SET `Satisfied` = '$rating' WHERE `R_ID` = '$rid';");
    $rate->execute() or die();
    $setSeenYes = $pdo->prepare("UPDATE `news` SET `Seen` = 'YES' WHERE N_ID = '$nid'");
    $setSeenYes->execute() or die();
?>