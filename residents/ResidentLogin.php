<?php
// Database configuration
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "hostel_management_system");

# Connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

# Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

# Set character set
mysqli_set_charset($link, "utf8");

// Function to validate email format
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && preg_match('/@gmail\.com$/', $email);
}

// Function to validate password complexity
function validatePassword($password) {
    return preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $password);
}

try {
    // Create a PDO instance
    $dbh = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
} catch (PDOException $e) {
    // If connection fails, display an error message
    echo "Connection failed: " . $e->getMessage();
    die();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if name, email, and password are provided
    if (empty($_POST["name"])) {
        $name_err = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Check if email is empty or invalid
    if (empty($_POST["username"]) || !validateEmail($_POST["username"])) {
        $username_err = "Please enter a valid email address ending with '@gmail.com'.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty or doesn't meet complexity requirements
    if (empty($_POST["password"]) || !validatePassword($_POST["password"])) {
        $password_err = "Password must be at least 8 characters long and contain at least 1 letter and 1 number.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If all fields are valid, insert data into the database
    if (empty($name_err) && empty($username_err) && empty($password_err)) {
        // Prepare and execute SQL statement to insert data into the database
        $sql = "INSERT INTO `user`(`name`, `email`, `password`) VALUES (:name, :email, :password)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(":name", $name, PDO::PARAM_STR);
        $stmt->bindParam(":email", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        if ($stmt->execute()) {
            // Redirect to success page or perform other actions
            header("location: success.php");
            exit();
        } else {
            echo "Error: Unable to execute SQL statement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hostel Management System - Login</title>
    <link rel="stylesheet" href="ResidentLogin.css">
    <style>
        /* Styles for the toast message */
        .toast {
            visibility: hidden;
            min-width: 250px;
            margin-left: -125px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;
            padding: 16px;
            position: fixed;
            z-index: 1;
            left: 50%;
            bottom: 30px;
            font-size: 17px;
        }
        .toast.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }
        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }
        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }
        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="Hostel.jpg" alt="Hostel Image" class="background-image">
        <h1>Hostel Management System</h1>

        <h2>Login</h2>
        <div class="login-container">
        <form id="login-form" action="login_process.php" method="post">
            <label for="email">Email/Registration Number:</label>
            <input type="text" id="email" name="email" placeholder="Your email or registration number">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Your password">
            <span class="error"><?php echo isset($password_err) ? $password_err : ""; ?></span>

            <input type="submit" name="login" value="Login" id="submit-button-resident">
        </form>
        <div class="auth-links">
            <a href="ResidentSignup.php" class="button orange-button">New User</a>
            <a href="forgotpassword.php" class="button orange-button">Forgot password?</a>
        </div>
        </div>
    </div>

    <?php if(isset($_SESSION['logout_message'])) { ?>
        <!-- Toast message -->
        <div id="toast" class="toast">
            <?php echo $_SESSION['logout_message']; ?>
        </div>
        <?php unset($_SESSION['logout_message']); ?>
    <?php } ?>

    <script>
        // Show the toast message
        document.addEventListener('DOMContentLoaded', function() {
            var toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('show');
                setTimeout(function(){
                    toast.classList.remove('show');
                }, 3000); // 3 seconds
            }
        });
    </script>
</body>
</html>
