<?php
// Include the database connection file
include '../configuration.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $staffId = $_POST['staffId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contactNumber = $_POST['contactNumber'];
    $address = $_POST['address'];

    // Update staff details in the database
    $sql = "UPDATE staff SET first_name='$firstName', last_name='$lastName', age='$age', email='$email', password='$password', contact_number='$contactNumber', address='$address' WHERE staff_id=$staffId";

    if (mysqli_query($link, $sql)) {
        // Redirect back to the manageStaff.php page after updating
        header("Location: manageStaff.php");
        exit();
    } else {
        echo "Error updating staff details: " . mysqli_error($link);
    }
}

// Close the database connection
mysqli_close($link);
?>
