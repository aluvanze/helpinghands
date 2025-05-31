<?php
require_once 'db_connect.php';

try {
    $stmt = $pdo->query('SELECT path, alt_text FROM images ORDER BY uploaded_at DESC');
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($images);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>