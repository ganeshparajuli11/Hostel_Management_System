<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ResidentLogin.php');
    exit;
}

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    $_SESSION = array();
    session_destroy();
    $_SESSION['logout_message'] = 'Logout successful.';
    header('Location: ResidentLogin.php');
    exit;
}
?>
