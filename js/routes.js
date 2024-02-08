const api = "http://localhost:8777/api/v1/api.php"
function flogin(frm) {
    console.log(frm)
    fdata = new formSerialize(frm);
    sendHttpRequest("POST", api + "?q=login")
        .then((data) => {
            //console.log(JSON.stringify(data));
            console.log(data);
            window.localStorage.setItem("token", data.data.token)
            dialog.close();
        })
        .catch((error) => {
            console.error(error);
        });
}

function flogout() {
    window.localStorage.removeItem("token")
    sendHttpRequest("POST", api + "?q=logout")
        .then((data) => {
            console.log(data);
        })
        .catch((error) => {
            console.error(error);
        });
}

function fshow(frm) {
    sendHttpRequest("POST", api + "?q=show")
        .then((data) => {
            console.log(data);
        })
        .catch((error) => {
            console.error(error);
        });
}

function fget(frm) {
    fdata = new formSerialize(frm);
    sendHttpRequest("GET", api + "?q=something&" + fdata)
        .then((data) => {
            console.log(data);
        })
        .catch((error) => {
            console.error(error);
        });
}