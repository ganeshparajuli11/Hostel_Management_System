<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Management System - Pay Fee</title>
    <link rel="stylesheet" href="paymentGateway.css">
</head>
<body>
    <nav>
        <ul>
            <li>
                <a href="#">
                    <img src="Hostel.avif" alt="Hostel Logo" class="logo">
                    Dashboard
                </a>
            </li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Book Facilities</a></li>
            <li><a href="#">My Payments</a></li>
            <li><a href="#">Maintenance Requests</a></li>
            <li><a href="#">Notifications</a></li>
            <li><a href="#">Chats</a></li>
            <li><a href="#">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h1>Pay Fee</h1>
        <p>Select a payment method:</p>
        <div class="payment-methods">
            <div class="payment-method">
                <img src="nmb.png" alt="Bank Transfer">
                <p>NMB Bank</p>
            </div>
            <div class="payment-method">
                <img src="Esewa.png" alt="Online Wallet">
                <p>Esewa</p>
            </div>
        </div>
        <div class="confirmation-message" style="display: none;">
            <p>Payment successful! You will receive a receipt shortly.</p>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
