
const sendHttpRequest = (method, url, data) => {
  // fetch() returns a Promise object
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
    headers = {
      'Authorization': 'Bearer ' + localStorage.getItem('token'),
      'Content-Type': 'application/x-www-form-urlencoded',                 
      'Accept': '*/*' 
    }    
  }
  return fetch(url, {
    method: method,
    body: JSON.stringify(data),
    headers: headers,
  }).then((response) => {
    //console.log(response); // response is stream data
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


