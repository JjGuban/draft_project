<?php
// core/models.php

require 'dbConfig.php';

// Create user for registration
function createUser($username, $email, $password) {
    global $conn;
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([trim($username), trim($email), $passwordHash]);
}

// Get user by username for login validation
function getUserByUsername($username) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([trim($username)]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get user by ID for profile display and editing
function getUserById($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update user information
function updateUser($user_id, $username, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE user_id = ?");
    $stmt->execute([trim($username), trim($email), $user_id]);
}

// Delete user account
function deleteUser($user_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
}

// Create manga listing
function createManga($title, $genre, $author, $price, $user_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO manga (title, genre, author, price, user_id, added_by) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([trim($title), trim($genre), trim($author), $price, $user_id]);
}


// Get manga by ID for details display
function getMangaById($manga_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM manga WHERE manga_id = ?");
    $stmt->execute([$manga_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Update manga information
function updateManga($manga_id, $title, $genre, $author, $price) {
    global $conn;
    $stmt = $conn->prepare("UPDATE manga SET title = ?, genre = ?, author = ?, price = ?, last_updated = NOW() WHERE manga_id = ?");
    $stmt->execute([trim($title), trim($genre), trim($author), $price, $manga_id]);
}


// Delete manga listing
function deleteManga($manga_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM manga WHERE manga_id = ?");
    $stmt->execute([$manga_id]);
}

// Fetch all mangas with uploader's username
function getAllMangas() {
    global $conn;
    $stmt = $conn->prepare("
        SELECT manga.*, users.username
        FROM manga
        JOIN users ON manga.user_id = users.user_id
        ORDER BY manga.added_by DESC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create purchase record for manga
function createPurchase($user_id, $manga_id) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO purchases (user_id, manga_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $manga_id]);
}

// Get user purchases
function getUserPurchases($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT p.purchase_id, m.title, m.author, m.genre, m.price, p.purchase_date FROM purchases p JOIN manga m ON p.manga_id = m.manga_id WHERE p.user_id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Delete a purchase
function deletePurchase($purchase_id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM purchases WHERE purchase_id = ?");
    $stmt->execute([$purchase_id]);
}


?>
