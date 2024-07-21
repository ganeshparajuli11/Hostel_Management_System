<?php
// Include database connection and setup
include_once "../configuration.php";

// Query to fetch user table data
$query = "SELECT * FROM user";
$result = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Residents</title>
    <link rel="stylesheet" href="manage_resident.css">
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
</head>
<body>
<<nav>
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
        <li><a href="#" id="logout">Logout</a></li>
    </ul>
</nav>
<h2 style="margin-left: 240px;">Manage Residents</h2>
<div id="table_container"> 
    <table class="small-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Contact Number</th>
                <th>Citizenship Front</th>
                <th>Citizenship Back</th>
                <th>Guardian Name</th>
                <th>Guardian Contact Number</th>
                <th>Address</th>
                <th>Assigned Room Name</th>
                <th>User Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['age'] . "</td>";
                echo "<td>" . $row['contact_number'] . "</td>";
                echo "<td> <img src= '" .$row['citizenship_front'] . "' alt='Citizenship Front' style='width: 50px;'> </td>";
                echo "<td> <img src= '" .$row['citizenship_back'] . "' alt='Citizenship Back' style='width: 50px;'> </td>";
                echo "<td>" . $row['guardian_name'] . "</td>";
                echo "<td>" . $row['guardian_contact_number'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['assigned_room_name'] . "</td>";
                echo "<td>" . ($row['user_status'] == 1 ? 'Approved' : 'Not Approved') . "</td>";
                echo "<td><a href='update_user.php?user_id=" . $row['user_id'] . "'>Update</a> | <a href='delete_user.php?user_id=" . $row['user_id'] . "'>Delete</a></td>"; // Update and delete buttons
                echo "</tr>";
            }
           
            ?>
        </tbody>
    </table>
</div>


<style>
    
</style>

<button class="add-resident-btn" id="addResidentBtn">Add Resident</button>

<!-- Modal for Add User Form -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add User</h2>
        <form id="addUserForm" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
</div>


<div class="form-group">
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
</div>
<div class="form-group">
    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>
</div>


<div class="form-group">
    <label for="contactNumber">Contact Number:</label>
    <input type="text" id="contactNumber" name="contactNumber" required>
</div>

<div class="form-group">
    <label for="citizenship">Citizenship Front:</label>
    <input type="file" id="citizenship" name="citizenship" accept="image/*" required>
</div>
<div class="form-group">
    <label for="citizenship-back">Citizenship Back:</label>
    <input type="file" id="citizenship-back" name="citizenshipBack" accept="image/*" required>
</div>


<div class="form-group">
    <label for="guardianName">Guardian Name:</label>
    <input type="text" id="guardianName" name="guardianName" required>
</div>
<div class="form-group">
    <label for="guardianContactNumber">Guardian Contact Number:</label>
    <input type="text" id="guardianContactNumber" name="guardianContactNumber" required>
</div>


<div class="form-group">
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>
</div>
<div class="form-group">
    <label for="assignedRoomName">Assigned Room:</label>
    <select id="assignedRoomName" name="assignedRoomName" required>
        <option value="">Select a room</option>
        <?php include 'get_rooms.php'; ?>
    </select>
</div>


<button type="submit">Add User</button>
</form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const addResidentBtn = document.getElementById("addResidentBtn");
    const modal = document.getElementById("addUserModal");
    const closeBtn = document.getElementsByClassName("close")[0];

    addResidentBtn.onclick = function() {
        modal.style.display = "flex";
    }

    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    const form = document.getElementById("addUserForm");
    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const formData = new FormData(form);

        fetch("add_user.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            window.location.href = "manage_resident.php";
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});

document.getElementById('logout').addEventListener('click', function() {
        // Show a confirmation dialog
        if (confirm('Are you sure you want to logout?\nThis will redirect you to the login page.')) {
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