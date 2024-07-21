<?php include_once "../configuration.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Room</title>
    <link rel="stylesheet" href="manage_room.css">

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
    <nav>
        <ul>
            <li>
            <img src="image/Hostel.avif" alt="Hostel Logo" class="logo">
            <a href="home.php">Dashboard</a>
            </li>
            <li><a href="manage_room.php">Rooms</a></li>
            <li><a href="managestaff.php">Staff</a></li>
            <li><a href="#">Residents</a></li>
            <li><a href="billing_details.php">Billing Details</a></li>
            <li><a href="manage_payment.php">Payment Info</a></li>
            <li><a href="admin_view_users.php">Chat</a></li>
            <li><a href="#" id = "logout">Logout</a></li>
        </ul>
    </nav>

    <div class="content">
        <h1>Manage Room</h1>

        <table>
            <thead>
                <tr>
                    <th>Room Name</th>
                    <th>Facility</th>
                    <th>Resident Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM hostel";
                $result = mysqli_query($link, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['room_name'] . "</td>";
                        echo "<td>" . nl2br($row['facility']) . "</td>";
                        echo "<td>" . (isset($row['residents_count']) ? $row['residents_count'] : 'N/A') . "</td>";
                        echo "<td>";
                        echo "<button class='update-button' data-room-id='" . $row['room_id'] . "' data-room-name='" . $row['room_name'] . "' data-facility='" . htmlspecialchars($row['facility']) . "' data-resident-count='" . (isset($row['residents_count']) ? $row['residents_count'] : 'N/A') . "'>Update</button>";




                        echo "<button onclick='confirmDelete(" . $row['room_id'] . ")' class='delete-button'>Delete</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No rooms found</td></tr>";
                }
                mysqli_close($link);
                ?>
            </tbody>
        </table>

        <!-- Update overlay modal -->
        <div id="editOverlay" class="overlay">
            <div class="overlay-content">
                <span class="close" onclick="closeOverlay('editOverlay')">&times;</span>
                <h2>Edit Room Details</h2>
                <form id="updateForm" method="post" action="update_room.php">
                    <input type="hidden" id="roomId" name="roomId">
                    <label for="roomName">Room Name:</label>
                    <input type="text" id="roomName" name="roomName" required><br>
                    <label for="facility">Facility:</label>
                    <input type="text" id="facility" name="facility" required><br>
                    <label for="residentCount">Resident Count:</label>
                    <input type="text" id="residentCount" name="residentCount"><br>
                    <button type="submit">Update</button>
                </form>
            </div>
        </div>
          <!-- Add Room button -->
    <button id="addRoomButton">Add Room</button>
        <!-- Add Room section -->

        <div id="addRoomSection" class="overlay">
        <div class="overlay-content">
            <span class="close" onclick="closeOverlay('addRoomSection')">&times;</span>
            <h2>Add Room</h2>
            <form id="addRoomForm" method="post" action="add_room.php">
                <label for="roomName">Room Name:</label>
                <input type="text" id="roomName" name="roomName" required><br>
                <label for="facility">Facility:</label>
                <textarea id="facility" name="facility" rows="4" required></textarea><br>
                <label for="residentCount">Resident Count:</label>
                <input type="text" id="residentCount" name="residentCount"><br>
                <button type="submit">Add Room</button>
            </form>
        </div>
    </div>

        <!-- Delete confirmation modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content delete-modal-content">
                <span class="close" onclick="closeModal('deleteModal')">&times;</span>
                <p>Are you sure you want to delete this room?</p>
                <input type="hidden" id="roomIdToDelete">
                <button onclick="deleteRoom()">Delete</button>
                <button onclick="closeModal('deleteModal')" class="delete-button">Cancel</button>
            </div>
        </div>

    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('facility').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                var facilityInput = document.getElementById('facility');
                var facilityText = facilityInput.value.trim(); // Remove leading and trailing whitespace
                if (facilityText !== '') {
                    facilityInput.value += '\n- '; // Add dash for each facility
                }
            }
        });
    });
     // Add event listener to the "Add Room" button
     document.getElementById('addRoomButton').addEventListener('click', function() {
            // Display the "Add Room" section as a pop-up
            document.getElementById('addRoomSection').style.display = 'block';
        });
  

    function openEditOverlay(roomId, roomName, roomPrice, facility, residentCount) {
    // Populate the form fields with existing room details
    document.getElementById('roomId').value = roomId;
    document.getElementById('roomName').value = roomName;
    document.getElementById('facility').value = facility;
    document.getElementById('residentCount').value = residentCount;

    // Display the overlay
    document.getElementById('editOverlay').style.display = 'block'; 
}


    function confirmDelete(roomId) {
        document.getElementById('deleteModal').style.display = 'block';
        // Store the room ID in a hidden field in the modal
        document.getElementById('roomIdToDelete').value = roomId;
    }

    function deleteRoom() {
        var roomId = document.getElementById('roomIdToDelete').value;
        window.location.href = 'delete_room.php?roomId=' + roomId;
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function closeOverlay(overlayId) {
        document.getElementById(overlayId).style.display = 'none';
    }

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

    document.addEventListener("DOMContentLoaded", function() {
        // Get all the "Update" buttons
        var updateButtons = document.querySelectorAll('.update-button');

        // Add click event listener to each "Update" button
        updateButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Get the room details from the button's data attributes
                var roomId = button.getAttribute('data-room-id');
                var roomName = button.getAttribute('data-room-name');
                var facility = button.getAttribute('data-facility');
                var residentCount = button.getAttribute('data-resident-count');

                // Populate the form fields with the room details
                document.getElementById('roomId').value = roomId;
                document.getElementById('roomName').value = roomName;
                document.getElementById('facility').value = facility;
                document.getElementById('residentCount').value = residentCount;

                // Display the edit overlay
                document.getElementById('editOverlay').style.display = 'block';
            });
        });
    });

</script>




</body>
</html>
