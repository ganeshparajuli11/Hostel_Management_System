<?php
// Assuming you have already established a database connection

include 'configuration.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['email'])) {
    header("location: ResidentLogin.php");
    exit();
}

// Fetch user's data from the database based on their unique identifier (e.g., email)
$email = $_SESSION['email'];
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if user exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    // Assign fetched data to variables
    $name = $row['name'];
    $password = $row['password']; // Note: You should never display the password in plain text, this is just an example
    $age = $row['age'];
    $contact_number = $row['contact_number'];
    $citizenship_front = $row['citizenship_front'];
    $citizenship_back = $row['citizenship_back'];
    $guardian_name = $row['guardian_name'];
    $guardian_contact_number = $row['guardian_contact_number'];
    $address = $row['address'];
}
else {
    // Handle case where user does not exist
    echo "User not found";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    
<nav>
        <ul>
            <li>
                <a href="ResidentDash.php">
                    <img src="Hostel.avif" alt="Hostel Logo" class="logo">
                    Dashboard
                </a>
            </li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="PaymentResident.html">My Payments</a></li>
            <li><a href="MainteneceRequest.html">Maintenance Requests</a></li>
            <li><a href="user_chat.php">Chats</a></li> <!-- Redirect to chat.html -->
            <li><a href="logout.php?logout=true">Logout</a></li>
    
        </ul>
</nav>

    <div class="content">
        <h1>User Profile</h1>
        <div class="profile-details">
            <form method="POST" action="update_profile.php">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" value="<?php echo $password; ?>">
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" value="<?php echo $age; ?>">
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="tel" id="contact_number" name="contact_number" value="<?php echo $contact_number; ?>">
                </div>
                <div class="form-group">
                    <label for="citizenship_front">Citizenship Front:</label>
                    <input type="file" id="citizenship_front" name="citizenship_front" accept="image/*">
                    <?php if (!empty($citizenship_front)) {
                        echo '<img src="' . $citizenship_front . '" alt="Citizenship Front">';
                    } ?>
                </div>
                <div class="form-group">
                    <label for="citizenship_back">Citizenship Back:</label>
                    <input type="file" id="citizenship_back" name="citizenship_back" accept="image/*">
                    <?php if (!empty($citizenship_back)) {
                        echo '<img src="' . $citizenship_back . '" alt="Citizenship Back">';
                    } ?>
                </div>
                <div class="form-group">
                    <label for="guardian_name">Guardian's Name:</label>
                    <input type="text" id="guardian_name" name="guardian_name" value="<?php echo $guardian_name; ?>">
                </div>
                <div class="form-group">
                    <label for="guardian_contact_number">Guardian's Contact Number:</label>
                    <input type="tel" id="guardian_contact_number" name="guardian_contact_number" value="<?php echo $guardian_contact_number; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address"><?php echo $address; ?></textarea>
                </div>
                <!-- Add other input fields as needed -->
                <button type="submit" class="submit-button">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>
