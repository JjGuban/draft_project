<?php
// dashboard.php

session_start();
require 'core/dbConfig.php';
require 'core/models.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch all manga listings
$mangaList = getAllManga();

// Fetch user's purchases
$purchases = getUserPurchases($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['buy'])) {
        $manga_id = $_POST['manga_id'];
        createPurchase($user_id, $manga_id);
        header("Location: dashboard.php");
        exit();
    } elseif (isset($_POST['cancel'])) {
        $purchase_id = $_POST['purchase_id'];
        deletePurchase($purchase_id);
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Mang Store</title>
</head>
<body>
    <h1>Welcome to Mang Store!</h1>
    <h2>Available Manga</h2>

    <!-- Manga Table -->
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($mangaList as $manga): ?>
        <tr>
            <td><?php echo htmlspecialchars($manga['title']); ?></td>
            <td><?php echo htmlspecialchars($manga['author']); ?></td>
            <td><?php echo htmlspecialchars($manga['genre']); ?></td>
            <td><?php echo htmlspecialchars($manga['price']); ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="manga_id" value="<?php echo $manga['manga_id']; ?>">
                    <button type="submit" name="buy">Buy</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Your Purchases</h2>

    <!-- User's Purchase Table -->
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php foreach ($purchases as $purchase): ?>
        <tr>
            <td><?php echo htmlspecialchars($purchase['title']); ?></td>
            <td><?php echo htmlspecialchars($purchase['author']); ?></td>
            <td><?php echo htmlspecialchars($purchase['genre']); ?></td>
            <td><?php echo htmlspecialchars($purchase['price']); ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="purchase_id" value="<?php echo $purchase['purchase_id']; ?>">
                    <button type="submit" name="cancel">Cancel Purchase</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Link to Add New Manga -->
    <p><a href="addmanga.php">Add your own manga!</a></p>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
