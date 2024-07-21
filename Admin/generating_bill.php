<?php
include_once "../configuration.php";

// Function to fetch user details
function getUserDetails($userId)
{
    global $link;
    $sql = "SELECT * FROM user WHERE user_id = '$userId'";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_assoc($result);
}

// Function to fetch room details
function getRoomDetails($roomId)
{
    global $link;
    $sql = "SELECT * FROM hostel WHERE room_id = '$roomId'";
    $result = mysqli_query($link, $sql);
    return mysqli_fetch_assoc($result);
}

// Search functionality
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $sql = "SELECT * FROM user WHERE name LIKE '%$searchQuery%'";
    $result = mysqli_query($link, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Bill</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Generate Bill</h1>

    <!-- Search bar -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search resident name" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Display search results -->
    <?php if (isset($users)) : ?>
        <ul>
            <?php foreach ($users as $user) : ?>
                <li>
                    <?php echo $user['name']; ?>
                    <button onclick="generateBill(<?php echo $user['user_id']; ?>, <?php echo $user['assigned_room_id']; ?>)">Generate Bill</button>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Bill generation form -->
    <div id="billForm" style="display: none;">
        <h2>Generate Bill</h2>
        <form id="billFormData" method="post" action="generate_bill.php">
            <input type="hidden" id="userId" name="userId">
            <input type="hidden" id="roomId" name="roomId">
            <label for="roomFee">Room Fee:</label>
            <input type="text" id="roomFee" name="roomFee" readonly>
            <br>
            <label for="additionalExpense1">Additional Expense 1:</label>
            <input type="text" id="additionalExpense1" name="additionalExpense1">
            <br>
            <label for="additionalExpense2">Additional Expense 2:</label>
            <input type="text" id="additionalExpense2" name="additionalExpense2">
            <br>
            <button type="submit">Generate Bill</button>
        </form>
    </div>

    <script>
        function generateBill(userId, roomId) {
            // Fetch user details
            var userDetails = <?php echo json_encode(getUserDetails($userId)); ?>;
            var roomDetails = <?php echo json_encode(getRoomDetails($roomId)); ?>;

            // Populate form fields
            document.getElementById('userId').value = userId;
            document.getElementById('roomId').value = roomId;
            document.getElementById('roomFee').value = roomDetails.room_price;

            // Show the bill form
            document.getElementById('billForm').style.display = 'block';
        }
    </script>
</body>
</html>



