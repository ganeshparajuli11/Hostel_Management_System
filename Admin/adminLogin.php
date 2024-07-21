<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <title>HostelStays</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">

    <p class="login-text">Admin Login Page</p>
    <div class="line"></div>

    <p id="email-id">Email or username</p>
    <input type="text" id="username" name="username" placeholder="Enter your username">

    <p id="pass-id">Enter password</p>
    <input type="password" id="password" name="password" placeholder="Enter your Password">

    <input type="checkbox" id="showPasswordCheckbox">
    <label for="showPasswordCheckbox">Show Password</label>
    <br>

    <div id="warning"></div>

    <button type="submit" id="sign-in">Sign in</button>

  </div>

  <script>
    document.getElementById("showPasswordCheckbox").addEventListener("change", function() {
      var passwordField = document.getElementById("password");
      if (this.checked) {
        passwordField.type = "text";
      } else {
        passwordField.type = "password";
      }
    });

    document.getElementById("sign-in").addEventListener("click", function(event) {
      event.preventDefault(); // Prevent the default form submission

      let username = document.getElementById("username").value;
      let password = document.getElementById("password").value;

      if (username === "" || password === "") {
        document.getElementById("warning").innerText = "Email and password are required.";
        return; // Stop further execution if fields are empty
      }

      // Send AJAX request to login.php
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "../login.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
          if (xhr.status == 200) {
            console.log("Response from login.php:", xhr.responseText); // Log the response
            // Check if the response exactly matches "success"
            if (xhr.responseText.trim() === "success") {
              // If login is successful, redirect to home.php
              console.log("Redirecting to home.php");
              window.location.href = "home.php";
            } else {
              // Display "Invalid credentials" message
              document.getElementById("warning").innerText = "Invalid credentials. Please try again.";
            }
          } else {
            console.error("Error: ", xhr.status);
          }
        }
      };
      xhr.send("username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password));
    });
  </script>
</body>
</html>
