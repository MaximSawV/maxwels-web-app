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

function showMessages(id) {
    document.getElementById("addRequests").style.display = "none";
    document.getElementById("doneRequests").style.display = "none";
    document.getElementById("allRequests").style.display = "none";
    document.getElementById(id).style.display = "flex";
}

function closeMessageBox(id) {
    document.getElementById(id).style.display = "none";
}