<?php
// Include database configuration
require_once "../configuration.php";

// Function to get count from database table
function getCount($table, $column) {
    global $link;
    // Query to get count from the specified table and column
    $query = "SELECT COUNT($column) AS count FROM $table";
    $result = mysqli_query($link, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $count = mysqli_fetch_assoc($result)['count'];
        return $count;
    } else {
        return 0; // No rows found
    }
}

// Get counts for residents, staff, and rooms
$residentsCount = getCount('user', 'user_id');
$staffCount = getCount('staff', 'staff_id');
$roomsCount = getCount('hostel', 'room_id');

// Prepare JSON response
$response = array(
    'residents' => $residentsCount,
    'staff' => $staffCount,
    'rooms' => $roomsCount
);

// Output JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
