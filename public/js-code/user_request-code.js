function showAll() {
    window.location.replace("http://localhost/request/user/all_requests");
}

function addRequests() {
    window.location.replace("http://localhost/request/user/add_requests");
}

function showDone() {
    window.location.replace("http://localhost/request/user/done_requests");
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
}

function editDeadline(rid) {
    document.getElementById(rid).innerHTML = "<form action=\"all_requests/edit_deadline\" method=\"post\">" +
        "<input type='date' name='newDeadline'/>" +
        "<input type='hidden' name='request_id' value={{request.getId}}>" +
        "<input type='submit' value='Change'/>"
}