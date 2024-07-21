<?php
// Include database connection and setup
include_once "../configuration.php";

// Check if the search query is provided
if(isset($_GET['search'])) {
    // Sanitize the input to prevent SQL injection
    $search = mysqli_real_escape_string($link, $_GET['search']);

    // Query to search for users by name
    $query = "SELECT b.billing_id, u.name, b.total_fee, b.received_amount, b.pending_amount, b.bill_date
              FROM billing b
              INNER JOIN user u ON b.user_id = u.user_id
              WHERE u.name LIKE '%$search%'";

    $result = mysqli_query($link, $query);

    // Check if any results were found
    if(mysqli_num_rows($result) > 0) {
        // Display search results
        echo "<thead><tr><th>Billing ID</th><th>User Name</th><th>Total Fee</th><th>Received Amount</th><th>Pending Amount</th><th>Bill Date</th><th>Generate Bill</th><th>Update</th></tr></thead>";

        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['billing_id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['total_fee'] . "</td>";
            echo "<td>" . $row['received_amount'] . "</td>";
            echo "<td>" . $row['pending_amount'] . "</td>";
            echo "<td>" . $row['bill_date'] . "</td>";
            // / Button to generate bill
            echo "<td><button onclick=\"generateBill('" . $row['billing_id'] . "')\">Generate</button></td>";
            // Button to update received amount
            echo "<td><button onclick=\"updatePendingAmount('" . $row['billing_id'] . "')\">Update</button></td>";
            echo "</tr>";
        }
        echo "</tbody>";
    } else {
        echo "<tr><td colspan='6'>No results found.</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>Search query not provided.</td></tr>";
}
?>
