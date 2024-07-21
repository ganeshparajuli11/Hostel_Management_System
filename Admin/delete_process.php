<?php
// Include database connection and setup
include_once "../configuration.php";

// Check if user_id is set in the URL
if (isset($_GET['user_id'])) {
    // Retrieve user_id from the URL
    $user_id = $_GET['user_id'];

    // Delete user from the database
    $query = "DELETE FROM user WHERE user_id = $user_id";
    $result = mysqli_query($link, $query);

    if ($result) {
        // Redirect to manage_resident.php after successful deletion
        header("Location: manage_resident.php");
        exit(); // Ensure no further code is executed after redirection
    } else {
        echo "Error deleting user: " . mysqli_error($link);
    }
} else {
    echo "User ID not provided.";
}
?>
