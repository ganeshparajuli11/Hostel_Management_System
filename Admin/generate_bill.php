<style>
    /* Style for the bill */
    .bill {
        width: 80%;
        margin: 20px auto;
        padding: 20px;
        border: 2px solid #333;
        font-family: Arial, sans-serif;
    }

    .bill h1 {
        text-align: center;
    }

    .bill p {
        margin: 10px 0;
    }
    .download-btn {
    display: block;
    width: 120px;
    margin: 20px auto;
    padding: 10px;
    text-align: center;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
</style>

<?php
// Include database connection and setup
include_once "../configuration.php";

// Check if billing_id is provided in the URL
if(isset($_GET['billing_id'])) {
    // Sanitize the input to prevent SQL injection
    $billing_id = mysqli_real_escape_string($link, $_GET['billing_id']);

    // Query to fetch billing details based on billing_id
    $query = "SELECT b.*, u.name AS user_name, u.assigned_room_name AS room_name
              FROM billing b
              INNER JOIN user u ON b.user_id = u.user_id
              WHERE b.billing_id = '$billing_id'";
    $result = mysqli_query($link, $query);

    if(mysqli_num_rows($result) == 1) {
        // Fetch the billing details
        $row = mysqli_fetch_assoc($result);

        // Generate the bill HTML
        $billHTML = "<div class='bill'>";
        $billHTML .= "<h1>Bill for Billing ID: " . $row['billing_id'] . "</h1>";
        $billHTML .= "<p>User: " . $row['user_name'] . "</p>";
        $billHTML .= "<p>Room Name: " . $row['room_name'] . "</p>";
        $billHTML .= "<p>Total Fee: $" . $row['total_fee'] . "</p>";
        $billHTML .= "<p>Received Amount: $" . $row['received_amount'] . "</p>";
        $billHTML .= "<p>Pending Amount: $" . $row['pending_amount'] . "</p>";
        $billHTML .= "<p>Bill Date: " . $row['bill_date'] . "</p>";
        $billHTML .= "</div>";

        // Output the bill HTML
        echo $billHTML;
    } else {
        echo "Billing ID not found!";
    }
} else {
    echo "Billing ID not provided!";
}
?>
<button onclick="printBill()" class ="download-btn">Generate Bill</button>
<script>
    // Function to print the bill content
    function printBill() {
        // Get the bill content
        var billContent = document.querySelector('.bill').outerHTML;
        
        // Create a new window for printing
        var printWindow = window.open('', '_blank', 'width=600,height=600');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print Bill</title></head><body>');
        printWindow.document.write(billContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Trigger print function
        printWindow.print();
    }
</script>


