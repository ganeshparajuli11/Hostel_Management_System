<?php
include_once "../configuration.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['roomId'])) {
    // Get room ID from the GET parameters
    $roomId = $_GET['roomId'];

    // Delete room from the database
    $deleteSql = "DELETE FROM hostel WHERE room_id='$roomId'";

    if (mysqli_query($link, $deleteSql)) {
        // Deletion successful
        echo "Room deleted successfully.";
    } else {
        // Deletion failed
        echo "Error: " . $deleteSql . "<br>" . mysqli_error($link);
    }

    // Close the database connection
    mysqli_close($link);
}
?>
