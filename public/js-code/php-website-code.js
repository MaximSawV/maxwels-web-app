"use strict";
let to;
function getRandomInt(max) {
  return Math.floor(Math.random() * max);
}


function openSideMenu() {
    var elem = document.getElementById("sideMenu");
    var pos = -200;
    var id;
    clearInterval(id);
    id = setInterval(frame, 1);
    function frame() {
        if (pos > 0) {
        clearInterval(id);
        } else {
        pos+=3;
        elem.style.left = pos + 'px';
        }
    }

    document.getElementById("smButton").style.display = "none";
    document.getElementById("sideMenu").style.display = "flex";
}

function closeSideMenu() {
    var elem = document.getElementById("sideMenu");
    var pos = 0;
    
    var id;
    clearInterval(id);
    id = setInterval(frame, 1);
    function frame() {
        if (pos < -207) {
        clearInterval(id);
        } else {
        pos-=3;
        elem.style.left = pos + 'px';
        }
    }

    document.getElementById("smButton2").style.display = "block";
    document.getElementById("smButton").style.display = "block";
}

function showLogin() {
    document.getElementById("loginField").style.display = "block";
    document.getElementById("showLoginButton").style.display ="none";
}

function reload() {
    self.location = "http://localhost/test.php";
}

function logout(x) {
    self.location = "http://localhost/test.php?logged=no";

    if (x == 2) {
        self.location = "http://localhost/test.php";
    }
}

function loginOut() {
    document.getElementById("loginField").style.display = "none";
}

function test() {
    document.getElementById("showLoginButton").style.display ="none";
}

function register() {
    self.location ="registrieren.php"
}

function resizeWebsiteLogo() {
    const windowInnerWidth  = document.documentElement.clientWidth;
    const windowInnerHeight = document.documentElement.clientHeigh;
    document.getElementById("websiteLogo").width = windowInnerWidth;
    document.getElementById("websiteLogo").height = windowInnerHeight;
}

function showAll() {
    document.getElementById("addRequests").style.display = "none";
    document.getElementById("doneRequests").style.display = "none";
    document.getElementById("allRequests").style.display = "flex";
}

function addRequests() {
    document.getElementById("addRequests").style.display = "flex";
    document.getElementById("doneRequests").style.display = "none";
    document.getElementById("allRequests").style.display = "none";    
}

function showDone() {
    document.getElementById("addRequests").style.display = "none";
    document.getElementById("doneRequests").style.display = "flex";
    document.getElementById("allRequests").style.display = "none";
}

function myRequests() {
    document.getElementById("myRequests").style.display = "flex";
    document.getElementById("allRequests").style.display = "none";
    document.getElementById("doneRequests").style.display = "none";
    document.getElementById("colorPickerMenu").style.display = "none";
}

function showAll2() {
    document.getElementById("myRequests").style.display = "none";
    document.getElementById("allRequests").style.display = "flex";
    document.getElementById("doneRequests").style.display = "none";
    document.getElementById("colorPickerMenu").style.display = "none";
}

function showDone2() {
    document.getElementById("myRequests").style.display = "none";
    document.getElementById("doneRequests").style.display = "flex";
    document.getElementById("allRequests").style.display = "none";
    document.getElementById("colorPickerMenu").style.display = "none";
}

function showColorPicker() {
    document.getElementById("myRequests").style.display = "none";
    document.getElementById("allRequests").style.display = "none";
    document.getElementById("doneRequests").style.display = "none";
    document.getElementById("colorPickerMenu").style.display = "flex";
}

let select;
let hexNumber;
let color1;
let color2;
function selectColor(id) {
    if (id == "color1") {
        document.getElementById(id).style.borderColor = "white";
        document.getElementById("color2").style.borderColor = "black";
    }
    if (id == "color2") {
        document.getElementById(id).style.borderColor = "white";
        document.getElementById("color1").style.borderColor = "black";
    }
    select = id;
    return select;

}

