
<?php
session_start();
require_once 'db_connect.php';
ini_set('display_errors', 0); // Enable temporarily for debugging: ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Helping Hands empowers underserved communities through education, healthcare, and sustainable development with joy and positivity.">
  <meta name="keywords" content="nonprofit, community, education, healthcare, sustainable development, charity">
  <meta name="author" content="Helping Hands">
  <title>Helping Hands</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #fff7e6, #e0f7fa); }
    .sticky-header { background: linear-gradient(90deg, #ff6b6b, #4ecdc4); transition: all 0.3s ease; }
    .hero-section {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://picsum.photos/1200/400?text=Helping+Hands+Joyful+Community') center/cover;
      background-attachment: fixed;
      animation: fadeIn 2s ease-in;
    }
    @keyframes fadeIn { 0% { opacity: 0; } 100% { opacity: 1; } }
    .project-card, .contact-form { transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 15px; }
    .project-card:hover, .contact-form:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2); }
    .gallery-img { transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 10px; }
    .gallery-img:hover { transform: scale(1.1) rotate(2deg); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); }
    .btn-primary { background: linear-gradient(45deg, #ff6b6b, #ff8e53); transition: transform 0.2s ease; }
    .btn-primary:hover { transform: scale(1.1); background: linear-gradient(45deg, #ff8e53, #ff6b6b); }
    #lightbox { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); justify-content: center; align-items: center; z-index: 1000; animation: slideIn 0.5s ease; }
    #lightbox.active { display: flex; }
    @keyframes slideIn { 0% { transform: translateY(50px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
    .hamburger { display: none; flex-direction: column; cursor: pointer; width: 30px; height: 24px; justify-content: space-between; }
    .hamburger div { background: white; height: 4px; width: 100%; transition: all 0.3s ease; border-radius: 2px; }
    .hamburger.active div:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
    .hamburger.active div:nth-child(2) { opacity: 0; }
    .hamburger.active div:nth-child(3) { transform: rotate(-45deg) translate(7px, -7px); }
    @media (max-width: 768px) {
      .nav-links { display: none; flex-direction: column; width: 100%; position: absolute; top: 64px; left: 0; background: linear-gradient(90deg, #ff6b6b, #4ecdc4); padding: 1rem; z-index: 40; }
      .nav-links.active { display: flex; animation: slideDown 0.3s ease; }
      .nav-links li { margin: 0.5rem 0; }
      @keyframes slideDown { 0% { transform: translateY(-10px); opacity: 0; } 100% { transform: translateY(0); opacity: 1; } }
      .hamburger { display: flex; }
      .nav-links a { font-size: 1.25rem; }
    }
    .social-icon { transition: transform 0.3s ease; fill: white; }
    .social-icon:hover { transform: scale(1.3); fill: #ffeb3b; }
    footer { background: linear-gradient(90deg, #ff6b6b, #4ecdc4); position: relative; z-index: 1; }
    .slideshow-container { position: relative; max-width: 1000px; margin: auto; }
    .slide { display: none; width: 100%; height: 400px; object-fit: cover; border-radius: 10px; }
    .slide.active { display: block; animation: fade 1s ease-in-out; }
    @keyframes fade { from { opacity: 0.4; } to { opacity: 1; } }
    .prev, .next { cursor: pointer; position: absolute; top: 50%; transform: translateY(-50%); width: auto; padding: 16px; color: white; font-weight: bold; font-size: 18px; transition: 0.3s ease; border-radius: 0 3px 3px 0; background-color: rgba(0,0,0,0.5); }
    .next { right: 0; border-radius: 3px 0 0 3px; }
    .prev:hover, .next:hover { background-color: rgba(0,0,0,0.8); }
    .dots { text-align: center; padding: 10px 0; }
    .dot { cursor: pointer; height: 15px; width: 15px; margin: 0 5px; background-color: #bbb; border-radius: 50%; display: inline-block; transition: background-color 0.3s ease; }
    .dot.active, .dot:hover { background-color: #ff6b6b; }
    .fb-post-container { max-width: 500px; margin: 0 auto 1rem; background: #fff; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); padding: 1rem; }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="sticky-header text-white sticky top-0 z-50">
    <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
      <a href="#home" aria-label="Helping Hands Home">
        <img src="images/helping-hands.jpg" alt="Helping Hands Logo" class="h-12 w-auto object-contain">
      </a>
      <div class="hamburger" onclick="toggleMenu()">
        <div></div><div></div><div></div>
      </div>
      <ul class="nav-links flex space-x-6 md:flex md:items-center">
        <li><a href="#home" class="hover:underline text-lg">Home</a></li>
        <li><a href="#about" class="hover:underline text-lg">About</a></li>
        <li><a href="#projects" class="hover:underline text-lg">Projects</a></li>
        <li><a href="#gallery" class="hover:underline text-lg">Gallery</a></li>
        <li><a href="#facebook-feed" class="hover:underline text-lg">Facebook Feed</a></li>
        <li><a href="#contact" class="hover:underline text-lg">Contact</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="upload.php" class="hover:underline text-lg">Upload</a></li>
          <li><a href="post_facebook.php" class="hover:underline text-lg">Add Post</a></li>
          <li><a href="logout.php" class="hover:underline text-lg">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html" class="hover:underline text-lg">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <!-- Home Section -->
  <section id="home" class="hero-section h-96 flex items-center justify-center text-center text-white">
    <div class="bg-black bg-opacity-50 p-8 rounded-2xl animate-pulse">
      <h2 class="text-5xl font-bold mb-4">We are Helping Hands Pwani</h2>
      <p class="text-xl mb-6">Team Kazi & Accountability</p>
      <a href="#contact" class="btn-primary text-white px-6 py-3 rounded-full font-semibold">Get Involved</a>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">About Us</h2>
      <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
        A registered NGO with the main aim of helping the orphans, restoration and building of 
        worship houses and schools, feeding the needy, and helping the less fortunate in the society.
        We empower while we help create centers around the projects we do.
      </p>
    </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="bg-gradient-to-r from-yellow-100 to-blue-100 py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">Our Projects</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="project-card bg-white p-6 rounded-2xl shadow-lg">
          <h3 class="text-2xl font-semibold mb-2 text-orange-600"> Water is Life Initiative
          </h3>
          <p class="text-gray-600">By providing clean water and transforming lives, we’re making a difference for thousands in Kenya's coastal region who still face daily struggles to access this essential resource. Our "Water is Life" initiative is committed to tackling water scarcity in Pwani Counties by offering sustainable water solutions, health education, and empowering the community.
          </p>
        </div>
        <div class="project-card bg-white p-6 rounded-2xl shadow-lg">
          <h3 class="text-2xl font-semibold mb-2 text-blue-600">The Ramadhan and Beyond 
          </h3>
          <p class="text-gray-600">It is a heartfelt initiative designed to provide nutritious meals and essential food supplies to vulnerable families, orphans, and marginalized communities throughout the Pwani region during the holy month of Ramadhan, with ongoing support even after. The goal of this project is to combat hunger, nurture compassion, and encourage sustainable food security by distributing food packages, organizing community iftar events, and backing long-term food sustainability projects</p>
        </div>
        <div class="project-card bg-white p-6 rounded-2xl shadow-lg">
          <h3 class="text-2xl font-semibold mb-2 text-blue-600">Project REDSPOT(pad drive) 
          </h3>
          <p class="text-gray-600">The Pads Drive stands as a commendable gesture by Helping Hands Pwani in assisting pubescent girls in marginalized communities. Having access to sanitary pads enables girls to stay in school, renders them more confident, and raises the stigma against menstruation—a vital facet of gender equality. 
          </p>
        </div>
        <div class="project-card bg-white p-6 rounded-2xl shadow-lg">
          <h3 class="text-2xl font-semibold mb-2 text-green-600">Feeding Orphans</h3>
          <p class="text-gray-600"> Project tackles childhood hunger by giving nourishing hot meals to orphans and other vulnerable children living through Kenya's coastal region. Our community-based initiative grants habitual access to balanced meals, throwing in immediate hunger alleviation with horizontal growth support. Most of the orphan children in our communities do not have access to regular healthy meals that would positively affect their growth, education, and development. The project assists children by ensuring orphans are fed hot meals in the shelters, schools, and care centers so that they can have the food to nourish them to growth..</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section id="gallery" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">Gallery</h2>
      <div class="slideshow-container" role="region" aria-label="Image Slideshow">
        <p class="text-center text-gray-600" id="gallery-message">Loading images...</p>
        <a class="prev" onclick="changeSlide(-1)" aria-label="Previous Slide">❮</a>
        <a class="next" onclick="changeSlide(1)" aria-label="Next Slide">❯</a>
      </div>
      <div class="dots"></div>
    </div>
  </section>

  <!-- Facebook Feed Section -->
  <section id="facebook-feed" class="bg-gradient-to-r from-blue-100 to-yellow-100 py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">Our Facebook Updates</h2>
      <div class="max-w-lg mx-auto">
        <?php
        try {
          $stmt = $pdo->query('SELECT post_url, content, posted_at FROM facebook_posts ORDER BY posted_at DESC LIMIT 5');
          $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
          
          if ($posts) {
            foreach ($posts as $post) {
              $post_url = htmlspecialchars($post['post_url']);
              $content = htmlspecialchars($post['content']);
              $posted_at = htmlspecialchars(date('F j, Y, g:i a', strtotime($post['posted_at'])));
              echo '<div class="fb-post-container">';
              echo '<p class="text-gray-700 mb-2">' . $content . '</p>';
              echo '<div class="fb-post" data-href="' . $post_url . '" data-width="500" data-show-text="true"></div>';
              echo '<p class="text-sm text-gray-500 mt-2 mb-2 text-center">Posted on: ' . $posted_at . '</p>';
              echo '<p class="text-center text-sm text-gray-600"><a href="' . $post_url . '" target="_blank" class="text-orange-600 hover:underline">View on Facebook</a></p>';
              echo '</div>';
            }
          } else {
            echo '<p class="text-center text-gray-600">No Facebook posts available at the moment.</p>';
          }
        } catch (PDOException $e) {
          error_log('Facebook posts error: ' . $e->getMessage());
          echo '<p class="text-center text-red-600">Error loading posts. Please try again later.</p>';
        }
        ?>
        <p class="text-sm text-gray-600 text-center mt-4">
          Follow us on <a href="https://www.facebook.com" class="text-orange-600 hover:underline" target="_blank">Facebook</a> for more updates.
        </p>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="bg-gradient-to-r from-green-100 to-blue-100 py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">Contact Us</h2>
      <div class="max-w-lg mx-auto">
        <p class="text-lg text-gray-700 mb-2">Email: <a href="mailto:helpinghandspwani@gmail.com" class="text-orange-600 hover:underline">info@helpinghands.org</a></p>
        <p class="text-lg text-gray-700 mb-2">Phone: <a href="tel:+254722865080\0727377717" class="text-orange-600 hover:underline">+123-456-7890</a></p>
        <p class="text-lg text-gray-700 mb-6">Address: P.O. BOX 40040-80100 MOMBASA.</p>
        <form class="contact-form bg-white p-8 rounded-2xl shadow-lg" onsubmit="return validateForm(event)">
          <h3 class="text-2xl font-semibold mb-4 text-gray-800">Send a Message</h3>
          <input type="text" id="name" placeholder="Your Name" class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400" required aria-label="Your Name">
          <input type="email" id="email" placeholder="Your Email" class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400" required aria-label="Your Email">
          <textarea id="message" placeholder="Your Message" class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-400" rows="5" required aria-label="Your Message"></textarea>
          <button type="submit" class="btn-primary text-white px-6 py-3 rounded-full font-semibold w-full">Send</button>
          <p class="text-sm text-gray-600 mt-4 text-center">Note: Form is for display only due to sandbox restrictions.</p>
        </form>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-white text-center py-6">
    <div class="container mx-auto px-4">
      <p class="text-lg mb-2">© 2025 Helping Hands. All rights reserved.</p>
      <div class="flex justify-center space-x-6">
        <a href="https://facebook.com" class="social-icon" aria-label="Facebook">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
          </svg>
        </a>
        <a href="https://twitter.com" class="social-icon" aria-label="Twitter">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005 1.062-3.127 1.302c-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213.431 5.165 2.449 6.013-1.523-.077-2.958-.766-3.312 1.608-.354 1.874.826 3.236 2.289 3.236-.523.105-1.854.219-2.595 0 .181 2.087 2.027 3.713 3.827 3.146-1.653 1.396-3.009 1.937-4.789 1.937-.548 0-1.154-.085-1.687-.251 1.242 2.076 3.092 3.295 5.208 3.295 6.302 0 9.907-5.864 9.907-10.959 0-.166-.005-.735 0-.901.685-.493 1.279-1.461 2.169-2.274z"/>
          </svg>
        </a>
        <a href="https://instagram.com" class="social-icon" aria-label="Instagram">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.849.069-3.204 0-3.584-.012-4.849-.069-3.26-.149-4.771-1.699-4.919-4.92-.058-1.266-.069-1.645-.069-4.849 0-3.204.012-3.583.069-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-2.732 2.708-6.752 2.756v9.44c.004.004 4.4.152 6.772 2.772 4.28.058 5.688.072 4.948.072 0 0 3.259-.014 4.948-.072 4.354-.2 6.782-2.618 6.83-6.838v-9.482c-.044-.048-2.469-2.366-6.831-2.638-1.28-.058-1.688-.072-4.948-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.162-2.759-6.163-6.759-6.162-2.759-6.162 0zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4 2.209 0 4 1.791 4 4 0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
        </a>
      </div>
    </div>
  </footer>

  <!-- Lightbox for Gallery -->
  <div id="lightbox" onclick="closeLightbox()" role="dialog" aria-label="Image Lightbox">
    <img src="" alt="Lightbox Image" class="max-w-[90%] max-h-[90%] rounded-lg">
  </div>

  <!-- Facebook SDK -->
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v20.0"></script>
  <script>
    window.fbAsyncInit = function() {
      try {
        FB.init({
          appId: '137449455672',
          autoLogAppEvents: true,
          xfbml: true,
          version: 'v20.0'
        });
        console.log('Facebook SDK initialized');
        if (document.querySelector('#facebook-feed')) {
          FB.XFBML.parse(document.getElementById('facebook-feed'), function() {
            console.log('Facebook posts parsed');
            document.querySelectorAll('.fb-post').forEach(function(post) {
              if (!post.querySelector('iframe')) {
                post.innerHTML = '<p class="text-sm text-gray-500 text-center">Failed to load Facebook post. Please view on Facebook.</p>';
              }
            });
          });
        } catch (err) {
          console.error('Facebook SDK error:', err);
          if (document.querySelectorAll('.fb-post')) {
            document.querySelectorAll('.fb-post').forEach(function(post) {
              post.innerHTML = '<p class="text-sm text-gray-500 text-center'>Failed to load Facebook post. Please view on Facebook.</p>';
            });
          }
        }
      };

    // Smooth scrolling for navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

    // Toggle mobile menu
    function toggleMenu() {
      const navLinks = document.querySelector('.nav-links');
      const hamburger = document.querySelector('.hamburger');
      navLinks.classList.toggle('active');
      hamburger.classList.toggle('active');
    }

    // Lightbox functionality
    function openLightbox(src) {
      const lightBox = document.getElementById('lightbox');
      lightbox.querySelector('img').src = src;
      lightBox.classList.add('active');
      lightbox.focus();
    }

    function closeLightbox() {
      const lightBox = document.getElementById('lightbox');
      lightBox.classList.remove('active');
    }

    // Form validation
    function validateForm(event) {
      event.preventDefault();
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const message = document.getElementById('message').value;
      if (name && email && message) {
        alert('Form submitted successfully (for demo purposes).');
      } else {
        alert('Please fill out all fields.');
      }
      return false;
    }

    // Keyboard accessibility for lightbox
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && document.getElementById('lightBox').classList.contains('active')) {
        closeLightbox();
      }
    });

    // Slideshow functionality
    let imageList = [];
    let currentSlide = 0;

    function initializeSlideShow() {
      const slideShowContainer = document.querySelector('.slideshow-container');
      const dotsContainer = document.querySelector('.dots');
      const message = document.getElementById('gallery-message');

      fetch('getImages.php')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
          message.style.display = 'none';
          if (!Array.isArray(data) || data.length === 0) {
            message.textContent = 'No images available.';
            message.style.display = 'block';
            return;
          }

          imageList = data;
          imageList.forEach((image, index) => {
            if (image.path && image.path.trim() !== '') {
              const img = document.createElement('img');
              img.src = image.path;
              img.alt = image.alt_text || 'Gallery image';
              img.className = 'slide-img';
              img.setAttribute('loading', 'lazy');
              img.onclick = () => openLightbox(image.path);
              slideshowContainer.insertBefore(img, slideshowContainer.querySelector('.prev'));

              const dot = document.createElement('span');
              dot.className = 'dot';
              dot.setAttribute('aria-label', 'Go to slide ${index + 1}');
              dot.onclick = () => goToSlide(index);
              dotsContainer.appendChild(dot);
            }
          });

          if (imageList.length > 0) {
            showSlide(currentSlide);
          } else {
            message.textContent = 'No valid images found.';
            message.style.display = 'block';
          }
        })
      .catch(error => {
          console.error('Error fetching images:', error);
          message.textContent = 'Error loading images. Please try again later.';
          message.style.display = 'block';
        });
    }

    function showSlide(index) {
      const slides = document.querySelectorAll('.slide');
      const dots = document.querySelectorAll('.dot');
      if (slides.length === 0) {
        document.getElementById('gallery-message').style.display = 'block';
        return;
      }

      if (index >= slides.length) {
        currentSlide = 0;
      }
      if (index < 0) {
        currentSlide = slides.length - 1;
      }
      else {
        currentSlide = index;
      }

      slides.forEach(slide => slide.classList.remove('active'));
      dots.forEach(dot => dot.classList.remove('active'));
      slides[currentSlide].classList.add('active');
      dots[currentSlide].classList.add('active');
    }

    function changeSlide(n) {
      showSlide(currentSlide + n);
    }

    function goToSlide(index) {
      showSlide(index);
    }

    setInterval(() => {
      if (document.querySelectorAll('slide').length > 0) {
        changeSlide(1);
      }
    }, 5000);

    document.addEventListener('DOMContentLoaded', () => {
      initializeSlideshow();
      if (typeof FB === 'undefined' && document.querySelector('#facebook-feed')) {
        console.log('Facebook SDK not loaded');
        document.querySelectorAll('.fb-post').forEach(post => {
          post.innerHTML = '<p class="text-sm text-gray-500 text-center">Failed to load image post. Please view on Facebook.</p>';
        });
      }
    });

    document.addEventListener('DOMContentLoaded', () => {
      const slideshow = document.querySelector('.slideshow-container');
      slideshow.setAttribute('content-type', 'tabindex', '0');
      slideshow.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowLeft') {
          changeSlide(-1);
        }
        if (event.key === 'ArrowRight') {
          changeSlide(1);
        }
      });
    }

    const sections = document.querySelectorAll('section');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          section.entry.target.style.opacity = '1';
          section.entry.target.style.transform = 'translateY(0)';
        }
      });
    }, { threshold: 0.1 });

    sections.forEach(section => {
      section.style.setProperty('opacity', '0');
      section.style.setProperty('transform', 'translateY(20px)');
      section.style.setProperty('transition', 'opacity 0.5s ease, transform 0.5s ease');
      observer.observe(section);
    }));
  </script>
</html>
