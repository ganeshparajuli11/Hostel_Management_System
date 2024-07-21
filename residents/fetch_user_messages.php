<?php
// fetch_user_messages.php

include('../Admin/db_connection.php'); // include your database connection

$user_id = $_GET['user_id'];
$admin_id = 1; // Assuming admin ID is 1, adjust accordingly

$query = "SELECT * FROM messages WHERE (sender_id = $user_id AND receiver_id = $admin_id) OR (sender_id = $admin_id AND receiver_id = $user_id) ORDER BY timestamp ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['is_admin_sender']) {
        echo "<p><strong>Admin:</strong> " . htmlspecialchars($row['message']) . "</p>";
    } else {
        echo "<p><strong>You:</strong> " . htmlspecialchars($row['message']) . "</p>";
    }
}
?>
