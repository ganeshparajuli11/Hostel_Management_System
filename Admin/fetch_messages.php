<?php
// fetch_messages.php

include('db_connection.php'); // include your database connection

$user_id = $_GET['user_id'];
$admin_id = 1; // Assuming admin ID is 1, adjust accordingly

$query = "SELECT * FROM messages WHERE (sender_id = $admin_id AND receiver_id = $user_id) OR (sender_id = $user_id AND receiver_id = $admin_id) ORDER BY timestamp ASC";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    if ($row['is_admin_sender']) {
        echo "<p><strong>Admin:</strong> " . htmlspecialchars($row['message']) . "</p>";
    } else {
        echo "<p><strong>User:</strong> " . htmlspecialchars($row['message']) . "</p>";
    }
}
?>
