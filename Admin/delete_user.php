<?php
// Include database connection and setup
include_once "../configuration.php";

// Check if user_id is set in the URL
if (isset($_GET['user_id'])) {
    // Retrieve user_id from the URL
    $user_id = $_GET['user_id'];

    // Check if the user_id is numeric
    if (is_numeric($user_id)) {
        // Confirmation message
        echo "<script>";
        echo "var confirmDelete = confirm('Are you sure you want to delete this user?');";
        echo "if (confirmDelete) {";
        echo "  window.location.href = 'delete_process.php?user_id=$user_id';";
        echo "} else {";
        echo "  window.location.href = 'manage_resident.php';";
        echo "}";
        echo "</script>";
    } else {
        echo "Invalid user ID.";
    }
} else {
    echo "User ID not provided.";
}
?>
