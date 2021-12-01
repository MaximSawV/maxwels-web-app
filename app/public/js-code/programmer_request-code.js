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

function submitColorChange() {
    document.getElementById("body").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("request-table").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("colorPickerMenu").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("my-table").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("done-table").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("programmer-chart").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
    document.getElementById("programms").style.background = "linear-gradient(to bottom, "+ color1 +" 0%, " + color2 +" 100%)";
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