function changeColor(id) {
    let value1;
    let value2;
    let value3;
    if (id = 1) {
        value1 = document.getElementById("green").value;
        document.getElementById("green2").style.backgroundColor = "rgb(0, "+value1+", 0)";
        document.getElementById("green2").innerHTML = value1;
    }

    if (id = 2) {
        value2 = document.getElementById("red").value;
        document.getElementById("red2").style.backgroundColor = "rgb("+value2+" , 0 , 0)";
        document.getElementById("red2").innerHTML = value2;
    }

    if (id = 3) {
        value3 = document.getElementById("blue").value;
        document.getElementById("blue2").style.backgroundColor = "rgb(0, 0, "+value3+")";
        document.getElementById("blue2").innerHTML = value3;
    }

    let r = parseInt(value2);
    let g = parseInt(value1);
    let b = parseInt(value3);
    
    covertHex(r, g, b);
    function covertHex(r, g, b) {
        let r2 = r.toString(16);
        if (r2.length == 1){
            r2 = "0"+r2;
        }
        let g2 = g.toString(16);
        if (g2.length == 1){
            g2 = "0"+g2;
        }
        let b2 = b.toString(16);
        if (b2.length == 1){
            b2 = "0"+b2;
        }
        hexNumber = "#" + r2 + g2 + b2;
        return hexNumber;
    }

    if (select == "color1") {
        document.getElementById(select).style.backgroundColor = hexNumber;
        color1 = hexNumber;
        return color1;
    }

    if (select == "color2") {
        document.getElementById(select).style.backgroundColor = hexNumber;
        color2 = hexNumber;
        return color2;
    }
}

let eg = 0;

function eegg(id) {
    eg+=1;
    let egg = document.getElementById(id);
    console.log(eg);
    if(eg >= 5) {
        egg.style.backgroundColor = "wheat"
    } 
    if(eg >= 10) {
        console.log("oh no, you broke it!");
        egg.style.backgroundColor = "transparent"
    }

    if(eg >= 6) {
        let x = getRandomInt(window.innerWidth - 44)
        let y = getRandomInt(window.innerHeight - 44)
        egg.style.left = x +"px";
        egg.style.top = y +"px";
    }
}

function submitColorChange() {
    document.getElementById("body").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("request-table").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("colorPickerMenu").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("my-table").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("done-table").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("programmer-chart").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("programms").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
}


function editRequest(rid, method) {
    console.log(method);
    if (method == "delete") {
        setRequest(rid, "delete");
    }
    if (method == "edit") {
        document.getElementById("popup").style.display = "block";
        document.getElementById("popupButton").setAttribute("onclick", "setRequest("+rid+", 'edit')");
    }
}

function showMessages(id) {
    document.getElementById("addRequests").style.display = "none";
    document.getElementById("doneRequests").style.display = "none";
    document.getElementById("allRequests").style.display = "none";
    document.getElementById(id).style.display = "flex";
}

function closeMessageBox(id) {
    document.getElementById(id).style.display = "none";
}

//php-fetch_________________________________________________________________________________________________________________________________________________

