<?php
// Database configuration
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "hostel_management_system");

// Initialize error message variable
$password_criteria_err = "";

try {
    // Create a PDO instance
    $dbh = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
} catch (PDOException $e) {
    // If connection fails, display an error message
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Handle form submission
if(isset($_POST['update'])) {
    $email = $_POST['email'];
    $newpassword = $_POST['newpassword'];

    // Password criteria validation
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $newpassword)) {
        $password_criteria_err = "Password must contain at least one uppercase letter, one digit, and be at least 8 characters long"; 
    } else {
        // Prepare SQL statement to select user by email
        $sql = "SELECT email FROM user WHERE email=:email";
        $query = $dbh->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);

        if($query->rowCount() > 0) {
            // If user found, update password
            $con = "UPDATE user SET password=:newpassword WHERE email=:email";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            echo "<script>alert('Your Password successfully changed');</script>";
        } else {
            // If user not found, display error message
            echo "<script>alert('Email id is invalid');</script>"; 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Recovery</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
    }
    .modal {
      display: block;
      background: rgba(0, 0, 0, 0.5);
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
    }
    .modal-dialog {
      margin: 50px auto;
      max-width: 400px;
      background: #fff;
      padding: 20px;
      border-radius: 5px;
    }
    .modal-title {
      font-size: 24px;
      text-align: center;
      margin-bottom: 20px;
    }
    .form-control {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .btn {
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    .text-center {
      text-align: center;
    }
    .gray-text {
      color: #666;
    }
    .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      color: #aaa;
      cursor: pointer;
    }
    .error {
      color: red;
    }
  </style>
</head>
<body>
  <div class="modal">
    <div class="modal-dialog">
      <div class="modal-header">
        <span class="modal-title">Password Recovery</span>
        <span class="close" onclick="closeModal()">×</span>
      </div>
      <div class="modal-body">
        <form name="chngpwd" method="post" onsubmit="return valid();">
          <input type="email" name="email" class="form-control" placeholder="Your Email address*" required=""><br>
          <input type="password" name="newpassword" class="form-control" placeholder="New Password*" required=""><br>
          <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password*" required=""><br>
          <!-- Display password criteria error message -->
          <span class="error"><?php echo $password_criteria_err; ?></span><br>
          <input type="submit" value="Reset My Password" name="update" class="btn">
        </form>
        <div class="text-center">
          <p class="gray-text">For security reasons we don't store your password. Your password will be reset and a new one will be sent.</p>
          <p><a href="#loginform" data-toggle="modal" onclick="closeModal()"><i class="fa fa-angle-double-left" aria-hidden="true"></i> Back to Login</a></p>
        </div>
      </div>
    </div>
  </div>

  <script>
    function valid() {
      if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password Field do not match  !!");
        document.chngpwd.confirmpassword.focus();
        return false;
      }
      return true;
    }

    function closeModal() {
      var modal = document.querySelector('.modal');
      modal.style.display = 'none';
    }
  </script>
</body>
</html>
