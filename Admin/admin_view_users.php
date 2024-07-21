<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System - Chat-Page</title>
    <link rel="stylesheet" href="chat.css">
    <style>

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }
  
  nav {
    background-color: #333;
    color: #fff;
    width: 200px;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
    align-items: flex-start; 
    padding-left: 20px; 
    align-items: center;
  }
  
  nav .logo {
    margin-left: 5px;
    width: 100px; 
    margin-bottom: 20px; 
    transition: transform 0.3s; 
  }
  
  nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 100%; /* Ensure the ul takes the full width */
  }
  
  nav ul li {
    margin-bottom: 10px;
  }
  
  nav ul li a {
    display: block;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 0; /* Adjust padding */
    transition: background-color 0.3s;
    text-align: left; /* Ensure the text is aligned to the left */
    padding-left: 10px; /* Add padding-left for indentation */
  }
  
  nav ul li a:hover {
    background-color: #555;
  }
        .users-list {
            margin-left: 250px;
            margin-top: 20px;
        }
        .users-list h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .users-list p {
            margin: 10px 0;
        }
        .users-list p a {
            text-decoration: none;
            color: #0066cc;
            font-weight: bold;
            transition: color 0.3s;
        }
        .users-list p a:hover {
            color: #004080;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li>
            <img src="image/Hostel.avif" alt="Hostel Logo" class="logo">
            <a href="home.php">Dashboard</a>
            </li>
            <li><a href="manage_room.php">Rooms</a></li>
            <li><a href="managestaff.php">Staff</a></li>
            <li><a href="manage_resident.php">Residents</a></li>
            <li><a href="billing_details.php">Billing Details</a></li>
            <li><a href="manage_payment.php">Payment Info</a></li>
            <li><a href="admin_view_users.php">Chat</a></li>
            <li><a href="#" id="logout">Logout</a></li>
        </ul>
    </nav>
    <div class="users-list">
    <?php
// admin_view_users.php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('db_connection.php'); // include your database connection

$query = "SELECT user_id, name, email FROM user";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
}

echo "<h1 style='margin-left: 250px;'>Users List</h1>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p style='margin-left: 250px;'><a href='admin_chat.php?user_id=" . $row['user_id'] . "'>" . $row['name'] . "</a></p>";
}
?>
    </div>
    <script>
        document.getElementById('logout').addEventListener('click', function() {
        // Show a confirmation dialog
        if (confirm('Are you sure you want to logout?\nThis will redirect you to the login page.')) {
            // If user clicks OK, redirect to adminLogin.php
            window.location.href = 'adminLogin.php';
        } else {
            // If user clicks Cancel, do nothing
            return false;
        }
    });
    </script>
</body>
</html>
