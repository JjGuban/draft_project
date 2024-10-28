<?php
// addmanga.php

session_start();
require 'core/dbConfig.php';
require 'core/models.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $author = trim($_POST['author']);
    $price = trim($_POST['price']);

    if (!empty($title) && !empty($genre) && !empty($author) && !empty($price) && is_numeric($price)) {
        createManga($title, $genre, $author, $price, $user_id);
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Please fill in all fields and enter a valid price.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Manga - Mang Store</title>
</head>
<body>
    <h1>Add Your Own Manga</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br><br>

        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre" required><br><br>

        <label for="author">Author:</label>
        <input type="text" name="author" id="author" required><br><br>

        <label for="price">Price:</label>
        <input type="text" name="price" id="price" required><br><br>

        <button type="submit">Add Manga</button>
    </form>

    <p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>
