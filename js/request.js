function frequest(q, method) {
  const frm = activeForm(q)
  const fdata = serializeFormData(frm)
  if(method == "GET") {
      return sendHttpRequest(method, api + "?q=" + q + "&" + fdata)
  } else {
      return sendHttpRequest(method, api + "?q=" + q, fdata)
  }
}
const sendHttpRequest = (method, url, data) => {
  return fetch(url, {
    method: method,
    body: JSON.stringify(data),
    headers: getHeaders(method),
  }).then((response) => {  
    console.log(response)
    // Handle HTTP errors
    if (response.status >= 400) {
      // convert stream data to JSON
      return response.json().then((errorResponseData) => {
        const error = new Error();
        error.message = "Something went wrong!";
        error.data = errorResponseData;
        throw error;
      });
    }
    return response.json();
  });
};

function serializeFormData(frm) {
  const fd = new FormData(frm)
  return new URLSearchParams(fd).toString()
}

function getHeaders(method) {
  if(method == "GET") {
    return {
      "Content-Type": "application/json",
      'Authorization': 'Bearer ' + localStorage.getItem('token'),
    }
  } else if (localStorage.getItem('token') === null){
    return {
      'Content-Type': 'application/x-www-form-urlencoded',                 
      'Accept': '*/*' 
    }
  } else {
    return {
      'Authorization': 'Bearer ' + localStorage.getItem('token'),
      'Content-Type': 'application/x-www-form-urlencoded',                 
      'Accept': '*/*' 
    }    
  }
}

function toggleOutput(what) {
  out = document.querySelector(`#${CSS.escape(what)} + .output`);
  if (out.style.display == 'none'|| out.style.display == '') {
    out.style.display = 'block'
  } else {
    out.style.display = 'none'
  }
}
