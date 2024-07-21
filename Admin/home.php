<?php include_once "../configuration.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System - Admin Page</title>
    <link rel="stylesheet" href="home.css">
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
    <div class="content">
        <p>Welcome Admin!</p>
        
        <div class="info-box-container">
            <?php
                // Query to get total counts
                $roomCountQuery = "SELECT COUNT(*) AS totalRooms FROM hostel";
                $staffCountQuery = "SELECT COUNT(*) AS totalStaff FROM staff";
                $residentCountQuery = "SELECT COUNT(*) AS totalResidents FROM user";
                $residentPayementQuery = "SELECT SUM(received_amount) AS totalPayments FROM billing";
               

                // Execute queries
                $roomCountResult = mysqli_query($link, $roomCountQuery);
                $staffCountResult = mysqli_query($link, $staffCountQuery);
                $residentCountResult = mysqli_query($link, $residentCountQuery);
                $residentPaymentResult = mysqli_query($link, $residentPayementQuery);

                // Fetch counts
                $roomCount = mysqli_fetch_assoc($roomCountResult)['totalRooms'];
                $staffCount = mysqli_fetch_assoc($staffCountResult)['totalStaff'];
                $residentCount = mysqli_fetch_assoc($residentCountResult)['totalResidents'];
                $paymentCount = mysqli_fetch_assoc($residentPaymentResult)['totalPayments'];

            ?>

            <div class="info-box">
                <h2>Total Rooms</h2>
                <p class="total-room">Room Number: <?php echo $roomCount; ?></p>
                <img src="image/Room.png" alt="Room Image">
            </div>

            <div class="info-box">
                <h2>Total Staff</h2>
                <p class="total-staff">Staff Count: <?php echo $staffCount; ?></p>
                <img src="image/staff.jpg" alt="Bed Image">
            </div>

            <div class="info-box">
                <h2>Total Residents</h2>
                <p class="total-staff">Residents Count: <?php echo $residentCount; ?></p>
                <img src="image/Residents.jpg" alt="Resident Image">
            </div>

            <div class="info-box">
                <h2>Total Billing</h2>
                <p class="total-payment">Total Amount:<?php echo $paymentCount; ?></p>

                <img src="image/Payment.png" alt="Billing Image">
            </div>
        </div>

        <div class="graph-box-container">
            <div class="graph-box">
                <h2>Yearly Report</h2>
                <img src="image/Yearly.jpg" alt="Yearly Report Graph">
            </div>

            <div class="graph-box">
                <h2>Monthly Report</h2>
                <img src="image/Monthly.ppm" alt="Monthly Report Graph">
            </div>
        </div>

        <!-- Your content goes here -->
    </div>
    <div class="admin-profile">
        <img src="image/Admin.jpg" alt="Admin Profile">
        <p>ADMIN</p>
    </div>
    <script>
        // JavaScript code for hover effect
        const infoBoxes = document.querySelectorAll('.info-box');
        const graphBoxes = document.querySelectorAll('.graph-box');

        infoBoxes.forEach(box => {
            box.addEventListener('mouseenter', () => {
                box.style.transform = 'scale(1.1)';
            });

            box.addEventListener('mouseleave', () => {
                box.style.transform = 'scale(1)';
            });
        });

        graphBoxes.forEach(box => {
            box.addEventListener('mouseenter', () => {
                box.style.transform = 'scale(1.1)';
            });

            box.addEventListener('mouseleave', () => {
                box.style.transform = 'scale(1)';
            });
        });


            // Add event listener to the logout link
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
