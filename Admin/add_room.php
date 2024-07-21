<?php
include_once "../configuration.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $roomName = $_POST['roomName'];
    $facility = $_POST['facility'];
    $residentCount = $_POST['residentCount'];

    // Insert room details into the database
    $insertSql = "INSERT INTO hostel (room_name,facility, residents_count) 
                  VALUES ('$roomName', '$facility', '$residentCount')";

    if (mysqli_query($link, $insertSql)) {
        // Insert successful
        echo "Room added successfully.";
    } else {
        // Insert failed
        echo "Error: " . $insertSql . "<br>" . mysqli_error($link);
    }

    // Close the database connection
    mysqli_close($link);
}
?>
