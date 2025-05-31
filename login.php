<?php
   session_start();
   require_once 'db_connect.php';

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $username = trim($_POST['username']);
       $password = trim($_POST['password']);

       if (empty($username) || empty($password)) {
           die('Please fill out all fields.');
       }

       try {
           $stmt = $pdo->prepare('SELECT id, password FROM users WHERE username = ?');
           $stmt->execute([$username]);
           $user = $stmt->fetch();

           if ($user && password_verify($password, $user['password'])) {
               $_SESSION['user_id'] = $user['id'];
               header('Location: index.php'); // Changed from upload.php to index.php
               exit;
           } else {
               die('Invalid username or password.');
           }
       } catch (PDOException $e) {
           die('Error: ' . $e->getMessage());
       }
   }
   ?>