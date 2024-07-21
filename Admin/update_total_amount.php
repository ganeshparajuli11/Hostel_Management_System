<?php
// Include database connection and setup
include_once "../configuration.php";

if (isset($_GET['billing_id']) && isset($_GET['total_amount'])) {
    $billing_id = $_GET['billing_id'];
    $total_amount = $_GET['total_amount'];

    // Validate the total amount
    if (is_numeric($total_amount) && $total_amount >= 0) {
        // Update query
        $query = "UPDATE billing SET total_fee = '$total_amount' WHERE billing_id = '$billing_id'";

        if (mysqli_query($link, $query)) {
            header("Location: billing_details.php");
        } else {
            echo "Error updating total amount: " . mysqli_error($link);
        }
    } else {
        echo "Invalid total amount.";
    }
} else {
    echo "Required parameters not provided.";
}

// Close the database connection
mysqli_close($link);
?>
