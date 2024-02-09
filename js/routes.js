const api = "http://localhost:8777/api/v1/api.php"
const jsonCode = (btn) => document.querySelector(`#${CSS.escape(btn)} + .output pre code`)
const outputDiv = (btn) => document.querySelector(`#${CSS.escape(btn)} + .output`)
const activeForm = (btn) => document.querySelector(`#frm${CSS.escape(capitalizeFirstLetter(btn))}`)


function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function flogin(q) {
    const frm = activeForm(q)
    const fdata = serializeFormData(frm)
    const out = jsonCode(q);
    sendHttpRequest("POST", api + "?q=login", fdata)
        .then((data) => {
            //console.log(JSON.stringify(data));
            console.log(data);
            window.localStorage.setItem("token", data.resp.token)
            out.innerText = JSON.stringify(data, null, 3)
        })
        .catch((error) => {
            console.error(error);
        });
}

function flogout(q) {
    const out = jsonCode(q);
    toggleOutput(q)
    window.localStorage.removeItem("token")
    sendHttpRequest("POST", api + "?q=logout")
        .then((data) => {
            console.log(data);
            out.innerText = JSON.stringify(data, null, 3)
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

function fget(q) {
    const frm = activeForm(q)
    const fdata = serializeFormData(frm)
    const out = jsonCode(q);
    sendHttpRequest("GET", api + "?q=get&" + fdata)
        .then((data) => {
            console.log(data);
            out.innerText = JSON.stringify(data, null, 3)
        })
        .catch((error) => {
            console.error(error);
        });
}

function fpost(q) {
    const frm = activeForm(q)
    const fdata = serializeFormData(frm)
    const out = jsonCode(q);
    sendHttpRequest("POST", api + "?q=" + q, fdata)
    .then((data) => {
        //console.log(JSON.stringify(data));
        console.log(data);
        out.innerText = JSON.stringify(data, null, 3)
    })
    .catch((error) => {
        console.error(error);
    });
}