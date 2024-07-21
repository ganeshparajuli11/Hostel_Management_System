<?php
// Include database connection and setup
include_once "../configuration.php";

// Check if billing_id and received_amount are provided in the URL
if(isset($_GET['billing_id']) && isset($_GET['received_amount'])) {
    // Sanitize the input to prevent SQL injection
    $billing_id = mysqli_real_escape_string($link, $_GET['billing_id']);
    $received_amount = mysqli_real_escape_string($link, $_GET['received_amount']);

    // Query to fetch billing details to get current received and pending amounts
    $query_fetch = "SELECT total_fee, received_amount FROM billing WHERE billing_id = '$billing_id'";
    $result_fetch = mysqli_query($link, $query_fetch);

    if ($row_fetch = mysqli_fetch_assoc($result_fetch)) {
        $total_fee = $row_fetch['total_fee'];
        $current_received_amount = $row_fetch['received_amount'];

        // Calculate new received and pending amounts
        $new_received_amount = $current_received_amount + $received_amount;
        $new_pending_amount = $total_fee - $new_received_amount;

        // Query to update the received and pending amounts
        $query_update = "UPDATE billing SET received_amount = '$new_received_amount', pending_amount = '$new_pending_amount' WHERE billing_id = '$billing_id'";
        
        // Execute the query
        if(mysqli_query($link, $query_update)) {
            // Redirect to the billing details page after updating
            header("Location: billing_details.php");
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($link);
        }
    } else {
        echo "Billing details not found!";
    }
} else {
    echo "Billing ID or Received Amount not provided!";
}
?>
