<?php
// Include the database connection file
include '../configuration.php';

// Query to retrieve room names from the hostel table
$sql = "SELECT room_name FROM hostel";

// Perform the query
$result = mysqli_query($link, $sql);

// Check if the query was successful
if ($result) {
    // Check if there are rows returned
    if (mysqli_num_rows($result) > 0) {
        // Output options for select dropdown
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['room_name'] . '">' . $row['room_name'] . '</option>';
        }
    } else {
        // No rooms found
        echo '<option value="">No rooms found</option>';
    }
} else {
    // Error in executing query
    echo '<option value="">Error retrieving rooms</option>';
}

// Close the database connection
mysqli_close($link);
?>
