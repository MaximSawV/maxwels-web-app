<?php

    require("./classes/user_class.php");
    require("./classes/programmer_class.php");
    require("./classes/customer_class.php");
    require("./classes/request_class.php");
    

    function getAllUsers() {
        require("db_connect.php");
        $sqlGetAllUsers = $pdo->prepare("SELECT * FROM `user`");
        $sqlGetAllUsers->execute();
        $allUsers = array();
        while ($row = $sqlGetAllUsers -> fetch()) {
            $newUser = new User($row["ID"], $row["Username"], $row["Email"], $row["Password"], $row["is"], $row["Date of creation"]);
            array_push($allUsers,$newUser);
        }
        return $allUsers;
    }

    function getAllProgrammers() {
        require("db_connect.php");
        $sqlGetAllProgrammers = $pdo->prepare("SELECT * FROM `programmer` INNER JOIN `user` ON `programmer`.`P_ID`=`user`.`ID` ORDER BY `programmer`.`Status`");
        $sqlGetAllProgrammers->execute();
        $allProgrammers = array();
        while ($row = $sqlGetAllProgrammers -> fetch()) {
            $newProgrammer = new Programmer($row["P_ID"], $row["First_Name"], $row["Last_Name"], $row["Done_Request"], $row["Status"], $row["ID"], $row["Username"], $row["Email"], $row["Password"], $row["is"], $row["Date of creation"]);
            array_push($allProgrammers, $newProgrammer);
        }
        return $allProgrammers;
    }

    function getAllCustoms() {
        require("db_connect.php");
        $sqlGetAllCustomers = $pdo->prepare("SELECT * FROM `customer` INNER JOIN `user` ON `customer`.`C_ID`=`user`.`ID`");
        $sqlGetAllCustomers->execute();
        $allCustomers = array();
        while ($row = $sqlGetAllCustomers -> fetch()) {
            $newCustomer = new Customer($row["C_ID"], $row["FirstName_or_NameOfCompany"], $row["Last_Name"], $row["Phone"], $row["Company_or_Privat"], $row["ID"], $row["Username"], $row["Email"], $row["Password"], $row["is"], $row["Date of creation"]);
            array_push($allCustomers, $newCustomer);
        }
        return $allCustomers;
    }

    function getAllRequests() {
        require("db_connect.php");
        $sqlGetAllRequests = $pdo->prepare("SELECT * FROM `requests`");
        $sqlGetAllRequests->execute();
        $allRequests = array();
        while ($row = $sqlGetAllRequests -> fetch()) {
            $newRequest = new Request($row["R_ID"], $row["Requested_by"], $row["Working_on"], $row["Topic"], $row["Type"], $row["Requested_on"], $row["Deadline"], $row["Status"], $row["Satisfied"] );
            array_push($allRequests, $newRequest);
        }
        return $allRequests;
    }
?>