<?php
    ini_set('session.gc_maxlifetime', 86400);
    session_set_cookie_params(86400);
    session_start();
?>
<html>
    <head>
        <?php
            require_once("php-function/db_connect.php");
            require_once("php-function/class.php");
            $loggedIn = 0;
            $version = rand(0,999999999) + rand(0,999999999);
            echo("<link rel='stylesheet' href='phpstyle.css?v=$version'/>
                <script src='php-website-code.js?v=$version'></script>
            ");
        ?>
        <meta charset="utf-8"/>
        <link rel="shortcut icon" type="x-icon" href="pictures/logo_small_icon_only.png"/>
        <title>
            Your Requests
        </title>
    </head>
    <body class="bg">
        <div class="face">
            <div class="mail-icon" onclick="showMessages('messageBox')">
                <image src="pictures/mail_icon.png" style="height: 90"/>
            </div>
            <div class="notification">
                <?php
                    $id = $_SESSION['id'];
                    $countNewNews = $pdo->prepare("SELECT COUNT(`N_ID`) as `number` FROM `news` WHERE `For` = :id AND `Seen` = 'NO';");
                    $countNewNews->execute(['id' => $id]);
                    $result = $countNewNews->fetch(PDO::FETCH_ASSOC);
                    $text = $result['number'];
                    echo("<p class='number' id='number'> $text </p>")

                ?>
            </div>
            <div class="programmer-bar">
                <ul>
                    <li class="programmers">
                        <a class="list-face">
                            Programmer
                        </a>
                        <ul>
                            <?php
                                $getAllProgrammerStatement = $pdo->prepare("SELECT `P_ID`, `Status`, `user`.`Username` AS 'Username', `user`.`Email` AS 'Email' 
                                FROM programmer INNER JOIN `user`ON `P_ID` = `ID`");
                                $getAllProgrammerStatement->execute();
                                while ($programmer = $getAllProgrammerStatement->fetch(PDO::FETCH_ASSOC)) {
                                    $pid = $programmer["P_ID"];
                                    $status = $programmer["Status"];
                                    $mail = $programmer["Email"];
                                    $username = $programmer["Username"];

                                    if($pid != $_SESSION['id']) {
                                        if ($status == "AVAILABLE") {
                                        echo ("<li> <a href='mailto:$mail' id='you' class='programmer-icon' style='background-color: #00ff00; color:black;'> $username is $status </a></li>");
                                        }

                                        if ($status == "BUSY") {
                                            echo ("<li> <a id='you' class='programmer-icon' style='background-color: #ff0000; color:black;'> $username is $status </a></li>");
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </li>
                    <li class="programm-theme">
                        <a class="list-face">
                            Programms
                        </a>
                        <ul>
                            <li>
                                <a>
                                    Website
                                </a>
                            </li>
                            <li>
                                <a>
                                    Design
                                </a>
                            </li>
                            <li>
                                <a>
                                    Game
                                </a>
                            </li>
                            <li>
                                <a>
                                    Database
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <form class="search-field" method="post">
                            <input class="type-field" type="test" list ="suggestions"name="search"/>
                            <datalist id="suggestions" name="search">
                            <?php
                                $getAllProgrammerStatement = $pdo->prepare("SELECT `Email`, `Username` FROM `user` WHERE `Is` = 'Programmer'");
                                $getAllProgrammerStatement->execute();
                                while ($programmer = $getAllProgrammerStatement->fetch(PDO::FETCH_ASSOC)) {
                                    $mail = $programmer["Email"];
                                    $name = $programmer["Username"];
                                    echo("<option value='$name | $mail'>");
                                }
                            ?>
                            </datalist>
                            <input class="search-button" type="submit" value="🔎" onclick="search($_GET['search'])"/>
                        </form>
                    </li>
                    <li class="help">
                        <a href="mailto:maxwels.contacts@gmail.com" class="list-face">
                            ?
                        </a>
                    <li>
                </ul>
            </div>
            <div class="request-bar">
                <ul>
                    <li class="request-list">
                        <a class="list-face" onclick="showAll()">
                            Show all
                        </a>
                    </li>
                    <li class="add-request">
                        <a class="list-face" onclick="addRequests()">
                            Add
                        </a>
                    </li>
                    <li class="done-requests">
                        <a class="list-face" onclick="showDone()">
                            Done
                        </a>
                    </li>
                </ul>
            </div>
            <div class="main-screen">
                <div class="all-requests" id="allRequests" style="display: flex">
                    <?php
                        echo( "
                            <table class='request-table' id='request-table'>
                                <thead>
                                    <tr>
                                        <th> Working on </th>
                                        <th> Topic </th>
                                        <th> Type </th>
                                        <th> Requested on </th>
                                        <th> Deadline </th>
                                        <th> Status </th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");
                        $iconSpaceTop = 300;
                        $getAllRequestStatement = $pdo->prepare("SELECT `R_ID`, `Topic`, `Type`, `Requested_on`, `Deadline`, `Status`, `user`.`Username` AS 'WorkingOn' 
                        FROM `requests` INNER JOIN `user` ON `Working_on` = `user`.`ID` WHERE `Status` != 'DONE' AND  `Requested_by` = :id");
                        $getAllRequestStatement->execute(["id" => $_SESSION["id"]]);
                        while ($request = $getAllRequestStatement->fetch(PDO::FETCH_ASSOC)) {
                            $rid = $request["R_ID"];
                            $pName = $request["WorkingOn"];
                            $topic = $request["Topic"];
                            $type = $request["Type"];
                            $requestedOn = $request["Requested_on"];
                            $deadline = $request["Deadline"];
                            $status = $request["Status"];

                                if ($pName == NULL) {
                                    $pName = "None";
                                }

                                $iconSpaceTop += 100;
                                echo("
                                    <tr>
                                        <td class='requester'> <a style='width=100%; height=100%; color: white;' href=mailto:''> $pName </a> </td>
                                        <td> $topic </td>
                                        <td> $type </td>
                                        <td> $requestedOn </td>
                                        <td> $deadline </td>
                                        <td> $status </td>
                                        <td>
                                            <div class='edit-icon' id='editIcon'>
                                                <image class='icon-img' src='pictures/edit_icon.png' onclick='editRequest($rid, \"edit\")'/>
                                                <image class='icon-img' src='pictures/delete-icon.png' onclick='editRequest($rid, \"delete\")'/>
                                            </div>
                                        </td>
                                    </tr>
                                ");
                        }
                        echo("
                                </tbody>
                            </table>
                        ");
                    ?>
                </div>
                <div class="all-requests" id="doneRequests">
                    <?php
                        echo( "
                            <table class='request-table' id='request-table'>
                                <thead>
                                    <tr>
                                        <th> Working on </th>
                                        <th> Topic </th>
                                        <th> Type </th>
                                    </tr>
                                </thead>
                                <tbody>
                        ");
                        $getAllRequestStatement = $pdo->prepare("SELECT `Topic`, `Type`, `Deadline`,`user`.`Username` AS 'WorkingOn' 
                        FROM `requests` INNER JOIN `user` ON `Working_on` = `user`.`ID` WHERE `Status` = 'DONE' AND  `Requested_by` = :id");
                        $getAllRequestStatement->execute(["id" => $_SESSION["id"]]);
                        while ($request = $getAllRequestStatement->fetch(PDO::FETCH_ASSOC)) {
                            $pName = $request["WorkingOn"];
                            $topic = $request["Topic"];
                            $type = $request["Type"];
                                echo("
                                    <tr>
                                        <td id='' class='requester'> <a style='width=100%; height=100%;' href=mailto:''> $pName </a> </td>
                                        <td> $topic </td>
                                        <td> $type </td>
                                    </tr>"
                                );
                        }
                        echo("
                                </tbody>
                            </table>
                        ");
                    ?>
                </div>
                <div class="all-requests" id="addRequests">
                    <div class="createRequestBG">
                        <form class="createRequest">
                            <?php
                                echo("
                                <label for='topic'> What is it about </label><br>
                                <input type='text' id='topic' name='topic'/><br>
                                <input type='radio' id='website' name='type' value='Website'/>
                                <label class='radio-label' for='website'> Website </label><br>
                                <input type='radio' id='Design' name='type' value='Design'/>
                                <label class='radio-label' for='Design'>Design</label><br>
                                <input type='radio' id='Game' name='type' value='Game'/>
                                <label class='radio-label' for='Game'>Game</label><br>
                                <input type='radio' id='Database' name='type' value='Database'/>
                                <label class='radio-label' for='Database'>Database</label><br>
                                <input type='radio' id='Other' name='type' value='Other'/>
                                <label class='radio-label' for='Other'>Other</label><br>
                                <input class= 'radio-label' type='date' id='Date' name='deadline'/><br>
                                <input type='submit' value='Create Request'/> 
                            ");
                                if (isset($_GET['type']) && isset($_GET['topic']) && isset($_GET['deadline']) && isset($_SESSION['id'])) {
                                    $type = $_GET['type'];
                                    $topic = $_GET['topic'];
                                    $deadline = $_GET['deadline'];
                                    $userId = $_SESSION['id'];
                                    $sqlCreateRequest = $pdo->prepare("INSERT INTO `requests`(`Requested_by`, `Topic`, `Type`, `Deadline`) VALUES ('$userId', '$type', '$topic', '$deadline')");
                                    $sqlCreateRequest->execute();
                                    echo ("<script> self.location = 'http://localhost/requestCustomer.php' </script>");
                                }
                            ?>
                        </form>
                    </div>          
                </div>
                <div class="message-box" id="messageBox">
                    <div class="mb-head">
                        <div onclick="closeMessageBox('messageBox')">
                            X 
                        </div>
                    </div>
                    <div class="message-window">
                        <div>
                            <table class='request-table' id='request-table'>
                                <thead>
                                    <tr>
                                        <th> From </th>
                                        <th> Message </th>
                                        <th> Date </th>
                                        <th> Rating </th>
                                        <th> Check </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $getAllNewNews = $pdo->prepare("SELECT `user`.`Username` AS 'From', `requests`.`R_ID` AS 'RID', `news`.`Type` AS 'Message', `news`.`Date_of_Creation` AS 'Date', `news`.`N_ID` AS 'ID' FROM `news` 
                                                                INNER JOIN `user` ON `user`.`ID` = `news`.`Programmer` INNER JOIN `requests` ON `requests`.`R_ID` = `news`.`Request` 
                                                                WHERE `news`.`For` = :id AND `news`.`Seen` = 'NO' ORDER BY `news`.`Date_of_Creation` DESC;");
                                $getAllNewNews->execute(["id" => $_SESSION["id"]]) or die;
                                while ($message = $getAllNewNews->fetch(PDO::FETCH_ASSOC)) {
                                    $from = $message['From'];
                                    $text = $message['Message'];
                                    $date = $message['Date'];
                                    $newsId = $message['ID'];
                                    $rid = $message['RID'];
                                    if ($text == "Request taken") {
                                        echo("
                                        <tr>
                                            <td> $from </td>
                                            <td> $text </td>
                                            <td> $date </td>
                                            <td> 
                                                <image class='icon-img' src='pictures/submitbutton.png' onclick='setSeenYes($newsId)'/>
                                            </td>
                                        </tr>
                                        ");
                                    } else {
                                         echo("
                                        <tr>
                                            <td> $from </td>
                                            <td> $text </td>
                                            <td> $date </td>
                                            <td class=\"rateRequestField\">
                                                <div class=\"positiveRequest\" onclick=\"rateDoneRequest($rid, 'YES', $newsId)\"></div>
                                                <div class=\"negativeRequest\" onclick=\"rateDoneRequest($rid, 'NO', $newsId)\"></div> 
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                        ");
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="popup" class="popup">
            <input type="date" id="newDeadline"/>
            <div class="popup-button" id="popupButton"> Submit </div>
        </div>
    </body>
</html>