function setBusy() {
    fetch("http://localhost/php-function/setBusy.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
    })
    .then(() => {
        document.getElementById("indicator").style.backgroundColor = "red";
        document.getElementById("indicator").style.left = "77%";
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

function setAvailable() {
    fetch("http://localhost/php-function/setAvailable.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
    })
    .then(() => {
        document.getElementById("indicator").style.backgroundColor = "#00ff00";
        document.getElementById("indicator").style.left = "94%";
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

function search(user, seek) {
    fetch("http://localhost/php-function/search.php?user="+user+"&search="+seek, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body: `search=${seek}`
    })
    .then(() => {
        //
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

function setRequest(rId, method) {
    let newDate = document.getElementById("newDeadline").value;
    fetch("http://localhost/php-function/edit_request.php?method="+method+"&request="+rId+"&newDate="+newDate, {
        method: "POST",
        headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body:   `request=${rId}`,
        body:   `newDate=${newDate}`
    })
    .then(() => {
        self.location = "http://localhost/requestCustomer.php";
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

function setSeenYes(id) {
    fetch("http://localhost/php-function/setNewYes.php?news="+id, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body:   `news=${id}`
    })
    .then(() => {
        self.location = "http://localhost/requestCustomer.php";
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

function setRequestDone(rId) {
    fetch("http://localhost/php-function/done_request.php?request="+rId, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body:   `request=${rId}`
    })
    .then(() => {
        self.location = "http://localhost/requestProgrammer.php";
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

function takeRequest(rId) {
    fetch("http://localhost/php-function/take_request.php?request="+rId, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body:   `request=${rId}`
    })
    .then(() => {
        self.location = "http://localhost/requestProgrammer.php";
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

function rateDoneRequest(rId, rating, nId) {
    fetch("http://localhost/php-function/rate_request.php?satisfied="+rating+"&request="+rId+"&news="+nId, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
        },
        body:   `request=${rId}`,
        body:   `satisifed=${rating}`,
        body:   `news=${nId}`
    })
    .then(() => {
        self.location = "http://localhost/requestCustomer.php";
    })
    .catch(() => {
        alert("Please conntact our support under maxwels.contacts@gmail.com");
    })
    ;
}

//Animations________________________________________________________________________________________________________________________________________________
function newsBlockOpen(id) {
    const element = (document.getElementById(id));
    const styles = getComputedStyle(element);

    let width = styles.getPropertyValue('width');
    let height = styles.getPropertyValue('height');
    let maxSize = 400;
    height = parseInt(height, 10);
    width = parseInt(width, 10);
    const speed = 5;
    function showContent() {
        if(id < 6){
            document.getElementById(id*10).style.display = "block";
            document.getElementById(id*10+1).style.display = "block";
        }else {
            document.getElementById(id*10).style.display = "none";
            document.getElementById(id*10+1).style.display = "block";
        }
    }

    let int = setInterval(frame, 1);
    function frame() {
        if(width<maxSize) {
            document.getElementById(id).style.width = width;
            width+=speed;
        }

        if (height<maxSize) {
            document.getElementById(id).style.height = height;
            height+=speed;
        }

        if (height >= maxSize && width >= maxSize) {
            clearInterval(int);
            to = setTimeout(showContent, 500);
        }
    }
}


function newsBlockClose(id) {
    clearTimeout(to)
    const element = (document.getElementById(id));
    const styles = getComputedStyle(element);

    let width = styles.getPropertyValue('width');
    let height = styles.getPropertyValue('height');
    let maxWidth = 365;
    let maxHeight = 205;
    height = parseInt(height, 10);
    width = parseInt(width, 10);
    const speed = 5;
    if (height <=400){
        if (id < 6) {
            document.getElementById(id*10).style.display = "none"
            document.getElementById(id*10+1).style.display = "none"
        }else{
            document.getElementById(id*10).style.display = "block"
            document.getElementById(id*10+1).style.display = "none"
        }
    }
    
    let int = setInterval(frame, 1);
    function frame() {
        if(width>maxWidth) {
            document.getElementById(id).style.width = width;
            width-=speed;
        }

        if (height>maxHeight) {
            document.getElementById(id).style.height = height;
            height-=speed;
        }

        if (height <= maxHeight && width <= maxWidth) {
            clearInterval(int);
        }
    }
}
function randomColor() {
    let first2byte = Math.floor(Math.random()*256);
    let second2byte = Math.floor(Math.random()*256);
    let last2byte = Math.floor(Math.random()*256);
    first2byte = first2byte.toString(16);
    second2byte = second2byte.toString(16);
    last2byte = last2byte.toString(16);
    var newColour = "#"+last2byte+second2byte+first2byte;
    document.getElementById("müllding").style.background = newColour;
    document.getElementById("müllding").style.right = first2byte+"px";
    document.getElementById("müllding").style.bottom = last2byte+"px";
}

function dance () {
    let dancing = setInterval(randomColor, 100);
    //clearInterval(dancing);
}

function stopDance() {
    clearInterval(dancing);
}