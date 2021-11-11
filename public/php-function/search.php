<?php
    session_start();
?>
<?php
    $servername = "db";
    $username = "maxim";
    $password = "maxim_password";
    $dbname ="maxwels";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $searchText = $_GET['search'];
    var_dump($searchText);
    $searchUser = $conn->query("SELECT * FROM `user` WHERE `Username` = '$searchText' OR `Email` = '$searchText'") or die($conn->error);
    
    
?>