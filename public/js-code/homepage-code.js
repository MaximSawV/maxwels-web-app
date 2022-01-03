"use strict";

function showLogin() {
    document.getElementById("loginField").style.display = "block";
    document.getElementById("showLoginButton").style.display ="none";
}

function hideLogin() {
    document.getElementById("loginField").style.display = "none";
    document.getElementById("showLoginButton").style.display ="block";
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

    hideLogin();
}

function aboutBlockOpen(id, id2) {
    let elem = document.getElementById(id);
    let openInt;
    let size = elem.clientHeight;
    let maxSize = 400;
    clearInterval(openInt);
    openInt = setInterval(open, 1);
    function open() {
        if (size < maxSize){
            size += 3;
            elem.style.height = size + "px";
            elem.style.width = size + "px";
        }

        if (size == maxSize){
            document.getElementById(id2).style.display = "block";
            clearInterval(openInt);
        }
    }
}

function aboutBlockClose(id, id2) {
    let elem = document.getElementById(id);
    let closeInt;
    let size = elem.clientHeight;
    let minSize = 250;
    clearInterval(closeInt);
    closeInt = setInterval(open, 1);
    document.getElementById(id2).style.display = "none";
    function open() {
        if (size > minSize){
            size -= 3;
            elem.style.height = size + "px";
            elem.style.width = size + "px";
        }

        if (size == minSize) {
            clearInterval(closeInt);
        }
    }
}

function newsBlockOpen(id, id2) {
    document.getElementById(id).style.display = "block";
    document.getElementById(id2).style.display = "block";
}

function newsBlockClose(id, id2) {
    document.getElementById(id).style.display = "none";
    document.getElementById(id2).style.display = "none";
}

function createClock() {
    var clock = document.createElement("div");
    clock.id = "clock";
    clock.className = "clock";
    var body = document.getElementById("body");
    body.appendChild(clock);
    uhrzeit();
}

function uhrzeit() {
    var jetzt = new Date(),
        h = jetzt.getHours(),
        m = jetzt.getMinutes(),
        s = jetzt.getSeconds();
    m = fuehrendeNull(m);
    s = fuehrendeNull(s);
    document.getElementById("clock").innerHTML = h + ':' + m + ':' + s;
    setTimeout(uhrzeit, 500);
}

function fuehrendeNull(zahl) {
    zahl = (zahl < 10 ? '0' : '' )+ zahl;
    return zahl;
}

