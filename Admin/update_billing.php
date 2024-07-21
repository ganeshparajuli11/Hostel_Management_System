<?php
// Include database connection and setup
include_once "../configuration.php";

// Retrieve resident name from local storage
$residentName = isset($_POST['resident_name']) ? $_POST['resident_name'] : '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the received amount from the form
    $receivedAmount = $_POST['received_amount'];

    // Find the user_id associated with the resident's name
    $userIdSql = "SELECT user_id FROM user WHERE name =?";
    $userIdStmt = $link->prepare($userIdSql);
    $userIdStmt->bind_param('s', $residentName);
    $userIdStmt->execute();
    $userIdResult = $userIdStmt->get_result();
    $userIdRow = $userIdResult->fetch_assoc();
    $userId = $userIdRow['user_id']; // Assuming user_id is the only column returned

    // Update the received amount in the billing table
    $updateSql = "UPDATE billing SET received_amount =? WHERE user_id =?";
    $stmt = $link->prepare($updateSql);
    $stmt->bind_param('ds', $receivedAmount, $userId);
    $stmt->execute();

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}
?>
