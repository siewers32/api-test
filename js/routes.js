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
    localStorage.removeItem('token')
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

function flogout() {
    localStorage.removeItem("token")
    frequest('logout', "POST").then((data) => {
        console.log(data)
        jsonCode('logout').innerText = JSON.stringify(data, null, 3)
    })
    .catch((error) => {
        console.error(error);
    });
}

function fcar() {
    frequest('car', "GET").then((data) => {
        console.log(data)
        jsonCode('car').innerText = JSON.stringify(data, null, 3)
    })
    .catch((error) => {
        console.error(error);
    });
}

function fcars() {
    frequest('cars', "POST").then((data) => {
        console.log(data)
        jsonCode('cars').innerText = JSON.stringify(data, null, 3)
    })
    .catch((error) => {
        console.error(error);
    });
}

function fdelete_car() {
    frequest('delete_car', "DELETE").then((data) => {
        console.log(data)
        jsonCode('delete_car').innerText = JSON.stringify(data, null, 3)
    })
    .catch((error) => {
        console.error(error);
    });
}