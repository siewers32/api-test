

// adding event listeners to the buttons
const port = 8777;

getButton.addEventListener("click", () => {
    // call the sendHttpRequest function which returns a promise
    sendHttpRequest("GET", "http://localhost:"+ port +"/api.php?bal=bla" )
      .then((responseData) => {
        // insert the data in dataDiv
        dataDiv.textContent = JSON.stringify(responseData);
        console.log(responseData);
      })
      .catch((error) => {
        dataDiv.textContent = JSON.stringify(error);
        console.error(error);
      });
  });
  
  postButton.addEventListener("click", () => {
    // POST method to register a user
    const frm = document.getElementById("fla")
    fdata = formSerialize(frm)

    sendHttpRequest("POST", "http://localhost:"+ port +"/api.php", fdata)
      .then((responseData) => {
        dataDiv.textContent = JSON.stringify(responseData);
        console.log(responseData);
        frm.token.value = responseData.request.token
      })
      .catch((error) => {
        dataDiv.textContent = JSON.stringify(error);
        console.error(error);
      });
  });

  const sendHttpRequest = (method, url, data) => {
    // fetch() returns a Promise object
    return fetch(url, {
      method: method,
      body: JSON.stringify(data),
      //body: data,
      //headers: { "Content-Type": "application/json" },
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',                 
        'Accept': '*/*' 
     },
    }).then((response) => {
      console.log(response); // response is stream data
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

  function formSerialize(form) {
    const data = new FormData(form);
    //https://stackoverflow.com/a/44033425/1869660
    return new URLSearchParams(data).toString();
}

function formDeserialize(form, data) {
    const entries = (new URLSearchParams(data)).entries();
    for(const [key, val] of entries) {
        //http://javascript-coder.com/javascript-form/javascript-form-value.phtml
        const input = form.elements[key];
        switch(input.type) {
            case 'checkbox': input.checked = !!val; break;
            default:         input.value = val;     break;
        }
    }
}
