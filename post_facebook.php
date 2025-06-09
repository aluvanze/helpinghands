```php
<?php
session_start();
require_once 'db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_url = filter_input(INPUT_POST, 'post_url', FILTER_SANITIZE_URL);
    $content = filter_input(INPUT_POST, 'post_content', FILTER_SANITIZE_STRING);

    if ($post_url && $content) {
        try {
            $stmt = $pdo->prepare('INSERT INTO facebook_posts (post_url, content, posted_at) VALUES (?, ?, NOW())');
            $stmt->execute([$post_url, $content]);
            header('Location: index.php#facebook-feed');
            exit;
        } catch (PDOException $e) {
            error_log('Post insertion error: ' . $e->getMessage());
            $error = 'Error saving post. Please try again.';
        }
    } else {
        $error = 'Please provide both post URL and content.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Facebook Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #fff7e6, #e0f7fa); }
        .btn-primary { background: linear-gradient(45deg, #ff6b6b, #ff8e53); transition: transform 0.2s ease; }
        .btn-primary:hover { transform: scale(1.1); background: linear-gradient(45deg, #ff8e53, #ff6b6b); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="max-w-lg w-full bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Add Facebook Post</h2>
        <?php if (isset($error)): ?>
            <p class="text-red-600 text-center mb-2"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <input type="url" name="post_url" placeholder="Enter Facebook Post URL" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400" required>
            <textarea name="post_content" placeholder="Enter post content" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400" rows="5" required></textarea>
            <button type="submit" class="btn-primary w-full text-white px-6 py-3 rounded-lg font-semibold">Add Post</button>
            <p class="text-center text-center mt-4"><a href="/index.php" class="text-orange-600 hover:underline">Back to Home</a></p>
        </form>
    </div>
</body>
</html>
```