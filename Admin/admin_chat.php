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

  #chat {
            margin-left: 250px;
            width: 60%;
            max-width: 800px;
            height: 400px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow-y: auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .text-box {
            margin-left: 250px;
            width: 60%;
            max-width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        .text-box textarea {
            width: 100%;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            resize: none;
        }
        .text-box input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .text-box input[type="submit"]:hover {
            background-color: #0056b3;
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
            <li><a href="#" id = "logout">Logout</a></li>
        </ul>
    </nav>



<?php
// admin_chat.php

include('db_connection.php'); // include your database connection

$user_id = $_GET['user_id'];
$admin_id = 1; // Assuming admin ID is 1, adjust accordingly

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];
    $query = "INSERT INTO messages (sender_id, receiver_id, message, is_admin_sender) VALUES ($admin_id, $user_id, '$message', 1)";
    mysqli_query($conn, $query);
}

?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchMessages() {
            $.ajax({
                url: 'fetch_messages.php',
                type: 'GET',
                data: { user_id: <?php echo $user_id; ?> },
                success: function(data) {
                    $('#chat').html(data);
                }
            });
        }

        $(document).ready(function() {
            fetchMessages(); // Initial fetch
            setInterval(fetchMessages, 2000); // Fetch new messages every 2 seconds
        });

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

    <h1 style="margin-left: 220px">Chat with User</h1>
    <div id="chat" style="margin-left: 250px">

        <!-- Messages will be loaded here via AJAX -->
    </div>

    <form method="POST" class = "text-box" >
        <textarea name="message"></textarea><br>
        <input type="submit" value="Send">
    </form>
</body>
</html>
