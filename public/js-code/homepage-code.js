function showLogin() {
    document.getElementById("loginField").style.display = "block";
    document.getElementById("showLoginButton").style.display ="none";
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