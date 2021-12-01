<html>
    <head>
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

            $version = rand(0,1000000);
            echo("<link rel='stylesheet' href='phpstyle.css?v=$version'/>");
            require_once("php-function/password_hashing.php");
        ?>
        <title>
            Registrieren
        </title>
        <link rel="shortcut icon" type="x-icon" href="pictures/logo_small_icon_only.png"/>
        <script src="php-website-code.js">
        </script>
        <meta charset="utf-8"/>
    </head>
    <body>
        <div class="register-header">
            <div onclick="logout()"> <== </div>
        </div>
        <div class="register-body">
            <form class="register">
                <input type="text" name="username" placeholder="Username"/>
                <input type="email" name="email" placeholder="Email"/>
                <input type="text" name="password1" placeholder="Password"/>
                <input type="text" name="password2" placeholder="Confirm password"/>
                <input type="text" name="name" placeholder="First or Name of Company"/>
                <input type="text" name="name2" placeholder="Last Name (empty for company)"/>
                <input type="text" name="phone" placeholder="Phone number"/>
                <select name="CorP">
                    <option value="privat">Privat person</option>
                    <option value="company">Company</option>
                </select>
                <input type="submit" value="Registieren"/>
            </form>
            <?php
                if (isset($_GET['username']) && isset($_GET['password1']) && isset($_GET['password2']) && isset($_GET['email']) && isset($_GET['name']) && isset($_GET['phone']) && isset($_GET['CorP'])) {
                    $name = $_GET['username'];
                    $mail = $_GET['email'];
                    $password1 = $_GET['password1'];
                    $password2 = $_GET['password2'];
                    $name2 = $_GET['name'];
                    $number = $_GET['phone'];
                    $mailtest = 0;
                    $nametest = 0;
                    if (strlen($name) != 0 || strlen($mail) != 0 || strlen($password1) != 0 || strlen($password2) != 0 ) {
                        if($password1 == $password2) {
                            $sqlTestUsername = "SELECT `Username` FROM `user` WHERE `Username` = '$name';";
                            $TestUsername=$conn->query($sqlTestUsername);
                            $sqlTestMail = "SELECT `Email` FROM `user` WHERE `Email` = '$mail';";
                            $TestMail=$conn->query($sqlTestMail);
                            $testUserUniqe=0;
                            $testMailUniqe=0;
                            while($row = mysqli_fetch_assoc($TestUsername)) {
                                if($row["Username"] == $name) {
                                    $testUserUniqe = TRUE;
                                    break;
                                }
                            }

                            while($row = mysqli_fetch_assoc($TestMail)) {
                                if($row["Email"] == $mail) {
                                    $testMailUniqe = TRUE;
                                    break;
                                }
                            }


                            if($testUserUniqe == TRUE) {
                                echo("Dieser Name ist bereits vergeben!");
                            }

                            if($testMailUniqe == TRUE) {
                                echo("Dieser Account existiert bereits!");
                            }

                            if ($testUserUniqe + $testMailUniqe == 0 ) {
                                $password1 = hashing($password1, $mail);
                                $sql = "INSERT INTO user (Username, Password, Email) VALUES ('$name', '$password1', '$mail')";
                                $conn->query($sql);
                                $sqlGetID = "SELECT `ID` FROM `user` WHERE `Email` = '$mail';";
                                $GetID=$conn->query($sqlGetID);
                                while($row = mysqli_fetch_assoc($GetID)) {
                                    $c_id = $row["ID"];

                                    if (isset($_GET['name2'])) {
                                        $corp = $_GET['CorP'];
                                        $lastName = $_GET['name2'];
                                        $sql2 = "INSERT INTO customer (C_ID, FirstName_or_NameOfCompany, Last_Name, Phone, Company_or_Privat ) VALUES ('$c_id', '$name2', '$lastName', '$number', '$corp')";
                                        $conn->query($sql2);
                                    
                                    } else {
                                        $corp = $_GET['CorP'];
                                        $sql3 = "INSERT INTO customer (C_ID, FirstName_or_NameOfCompany, Phone, Company_or_Privat ) VALUES ('$c_id', '$name2', '$number', '$corp')";
                                        $conn->query($sql3);
                                    }
                                }
                            }
                        } 
                    }
                }
            ?>
        </div>
    </body>
</html>