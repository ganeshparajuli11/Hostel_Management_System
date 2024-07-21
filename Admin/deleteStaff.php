<?php
// Include the database connection file
include '../configuration.php';

// Check if staffId is provided
if (isset($_GET['staffId'])) {
    // Sanitize the staffId
    $staffId = mysqli_real_escape_string($link, $_GET['staffId']);

    // Query to delete staff member
    $sql = "DELETE FROM staff WHERE staff_id = $staffId";

    // Execute the query
    if (mysqli_query($link, $sql)) {
        // Redirect back to the manageStaff.php page after deleting
        header("Location: manageStaff.php");
        exit();
    } else {
        echo "Error deleting staff member: " . mysqli_error($link);
    }
} else {
    echo "Staff ID not provided.";
}

// Close the database connection
mysqli_close($link);
?>
