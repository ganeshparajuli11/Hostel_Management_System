<?php
// Include database connection and setup
include_once "../configuration.php";

// Check if the search parameter is provided
if(isset($_GET['search'])) {
    $search = $_GET['search'];

    // Prepare and execute the query to fetch resident details
    $sql = "SELECT u.name AS residentName, h.room_name AS roomName, b.total_fee, b.pending_amount, b.received_amount
            FROM user u
            INNER JOIN hostel h ON u.assigned_room_id = h.room_id
            INNER JOIN billing b ON u.user_id = b.user_id
            WHERE u.name = ?";
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $search);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch resident details
    $row = $result->fetch_assoc();

    // Check if resident details were found
    if ($row) {
        // Return resident details as JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'residentName' => $row['residentName'],
            'roomName' => $row['roomName'],
            'totalFee' => $row['total_fee'],
            'pendingAmount' => $row['pending_amount'],
            'receivedAmount' => $row['received_amount']
        ]);
    } else {
        // Return failure if resident details were not found
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
    }
} else {
    // Return failure if search parameter is not provided
    header('Content-Type: application/json');
    echo json_encode(['success' => false]);
}
?>
