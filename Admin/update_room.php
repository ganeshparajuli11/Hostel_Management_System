<?php
include_once "../configuration.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $roomId = $_POST['roomId'];
    $roomName = $_POST['roomName'];
    $facility = $_POST['facility'];
    $residentCount = $_POST['residentCount'];

    // Sanitize form data to prevent SQL injection
    $roomId = mysqli_real_escape_string($link, $roomId);
    $roomName = mysqli_real_escape_string($link, $roomName);
    $facility = mysqli_real_escape_string($link, $facility);
    $residentCount = mysqli_real_escape_string($link, $residentCount);

    // Update room details in the database
    $updateSql = "UPDATE hostel SET room_name='$roomName', facility='$facility', residents_count='$residentCount' WHERE room_id='$roomId'";

    if (mysqli_query($link, $updateSql)) {
        // Update successful
        echo "Room details updated successfully.";
        echo "<script>window.location.href = 'manage_room.php';</script>";
    } else {
        // Update failed
        echo "Error updating room details: " . mysqli_error($link);
    }

    // Close the database connection
    mysqli_close($link);
}
?>
