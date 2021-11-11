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

    $user = $_SESSION['id'];
    $setBusy = $conn->query("UPDATE programmer p INNER JOIN user u ON u.ID = p.P_ID SET p.Status = 'BUSY' WHERE u.ID = '$user'") or die($conn->error);
?>