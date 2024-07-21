<?php
// Include the database connection file
include '../configuration.php';

// Check if userId is provided
if (isset($_GET['userId'])) {
    // Sanitize the userId
    $userId = mysqli_real_escape_string($link, $_GET['userId']);

    // Query to delete resident
    $sql = "DELETE FROM user WHERE user_id = $userId";

    // Execute the query
    if (mysqli_query($link, $sql)) {
        // Redirect back to the manage_resident.php page after deleting
        header("Location: manage_resident.php");
        exit();
    } else {
        echo "Error deleting resident member: " . mysqli_error($link);
    }
} else {
    echo "Resident ID not provided.";
}

// Close the database connection
mysqli_close($link);
?>
