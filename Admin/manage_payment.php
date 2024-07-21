<?php
// Include database connection and setup
include_once "../configuration.php";

// Define variables for pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Perform search if search query is present
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchQuery = $search ? "AND u.name LIKE '%$search%'" : ''; // Assuming 'name' is the column in the 'user' table

// Fetch payment details from the database
if ($link) {
    // Join payment table with billing table and then with user table
    $sql = "SELECT p.*, u.name AS resident_name, (b.total_fee - p.payment_amount) AS pending_amount 
            FROM payment p
            INNER JOIN billing b ON p.billing_id = b.billing_id
            INNER JOIN user u ON b.user_id = u.user_id
            WHERE 1 $searchQuery
            LIMIT $limit OFFSET $offset";
    $result = mysqli_query($link, $sql);

    // Fetch total number of payment records for pagination
    $totalSql = "SELECT COUNT(*) AS total 
                 FROM payment p
                 INNER JOIN billing b ON p.billing_id = b.billing_id
                 INNER JOIN user u ON b.user_id = u.user_id
                 WHERE 1 $searchQuery";
    $totalResult = mysqli_query($link, $totalSql);
    $totalRows = mysqli_fetch_assoc($totalResult)['total'];
    $totalPages = ceil($totalRows / $limit);

    // Calculate total received amount
    $totalReceivedAmount = 0;
    $receivedAmountSql = "SELECT SUM(received_amount) AS total_received 
                          FROM billing";
    $receivedAmountResult = mysqli_query($link, $receivedAmountSql);
    $totalReceivedAmount = mysqli_fetch_assoc($receivedAmountResult)['total_received'];
} else {
    echo "Error: Unable to establish database connection.";
}
// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manage_payment.css">
    <style>
        
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
  }
  
  nav {
    background-color: #333;
    color: #fff;
    width: 200px;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
    align-items: flex-start; 
    padding-left: 20px; 
    align-items: center;
  }
  
  nav .logo {
    margin-left: 5px;
    width: 100px; 
    margin-bottom: 20px; 
    transition: transform 0.3s; 
  }
  
  nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 100%; /* Ensure the ul takes the full width */
  }
  
  nav ul li {
    margin-bottom: 10px;
  }
  
  nav ul li a {
    display: block;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 10px 0; /* Adjust padding */
    transition: background-color 0.3s;
    text-align: left; /* Ensure the text is aligned to the left */
    padding-left: 10px; /* Add padding-left for indentation */
  }
  
  nav ul li a:hover {
    background-color: #555;
  }
    </style>
    <script>
        function updatePaymentStatus(newStatus, paymentId) {
            // Update the status in the table
            document.getElementById(`status_${paymentId}`).innerText = newStatus;
            // Update the hidden input field
            document.getElementById(`new_status_${paymentId}`).value = newStatus;
            // Submit the form to update status in the database
            document.getElementById("update_status_form").submit();
        }
    </script>

    <title>Payment and Billing</title>
</head>
<body>
    <nav>
        <ul>
            <li> 
                <img src="image/Hostel.avif" alt="Hostel Logo" class="logo">
                <a href="home.php">Dashboard</a>
            </li>
            <li><a href="manage_room.php">Rooms</a></li>
            <li><a href="managestaff.php">Staff</a></li>
            <li><a href="manage_resident.php">Residents</a></li>
            <li><a href="billing_details.php">Billing Details</a></li>
            <li><a href="manage_payment.php">Payment Info</a></li>
            <li><a href="admin_view_users.php">Chat</a></li>
            <li><a href="#" id = "logout">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Manage Payment</h1>
        <div class="search-container">
            <form method="get" action="">
                <input type="text" name="search" id="searchInput" placeholder="Search by resident name..." value="<?php echo $search; ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <table id="paymentTable">
            <thead>
                <tr>
                    <th>Resident Name</th>
                    <th>Recieved Amount</th>
                    <th>Payment Date</th>
                    <th>Pending Amount</th>
                </tr>
            </thead>
            <tbody>
                 <?php
                if ($link && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['resident_name'] . "</td>";
                        echo "<td>$" . $row['payment_amount'] . "</td>";
                        echo "<td>" . $row['payment_date'] . "</td>";
                        echo "<td>$" . $row['pending_amount'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No payment records found</td></tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Received Amount:</th>
                    <td>$<?php echo $totalReceivedAmount; ?></td>
                </tr>
            </tfoot>
        </table>
        <div class="pagination">
            <a href="?page=<?php echo ($page > 1) ? ($page - 1) : 1; ?>&search=<?php echo $search; ?>" id="prevBtn">Prev</a>
            <a href="?page=<?php echo ($page < $totalPages) ? ($page + 1) : $totalPages; ?>&search=<?php echo $search; ?>" id="nextBtn">Next</a>
        </div>
    </div>
    <form id="update_status_form" method="post" action="update_payment_status.php" style="display: none;">
        <input type="hidden" name="payment_id[]" />
        <input type="hidden" name="new_status[]" />
    </form>

    <script>
    // Add event listener to the logout link
    document.getElementById('logout').addEventListener('click', function() {
        // Show a confirmation dialog
        if (confirm('Are you sure you want to logout?')) {
            // If user clicks OK, redirect to adminLogin.php
            window.location.href = 'adminLogin.php';
        } else {
            // If user clicks Cancel, do nothing
            return false;
        }
    });
</script>


    
</body>
</html>
