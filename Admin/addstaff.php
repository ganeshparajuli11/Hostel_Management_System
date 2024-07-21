<?php
// Include the database connection file
include '../configuration.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Note: Hash password before storing it in the database for security
    $age = $_POST['age'];
    $contactNumber = $_POST['contactNumber'];
    $address = $_POST['address'];

    // Handle citizenship front image upload
    $citizenshipFrontName = $_FILES['citizenship']['name'];
    $citizenshipFrontTmp = $_FILES['citizenship']['tmp_name'];
    $citizenshipFrontPath = "uploads/" . $citizenshipFrontName; // Change "uploads/" to your desired directory

    // Handle citizenship back image upload
    $citizenshipBackName = $_FILES['citizenshipBack']['name'];
    $citizenshipBackTmp = $_FILES['citizenshipBack']['tmp_name'];
    $citizenshipBackPath = "uploads/" . $citizenshipBackName; // Change "uploads/" to your desired directory

    // Move uploaded front image file to designated directory
    if (move_uploaded_file($citizenshipFrontTmp, $citizenshipFrontPath)) {
        echo "Citizenship front image uploaded successfully.\n";
    } else {
        echo "Error: Failed to move front uploaded file.\n";
    }

    // Move uploaded back image file to designated directory
    if (move_uploaded_file($citizenshipBackTmp, $citizenshipBackPath)) {
        echo "Citizenship back image uploaded successfully.\n";
    } else {
        echo "Error: Failed to move back uploaded file.\n";
    }

    // Insert staff details into the database
    $insertSql = "INSERT INTO staff (first_name, last_name, email, password, age, contact_number, address, citizenship_front, citizenship_back) 
                  VALUES ('$firstName', '$lastName', '$email', '$password', '$age', '$contactNumber', '$address', '$citizenshipFrontPath', '$citizenshipBackPath')";

    if (mysqli_query($link, $insertSql)) {
        // Insert successful
        echo "Staff added successfully.";

    } else {
        // Insert failed
        echo "Error: " . $insertSql . "<br>" . mysqli_error($link);
    }
header("Location: manageStaff.php");
    // Close the database connection
    mysqli_close($link);
}
?>
