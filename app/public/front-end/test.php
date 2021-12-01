<html>
    <head>
        <title>
            Maxwels
        </title>
        <link rel="shortcut icon" type="x-icon" href="pictures/logo_small_icon_only.png"/>
        <meta charset="utf-8"/>
    </head>
    <body>
        <div class="easter-egg" id="eegg" onclick="eegg('eegg')">
            .
        </div>
        <div class="page">
            <ul class="side-menu" id="sideMenu">
                <li class="login-field" id="loginField" style="display: none;">
                    <form class="login">
                        <input type="text" placeholder="Username" name="user"/>
                        <input type="password" placeholder="Password" name="login-password"/>
                        <span class="log-buttons">
                            <input type="submit" value="Login"/>
                            <input type="button" value="Register" onclick="register()"/>
                            <input type="button" value="Cancel" onclick="logout()"/>
                        </span>
                    </form>
                </li>
                <li>
                    <a onclick="showLogin()" id="showLoginButton">
                        Login
                    </a>
                </li>
                <li> <a href='http://localhost/requestProgrammer.php' target='_blank' id='request'>
                        Requests
                    </a>
                </li>
                <li> <a href='http://localhost/requestCustomer.php' target='_blank' id='request'> Requests </a> </li>
                    <li>
                        <a onclick="logout()">
                            Logout
                        </a>
                    </li>
                <li>
                    <a href="#statistic">
                        About
                    </a>
                </li>
                <li>
                    <a href="#news">
                        News
                    </a>
                </li>
                <li>
                    <a href="#contacts">
                        Contacts
                    </a>
                </li>
                <li>
                    <button class="side-menu-button1" id="smButton2" onclick="closeSideMenu()">
                        X
                    </button>
                </li>
            </ul>

            <div class="header">
                <img id="websiteLogo" src="pictures/maxwel_cover(2).jpg" width="100%"/>
                <img style="top: 0" class="side-menu-button2" id="smButton" onclick="openSideMenu()" src="pictures/menu.png" height="50px" width="100px"/>
            </div>
            <div class="spacer">
                <p> Programmer you can trust! </p>
            </div>
            <div class="content">
                <div class="main-page">
                    <div class="statistic" id="statistic">

                        <div id="6" onclick="newsBlockOpen(6)" onmouseleave="newsBlockClose(6)">
                            <h1 id="60"> About Us </h1>
                            <p id ="61"> 
                                Text
                            </p>
                        </div>
                        
                        <div id="7" onclick="newsBlockOpen(7)" onmouseleave="newsBlockClose(7)">
                            <h1 id="70"> Requests</h1>
                            <p> 0 </p>
                        </div>

                        <div id="8" onclick="newsBlockOpen(8)" onmouseleave="newsBlockClose(8)">
                            <h1 id="80"> Rating </h1>
                            <p id='81'>$rating%  satisfaction rate </p>
                            <p id='81'> No satisfaction rate </p>
                        </div>
                    </div>
                    <div class="spacer">
                        <p> What happend and What will happen </p>
                    </div>
                    <div class="news-overlay" id ="news">
                        <div class="news-container">
                            <div class="news" id="1" onclick="newsBlockOpen(1)" onmouseleave="newsBlockClose(1)">
                                <div class="news-panel">
                                    <img id="10" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> First Post </h1>
                                    <p id="11"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="2" onclick="newsBlockOpen(2)" onmouseleave="newsBlockClose(2)">
                                <div class="news-panel">
                                    <img id="20" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Second Post </h1>
                                    <p id="21"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="3" onclick="newsBlockOpen(3)" onmouseleave="newsBlockClose(3)">
                                <div class="news-panel">
                                    <img id="30" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Third Post </h1>
                                    <p id="31"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="4" onclick="newsBlockOpen(4)"onmouseleave="newsBlockClose(4)">
                                <div class="news-panel">
                                    <img id="40" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Fourth Post </h1>
                                    <p id="41"> Text </p>
                                </div>
                            </div>

                            <div class="news" id="5" onclick="newsBlockOpen(5)" onmouseleave="newsBlockClose(5)">
                                <div class="news-panel">
                                    <img id="50" src="pictures/logo_icon_inverted.png" height="100px" width="100px"/>
                                    <h1> Fifth Post </h1>
                                    <p id="51"> Text </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="spacer">
                <p> How You can contact me </p>
            </div>
            <div class="footer">
                <img src="pictures/smaller_icon.png" width="200" height="200" />
                <div class="contacts" id="contacts">
                    <p> Copyright © Maxwels 2021 </p>
                    <p> maxwels-programming@gmail.com </p>
                    <p> Tel: 2365/424523542625 </p>
                </div>
            </div>
        </div>
    </body>
</html>