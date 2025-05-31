<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if (empty($username) || empty($password) || empty($confirm_password)) {
        die('Please fill out all fields.');
    }

    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    if (strlen($username) < 3 || strlen($username) > 50) {
        die('Username must be between 3 and 50 characters.');
    }

    if (strlen($password) < 6) {
        die('Password must be at least 6 characters.');
    }

    try {
        // Check if username exists
        $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            die('Username already taken.');
        }

        // Hash password and insert user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->execute([$username, $hashed_password]);

        header('Location: login.html');
        exit;
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}
?>