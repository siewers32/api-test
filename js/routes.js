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

async function fcar() {
  // const frm = activeForm('car')
  // const fdata = serializeFormData(frm)
  const fdata = getFormData('car')
  let response = await fetch(api + "/?q=car", getOptions("POST", fdata))
    if (errorCheck(response)) {
        let result = await response.json()
        jsonCode('car').innerText = JSON.stringify(result, null, 3)
        console.log(result);
    }
}
 
async function fcars() {
  let response = await fetch(api + "/?q=cars", getOptions())
  if (errorCheck(response)) {
      let result = await response.json()
      jsonCode('cars').innerText = JSON.stringify(result, null, 3)
      console.log(result);
  }
}

function getFormData(q) {
  const frm = activeForm(q)
  return serializeFormData(frm)
}

function getOptions(method, data) {
  if(method == "GET") {
    headers = {
      "Content-Type": "application/json",
      'Authorization': 'Bearer ' + localStorage.getItem('token'),     
    }
  } else if (localStorage.getItem('token') === null){
    headers = {
      'Content-Type': 'application/x-www-form-urlencoded',                 
      'Accept': '*/*' 
    }
  } else {
    headers =  {
      'Authorization': 'Bearer ' + localStorage.getItem('token'),
      'Content-Type': 'application/x-www-form-urlencoded',                 
      'Accept': '*/*' 
    }    
  }
  return  {
    method:method,
    headers: headers,
    body: JSON.stringify(data),
  }
}

function errorCheck(response) {
  let status =  response.status
  console.log(status)
  if(status >= 200 && status < 400) {
      return true;
  } else {
      return false;
  }
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

