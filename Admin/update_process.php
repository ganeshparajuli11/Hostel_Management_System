<?php
// Include database connection and setup
include_once "../configuration.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user_id from the form
    $user_id = $_POST['user_id'];

    // Prepare SQL statement to update user data
    $query = "UPDATE user SET ";
    foreach ($_POST as $key => $value) {
        // Exclude user_id from update query
        if ($key !== 'user_id') {
            // Escape special characters to prevent SQL injection
            $value = mysqli_real_escape_string($link, $value);
            // Append column name and value to the query
            $query .= "$key = '$value', ";
        }
    }
    // Remove the trailing comma and space
    $query = rtrim($query, ", ");
    // Append WHERE clause to specify the user to update
    $query .= " WHERE user_id = $user_id";

    // Execute the update query
    if (mysqli_query($link, $query)) {
        // Update successful, redirect to manage_resident.php or any other page
        header("Location: manage_resident.php");
        exit();
    } else {
        // Update failed, display error message
        echo "Error updating user: " . mysqli_error($link);
    }
} else {
    // If the form is not submitted via POST method, redirect to manage_resident.php
    header("Location: manage_resident.php");
    exit();
}
?>
