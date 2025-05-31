<?php
session_start();
require_once 'db_connect.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Initialize error/success message
$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alt_text = trim($_POST['alt_text']);
    $image = $_FILES['image'];

    if (empty($alt_text) || empty($image['name'])) {
        $_SESSION['message'] = 'Please provide an image and alt text.';
        header('Location: upload.php');
        exit;
    }

    // Validate image
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB
    if (!in_array($image['type'], $allowed_types) || $image['size'] > $max_size) {
        $_SESSION['message'] = 'Invalid image type or size. Use JPEG, PNG, or GIF under 5MB.';
        header('Location: upload.php');
        exit;
    }

    // Generate unique filename
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_') . '.' . $ext;
    $upload_path = 'images/' . $filename;

    // Move uploaded file
    if (move_uploaded_file($image['tmp_name'], $upload_path)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO images (path, alt_text) VALUES (?, ?)');
            $stmt->execute([$upload_path, $alt_text]);
            $_SESSION['message'] = 'Image uploaded successfully!';
            header('Location: index.php#gallery');
            exit;
        } catch (PDOException $e) {
            unlink($upload_path); // Remove file on database error
            $_SESSION['message'] = 'Error saving to database: ' . $e->getMessage();
            header('Location: upload.php');
            exit;
        }
    } else {
        $_SESSION['message'] = 'Error uploading image.';
        header('Location: upload.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Upload images to the Helping Hands gallery.">
  <meta name="keywords" content="upload, helping hands, nonprofit, gallery">
  <meta name="author" content="Helping Hands">
  <title>Helping Hands - Upload Image</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff7e6, #e0f7fa);
    }
    .upload-form {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 15px;
    }
    .upload-form:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .btn-primary {
      background: linear-gradient(45deg, #ff6b6b, #ff8e53);
      transition: transform 0.2s ease;
    }
    .btn-primary:hover {
      transform: scale(1.1);
      background: linear-gradient(45deg, #ff8e53, #ff6b6b);
    }
    .sticky-header {
      background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
    }
    .hamburger div {
      width: 25px;
      height: 3px;
      background: white;
      margin: 5px;
      transition: all 0.3s ease;
    }
    .hamburger.active div:nth-child(1) {
      transform: rotate(45deg) translate(5px, 5px);
    }
    .hamburger.active div:nth-child(2) {
      opacity: 0;
    }
    .hamburger.active div:nth-child(3) {
      transform: rotate(-45deg) translate(7px, -7px);
    }
    .nav-links {
      display: flex;
    }
    @media (max-width: 768px) {
      .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        position: absolute;
        top: 64px;
        left: 0;
        background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
        padding: 1rem;
      }
      .nav-links.active {
        display: flex;
      }
      .hamburger {
        display: flex;
        flex-direction: column;
        cursor: pointer;
      }
    }
  </style>
</head>
<body class="min-h-screen flex flex-col">
  <!-- Header -->
  <header class="sticky-header text-white sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
      <a href="index.php" aria-label="Helping Hands Home">
        <img src="images/helping-hands.jpg" alt="Helping Hands Logo" class="h-12 w-auto object-contain">
      </a>
      <div class="hamburger md:hidden" onclick="toggleMenu()">
        <div></div><div></div><div></div>
      </div>
      <ul class="nav-links flex space-x-6 md:flex md:items-center">
        <li><a href="index.php#home" class="hover:underline text-lg" aria-label="Home">Home</a></li>
        <li><a href="index.php#about" class="hover:underline text-lg" aria-label="About Us">About</a></li>
        <li><a href="index.php#projects" class="hover:underline text-lg" aria-label="Our Projects">Projects</a></li>
        <li><a href="index.php#gallery" class="hover:underline text-lg" aria-label="Gallery">Gallery</a></li>
        <li><a href="index.php#facebook-feed" class="hover:underline text-lg" aria-label="Facebook Feed">Facebook Feed</a></li>
        <li><a href="index.php#contact" class="hover:underline text-lg" aria-label="Contact Us">Contact</a></li>
        <li><a href="upload.php" class="hover:underline text-lg" aria-label="Upload Image">Upload</a></li>
        <li><a href="logout.php" class="hover:underline text-lg" aria-label="Logout">Logout</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center py-16">
    <div class="upload-form bg-white p-8 rounded-2xl shadow-lg max-w-md w-full">
      <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Upload Image</h2>
      <?php if ($message): ?>
        <p class="text-center mb-4 <?php echo strpos($message, 'successfully') !== false ? 'text-green-600' : 'text-red-600'; ?>">
          <?php echo htmlspecialchars($message); ?>
        </p>
      <?php endif; ?>
      <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label for="image" class="block text-gray-700 mb-2">Select Image (JPEG, PNG, GIF, max 5MB)</label>
          <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif" class="w-full p-3 border border-gray-300 rounded-lg" required aria-label="Select Image">
        </div>
        <div class="mb-4">
          <label for="alt_text" class="block text-gray-700 mb-2">Alt Text</label>
          <input type="text" name="alt_text" id="alt_text" placeholder="Describe the image" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400" required aria-label="Alt Text">
        </div>
        <button type="submit" class="btn-primary text-white px-6 py-3 rounded-full font-semibold w-full">Upload</button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="text-white text-center py-6 bg-gradient-to-r from-pink-500 to-cyan-500">
    <div class="container mx-auto px-4">
      <p class="text-lg mb-2">© 2025 Helping Hands. All rights reserved.</p>
    </div>
  </footer>

  <script>
    // Toggle mobile menu
    function toggleMenu() {
      const navLinks = document.querySelector('.nav-links');
      const hamburger = document.querySelector('.hamburger');
      navLinks.classList.toggle('active');
      hamburger.classList.toggle('active');
    }
  </script>
</body>
</html>