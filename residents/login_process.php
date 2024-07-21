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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email_err = $password_err = "";

    // Check if email and password are provided
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If email and password are provided, verify against database
    if (empty($email_err) && empty($password_err)) {
        // Prepare and execute SQL statement to fetch user data
        $sql = "SELECT email FROM `user` WHERE email = ? AND password = ?";
        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
        $param_email = $email;
        $param_password = $password;

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);

            // If a record is found, redirect to ResidentDash.php
            if (mysqli_stmt_num_rows($stmt) == 1) {
                session_start();
                $_SESSION["email"] = $email;
                header("location: ResidentDash.php");
                exit();
            } else {
                // If no record is found, display an error message
                $email_err = "Invalid email or password.";
            }
        } else {
            echo "Error: Unable to execute SQL statement.";
        }
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}

// Display error messages as toast notifications using JavaScript
echo "<script>";
if (!empty($email_err) || !empty($password_err)) {
    echo "alert('Error: ";
    if (!empty($email_err)) {
        echo "$email_err ";
    }
    if (!empty($password_err)) {
        echo "$password_err";
    }
    echo "');";
}
echo "window.location.href = 'ResidentLogin.php';";
echo "</script>";
?>
