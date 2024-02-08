const port = 8777;

getButton = document.getElementById("getButton")
postButton = document.getElementById("postButton")

postButton.addEventListener("click", ()=> {
    postData("http://localhost:"+ port +"/api.php", { answer: 42 }).then((data) => {
        console.log(data); // JSON data parsed by `data.json()` call
    });
})


// getButton.addEventListener("click", () => {
//     // call the sendHttpRequest function which returns a promise
//     sendHttpRequest("GET", "http://localhost:"+ port +"/api.php")
//         .then((responseData) => {
//         // insert the data in dataDiv
//         dataDiv.textContent = JSON.stringify(responseData);
//         console.log(responseData);
//         })
//         .catch((error) => {
//         dataDiv.textContent = JSON.stringify(error);
//         console.error(error);
//         });
//     });

// Example POST method implementation:
async function postData(url = "", data = {}) {
    // Default options are marked with *
    const response = await fetch(url, {
      method: "POST", // *GET, POST, PUT, DELETE, etc.
      mode: "cors", // no-cors, *cors, same-origin
      cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
      credentials: "same-origin", // include, *same-origin, omit
      headers: {
        "Content-Type": "application/json",
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: "follow", // manual, *follow, error
      referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: JSON.stringify(data), // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
  }
  

  