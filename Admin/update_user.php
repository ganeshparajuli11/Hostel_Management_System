<?php
include_once "../configuration.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // Query to fetch user details
    $query = "SELECT * FROM user WHERE user_id = $user_id";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Fetch room details from the hostel table
$room_query = "SELECT * FROM hostel";
$room_result = mysqli_query($link, $room_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>

    <style>
        /* General reset and styling */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f4f8;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.update-user-overlay {
    margin-top: 450px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    width: 100%;
}

.update-user-overlay h2 {
    margin-top: 0;
    color: #333333;
    font-size: 24px;
    text-align: center;
}

.update-user-overlay form {
    display: flex;
    flex-direction: column;
}

.update-user-overlay label {
    margin-top: 10px;
    font-weight: bold;
    color: #555555;
}

.update-user-overlay input[type="text"],
.update-user-overlay input[type="number"],
.update-user-overlay select {
    padding: 10px;
    margin-top: 5px;
    border: 1px solid #cccccc;
    border-radius: 4px;
    font-size: 16px;
    width: calc(100% - 22px); /* Adjusting for padding and border */
    box-sizing: border-box;
}

.update-user-overlay input[type="submit"] {
    margin-top: 20px;
    padding: 10px;
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
}

.update-user-overlay input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Responsive design */
@media (max-width: 600px) {
    .update-user-overlay {
        padding: 15px;
    }

    .update-user-overlay h2 {
        font-size: 20px;
    }

    .update-user-overlay input[type="text"],
    .update-user-overlay input[type="number"],
    .update-user-overlay select {
        font-size: 14px;
    }

    .update-user-overlay input[type="submit"] {
        font-size: 14px;
    }
}

    </style>
</head>
<body>
    <div class="update-user-overlay">
    <h2>Update User</h2>
    <form action="update_process.php" method="POST">
        <!-- Display user details -->
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $user['name']; ?>"><br>
        
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo $user['email']; ?>"><br>
        
        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo $user['age']; ?>"><br>
        
        <label for="contact_number">Contact Number:</label>
        <input type="text" name="contact_number" value="<?php echo $user['contact_number']; ?>"><br>
        
        <label for="citizenship_front">Citizenship Front:</label>
        <input type="text" name="citizenship_front" value="<?php echo $user['citizenship_front']; ?>"><br>
        
        <label for="citizenship_back">Citizenship Back:</label>
        <input type="text" name="citizenship_back" value="<?php echo $user['citizenship_back']; ?>"><br>
        
        <label for="guardian_name">Guardian Name:</label>
        <input type="text" name="guardian_name" value="<?php echo $user['guardian_name']; ?>"><br>
        
        <label for="guardian_contact_number">Guardian Contact Number:</label>
        <input type="text" name="guardian_contact_number" value="<?php echo $user['guardian_contact_number']; ?>"><br>
        
        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo $user['address']; ?>"><br>

        <!-- Room selection dropdown -->
        <label for="assigned_room_name">Assigned Room:</label>
        <select name="assigned_room_name">
            <?php while ($room = mysqli_fetch_assoc($room_result)) { ?>
                <option value="<?php echo $room['room_name']; ?>" <?php if ($room['room_name'] == $user['assigned_room_name']) echo "selected"; ?>>
                    <?php echo $room['room_name']; ?>
                </option>
            <?php } ?>
        </select><br>

        <!-- User status dropdown -->
        <label for="user_status">User Status:</label>
        <select name="user_status">
            <option value="1" <?php if ($user['user_status'] == 1) echo "selected"; ?>>Approved</option>
            <option value="0" <?php if ($user['user_status'] == 0) echo "selected"; ?>>Not Approved</option>
        </select><br>

        <!-- Add submit button -->
        <input type="submit" value="Update">
    </form>
    </div>
</body>
</html>
