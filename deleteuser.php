<?php
// deleteuser.php

session_start();
require 'core/dbConfig.php';
require 'core/models.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    deleteUser($_SESSION['user_id']);
    session_destroy();
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
</head>
<body>
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete your account? This action cannot be undone.</p>
    <form action="deleteuser.php" method="POST">
        <button type="submit">Yes, delete my account</button>
    </form>
    <a href="viewuser.php">Cancel</a>
</body>
</html>
