

// adding event listeners to the buttons

getButton.addEventListener("click", () => {
    // call the sendHttpRequest function which returns a promise
    sendHttpRequest("GET", "http://localhost:8787/api.php")
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
    const form = document.querySelector("#testinfo");
    const fdata = new FormData(form);

    sendHttpRequest("POST", "http://localhost:8787/api.php", fdata)
      .then((responseData) => {
        dataDiv.textContent = JSON.stringify(responseData);
        console.log(responseData);
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
      headers: { "Content-Type": "application/json" },
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