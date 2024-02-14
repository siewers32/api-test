const api = "http://localhost:8777/api/v1/api.php"
const jsonCode = (btn) => document.querySelector(`#${CSS.escape(btn)} + .output pre code`)
const outputDiv = (btn) => document.querySelector(`#${CSS.escape(btn)} + .output`)
const activeForm = (btn) => document.querySelector(`#frm${CSS.escape(capitalizeFirstLetter(btn))}`)


function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

async function flogin() {
    const frm = activeForm('login')
    const fdata = serializeFormData(frm)
    localStorage.removeItem('token')
    let response = await fetch(api + "/?q=login", getOptions("POST", fdata))
    if (errorCheck(response)) {
      let result = await response.json()
      localStorage.setItem("token", result.resp.token)
      jsonCode('login').innerText = JSON.stringify(result, null, 3)
  }
}

async function flogout() {
    localStorage.removeItem("token")
    let response = await fetch(api + "/?q=logout", getOptions("GET", ""))
    if (errorCheck(response)) {
      let result = await response.json()
      jsonCode('logout').innerText = JSON.stringify(result, null, 3)
      console.log(result);
  }
}

async function fcar() {
  // const frm = activeForm('car')
  // const fdata = serializeFormData(frm)
  const fdata = getFormData('car')
  let response = await fetch(api + "/?q=car", getOptions("POST", fdata))
    if (errorCheck(response)) {
        let result = await response.json()
        jsonCode('car').innerText = JSON.stringify(result, null, 3)
    }
}
 
async function fcars() {
  const fdata = getFormData('cars')
  let response = await fetch(api + "/?q=cars", getOptions("POST", fdata))
  if (errorCheck(response)) {
      let result = await response.json()
      jsonCode('cars').innerText = JSON.stringify(result, null, 3)
  }
}

async function fdelete_car() {
  const fdata = getFormData('delete_car')
  let response = await fetch(api + "/?q=delete_car", getOptions("DELETE", fdata))
  if (errorCheck(response)) {
    let result = await response.json()
    jsonCode('delete_car').innerText = JSON.stringify(result, null, 3)
    console.log(result);
  }
}



function getOptions(method, data) {
  let options = {}
  options.method = method
  if(method == "GET") {
    options.headers = {
      "Content-Type": "application/json",
      'Authorization': 'Bearer ' + localStorage.getItem('token'),     
    }
  } else if (localStorage.getItem('token') === null){
    options.headers = {
      'Content-Type': 'application/x-www-form-urlencoded',                 
      'Accept': '*/*' 
    }
    options.body = JSON.stringify(data) 
  } else {
    options.headers =  {
      'Authorization': 'Bearer ' + localStorage.getItem('token'),
      'Content-Type': 'application/x-www-form-urlencoded',                 
      'Accept': '*/*' 
    }
    options.body = JSON.stringify(data) 
  }
  return options
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

function getFormData(q) {
  const frm = activeForm(q)
  return serializeFormData(frm)
}