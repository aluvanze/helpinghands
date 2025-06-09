<?php
$host = 'localhost';
$dbname = 'u102833347_helpinghands';
$username = 'u102833347_hhands'; // Replace with your MySQL username
$password = 'fmrcF1Co&'; // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>