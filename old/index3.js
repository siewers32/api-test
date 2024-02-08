async function postJSON(data) {
    try {
      const response = await fetch("http://localhost:8777/api2.php", {
        method: "POST", // or 'PUT'
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({"limit":5}),
      });
  
      const result = await response.json();
      console.log("Success:", result);
    } catch (error) {
      console.error("Error:", error);
    }
  }
  
  const data = { username: "example" };
  postJSON(data);