<?php
include 'configuration.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
session_start();
if (!isset($_SESSION['email'])) {
    header("location: ResidentLogin.php");
    exit();
}

// Fetch assigned room ID from database
$email = $_SESSION['email'];
$sqlAssignedRoom = "SELECT assigned_room_name FROM user WHERE email = ?";
$stmtAssignedRoom = mysqli_prepare($link, $sqlAssignedRoom);
mysqli_stmt_bind_param($stmtAssignedRoom, "s", $email);
mysqli_stmt_execute($stmtAssignedRoom);
mysqli_stmt_bind_result($stmtAssignedRoom, $assignedRoomId);
mysqli_stmt_fetch($stmtAssignedRoom);
mysqli_stmt_close($stmtAssignedRoom);

// Fetch pending amount from database
$sql_pending = "SELECT pending_amount FROM billing WHERE user_id = (SELECT user_id FROM user WHERE email = ?)";
$stmt_pending = mysqli_prepare($link, $sql_pending);
mysqli_stmt_bind_param($stmt_pending, "s", $email);
mysqli_stmt_execute($stmt_pending);
mysqli_stmt_bind_result($stmt_pending, $pendingAmount);
mysqli_stmt_fetch($stmt_pending);
mysqli_stmt_close($stmt_pending);

// Fetch current user ID from database
$user_id = getUserIdByEmail($email, $link);

// Process sending message
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["send_message"])) {
    $message = $_POST["message"];

    // Insert message into database with assigned_room_id
    $sender_id = $user_id;
    $receiver_id = getHostelAdminId($link);
    $assigned_room_id = $assignedRoomId; // Use the assigned_room_id
    $sql_insert_message = "INSERT INTO message (sender_id, receiver_id, room_id, message_text) VALUES (?, ?, ?, ?)";
    $stmt_insert_message = mysqli_prepare($link, $sql_insert_message);
    mysqli_stmt_bind_param($stmt_insert_message, "iiis", $sender_id, $receiver_id, $assigned_room_id, $message);
    mysqli_stmt_execute($stmt_insert_message);
    mysqli_stmt_close($stmt_insert_message);
}

// Helper functions
function getUserIdByEmail($email, $link) {
    $sql = "SELECT user_id FROM user WHERE email = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $user_id;
}

function getHostelAdminId($link) {
    // You need to replace 'hostel_admin_email' with the email of your hostel admin
    $admin_email = 'hostel_admin_email';
    $sql = "SELECT user_id FROM user WHERE email = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $admin_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $user_id;
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System - Resident Page</title>
    <link rel="stylesheet" href="ResidentDash.css">
</head>
<body>

<nav>
    <ul>
        <li>
            <a href="#">
                <img src="Hostel.avif" alt="Hostel Logo" class="logo">
                Dashboard
            </a>
        </li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="PaymentResident.html">My Payments</a></li>
        <li><a href="MainteneceRequest.html">Maintenance Requests</a></li>
        <li><a href="user_chat.php?user_id=<?php echo $user_id; ?>">Chats</a></li>
        <li><a href="logout.php?logout=true">Logout</a></li>
    </ul>
</nav>

<div class="content">
    <p>Welcome Resident!</p>

    <div class="info-box-container">
        <!-- Info boxes -->
        <div class="info-box">
            <h2>Booking Status</h2>
            <?php if ($assignedRoomId !== null) { ?>
                <p>Your assigned room is: <?php echo $assignedRoomId; ?></p>
            <?php } else { ?>
                <p>No room assigned.</p>
            <?php } ?>
            <img src="Icon.png" alt="Booking Status">
        </div>

        <div class="info-box">
            <h2>Payment Due</h2>
            <p>Pending Amount: <?php echo $pendingAmount ?? "N/A"; ?></p>
            <img src="Payment.png" alt="Payment Due">
        </div>

        <div class="info-box">
            <h2>Notification</h2>
            <p>No new notifications.</p>
            <img src="Notification.jpg" alt="Notifications">
        </div>
    </div>

    <div class="task-box-container">
        <!-- Task boxes -->
        <div class="task-box">
            <h2>Tasks</h2>
            <p>You have no tasks assigned.</p>
            <img src="Task.png" alt="Tasks">
        </div>
    </div>

    <div class="separator-bar"></div> <!-- Separating bar -->

   
</div>

<div class="resident-profile">
    <img src="Residents.jpg" alt="Resident Profile">
    <p>RESIDENT</p>
</div>

</body>
</html>
