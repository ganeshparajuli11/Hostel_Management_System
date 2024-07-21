<?php
include 'configuration.php';

session_start();
if (!isset($_SESSION['email'])) {
    header("location: ResidentLogin.php");
    exit();
}

$email = $_SESSION['email'];
$sql_pending = "SELECT pending_amount FROM billing WHERE user_id = (SELECT user_id FROM user WHERE email = ?)";
$stmt_pending = mysqli_prepare($link, $sql_pending);
mysqli_stmt_bind_param($stmt_pending, "s", $email);
mysqli_stmt_execute($stmt_pending);
mysqli_stmt_bind_result($stmt_pending, $pendingAmount);
mysqli_stmt_fetch($stmt_pending);
mysqli_stmt_close($stmt_pending);

echo $pendingAmount;

mysqli_close($link);
?>
