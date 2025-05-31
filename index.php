<?php
session_start();
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
    /* Custom styles for lively design */
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff7e6, #e0f7fa);
    }
    .sticky-header {
      background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
      transition: all 0.3s ease;
    }
    .hero-section {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://via.placeholder.com/1200x400?text=Helping+Hands+Joyful+Community') center/cover;
      background-attachment: fixed;
      animation: fadeIn 2s ease-in;
    }
    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }
    .project-card, .contact-form {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 15px;
    }
    .project-card:hover, .contact-form:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    .gallery-img {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border-radius: 10px;
    }
    .gallery-img:hover {
      transform: scale(1.1) rotate(2deg);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .btn-primary {
      background: linear-gradient(45deg, #ff6b6b, #ff8e53);
      transition: transform 0.2s ease;
    }
    .btn-primary:hover {
      transform: scale(1.1);
      background: linear-gradient(45deg, #ff8e53, #ff6b6b);
    }
    #lightbox {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      justify-content: center;
      align-items: center;
      z-index: 1000;
      animation: slideIn 0.5s ease;
    }
    #lightbox.active {
      display: flex;
    }
    @keyframes slideIn {
      0% { transform: translateY(50px); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
    }
    .hamburger div {
      background: white;
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
        animation: slideDown 0.3s ease;
      }
      @keyframes slideDown {
        0% { transform: translateY(-10px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
      }
      .hamburger {
        display: flex;
      }
    }
    .social-icon {
      transition: transform 0.3s ease;
      fill: white;
    }
    .social-icon:hover {
      transform: scale(1.3);
      fill: #ffeb3b;
    }
    footer {
      background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
      position: relative;
      z-index: 1;
    }
    .slideshow-container {
      position: relative;
      max-width: 1000px;
      margin: auto;
    }
    .slide {
      display: none;
      width: 100%;
      height: 400px;
      object-fit: cover;
      border-radius: 10px;
    }
    .slide.active {
      display: block;
      animation: fade 1s ease-in-out;
    }
    @keyframes fade {
      from { opacity: 0.4; }
      to { opacity: 1; }
    }
    .prev, .next {
      cursor: pointer;
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      width: auto;
      padding: 16px;
      color: white;
      font-weight: bold;
      font-size: 18px;
      transition: 0.3s ease;
      border-radius: 0 3px 3px 0;
      background-color: rgba(0,0,0,0.5);
    }
    .next {
      right: 0;
      border-radius: 3px 0 0 3px;
    }
    .prev:hover, .next:hover {
      background-color: rgba(0,0,0,0.8);
    }
    .dots {
      text-align: center;
      padding: 10px 0;
    }
    .dot {
      cursor: pointer;
      height: 15px;
      width: 15px;
      margin: 0 5px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      transition: background-color 0.3s ease;
    }
    .dot.active, .dot:hover {
      background-color: #ff6b6b;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="sticky-header text-white sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
      <a href="#home" aria-label="Helping Hands Pwani Home">
        <img src="images/helping-hands.jpg" alt="Helping Hands Pwani Logo" class="h-12 w-auto object-contain">
      </a>
      <div class="hamburger" onclick="toggleMenu()">
        <div></div><div></div><div></div>
      </div>
      <ul class="nav-links flex space-x-6 md:flex md:items-center">
        <li><a href="#home" class="hover:underline text-lg" aria-label="Home">Home</a></li>
        <li><a href="#about" class="hover:underline text-lg" aria-label="About Us">About</a></li>
        <li><a href="#projects" class="hover:underline text-lg" aria-label="Our Projects">Projects</a></li>
        <li><a href="#gallery" class="hover:underline text-lg" aria-label="Gallery">Gallery</a></li>
        <li><a href="#facebook-feed" class="hover:underline text-lg" aria-label="Facebook Feed">Facebook Feed</a></li>
        <li><a href="#contact" class="hover:underline text-lg" aria-label="Contact Us">Contact</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="upload.php" class="hover:underline text-lg" aria-label="Upload Image">Upload</a></li>
          <li><a href="logout.php" class="hover:underline text-lg" aria-label="Logout">Logout</a></li>
        <?php else: ?>
          <li><a href="login.html" class="hover:underline text-lg" aria-label="Login">Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <!-- Home Section -->
  <section id="home" class="hero-section h-96 flex items-center justify-center text-center text-white">
    <div class="bg-black bg-opacity-50 p-8 rounded-2xl animate-pulse">
      <h2 class="text-5xl font-bold mb-4">We are Helping Hands Pwani 
</h2>
      <p class="text-xl mb-6">Team Kazi & Accountability</p>
      <a href="#contact" class="btn-primary text-white px-6 py-3 rounded-full font-semibold">Get Involved</a>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">About Us</h2>
      <p class="text-lg text-gray-700 max-w-3xl mx-auto leading-relaxed">
      A registered NGO with the main aim of helping the orphans, restoration and building of worship
      houses and schools..feeding  the needy and helping the 
      less fortunate in the society. We empower while we help create centers around the projects we do.
      </p>
    </div>
  </section>

  <!-- Projects Section -->
  <section id="projects" class="bg-gradient-to-r from-yellow-100 to-blue-100 py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">Our Projects</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="project-card bg-white p-6 rounded-2xl shadow-lg">
          <h3 class="text-2xl font-semibold mb-2 text-orange-600">Education Program</h3>
          <p class="text-gray-600">Bringing free education and resources to children in rural areas, sparking curiosity and growth.</p>
        </div>
        <div class="project-card bg-white p-6 rounded-2xl shadow-lg">
          <h3 class="text-2xl font-semibold mb-2 text-blue-600">Healthcare Initiative</h3>
          <p class="text-gray-600">Mobile clinics spreading health and happiness with free checkups and treatments.</p>
        </div>
        <div class="project-card bg-white p-6 rounded-2xl shadow-lg">
          <h3 class="text-2xl font-semibold mb-2 text-green-600">Sustainable Farming</h3>
          <p class="text-gray-600">Training farmers in eco-friendly practices to nurture the earth and communities.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery Section -->
  <section id="gallery" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">Gallery</h2>
      <div class="slideshow-container" role="region" aria-label="Image Slideshow">
        <!-- Slides will be dynamically added via JavaScript -->
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
      <div class="max-w-lg mx-auto bg-white p-6 rounded-2xl shadow-lg">
        <div class="fb-post"
             data-href="https://www.facebook.com/share/v/18umVvUbPr/"
             data-width="500">
        </div>
        <p class="text-sm text-gray-600 text-center mt-4">
          Note: Replace the placeholder URL with the canonical URL (e.g., https://www.facebook.com/groups/452408605995410/posts/YourPostID/). Click the post's timestamp in the Group to copy the URL. Automatic updates are not possible in static HTML.
        </p>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="bg-gradient-to-r from-green-100 to-blue-100 py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-8 text-gray-800">Contact Us</h2>
      <div class="max-w-lg mx-auto">
        <p class="text-lg text-gray-700 mb-2">Email: <a href="mailto:info@helpinghands.org" class="text-orange-600 hover:underline">info@helpinghands.org</a></p>
        <p class="text-lg text-gray-700 mb-2">Phone: <a href="tel:+1234567890" class="text-orange-600 hover:underline">+123-456-7890</a></p>
        <p class="text-lg text-gray-700 mb-6">Address: 123 Community Lane, City, Country</p>
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
        <a href="https://facebook.com/groups/452408605995410/" class="social-icon" aria-label="Facebook">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
          </svg>
        </a>
        <a href="https://twitter.com" class="social-icon" aria-label="Twitter">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005 1.016-3.125 1.249-.897-.957-2.178-1.555-3.594-1.555-2.717 0-4.917 2.208-4.917 4.917 0 .385.045.757.127 1.115-4.083-.205-7.702-2.162-10.125-5.144-.424.729-.666 1.574-.666 2.475 0 1.708.869 3.216 2.188 4.099-.806-.026-1.566-.247-2.228-.616v.062c0 2.385 1.698 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.317 0-.626-.031-.928-.087.627 1.956 2.444 3.379 4.6 3.419-1.685 1.32-3.808 2.105-6.115 2.105-.398 0-.79-.023-1.175-.068 2.179 1.396 4.768 2.212 7.548 2.212 9.057 0 14.009-7.507 14.009-14.009 0-.213-.005-.425-.015-.636.961-.695 1.795-1.562 2.457-2.549z"/>
          </svg>
        </a>
        <a href="https://instagram.com" class="social-icon" aria-label="Instagram">
          <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.319 3.608 1.295.975.975 1.232 2.242 1.295 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.319 2.633-1.295 3.608-.975.975-2.242 1.232-3.608 1.295-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.319-3.608-1.295-.975-.975-1.232-2.242-1.295-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.319-2.633 1.295-3.608.975-.975 2.242-1.232 3.608-1.295 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.406.062-2.732.335-3.771 1.374-1.039 1.039-1.312 2.365-1.374 3.771-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.062 1.406.335 2.732 1.374 3.771 1.039 1.039 2.365 1.312 3.771 1.374 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.406-.062 2.732-.335 3.771-1.374 1.039-1.039 1.312-2.365 1.374-3.771.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.062-1.406-.335-2.732-1.374-3.771-1.039-1.039-2.365-1.312-3.771-1.374-1.28-.058-1.688-.072-4.947-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.441s.645 1.441 1.441 1.441 1.441-.645 1.441-1.441-.645-1.441-1.441-1.441z"/>
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
      const lightbox = document.getElementById('lightbox');
      lightbox.querySelector('img').src = src;
      lightbox.classList.add('active');
      lightbox.focus();
    }

    function closeLightbox() {
      const lightbox = document.getElementById('lightbox');
      lightbox.classList.remove('active');
    }

    // Form validation
    function validateForm(event) {
      event.preventDefault();
      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const message = document.getElementById('message').value;
      if (name && email && message) {
        alert('Form submitted (for demo purposes).');
      } else {
        alert('Please fill out all fields.');
      }
      return false; // Prevent actual submission in sandbox
    }

    // Keyboard accessibility for lightbox
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && document.getElementById('lightbox').classList.contains('active')) {
        closeLightbox();
      }
    });

    // Slideshow functionality
    let imageList = [];
    let currentSlide = 0;

    function initializeSlideshow() {
      const slideshowContainer = document.querySelector('.slideshow-container');
      const dotsContainer = document.querySelector('.dots');

      // Fetch images from database
      fetch('get_images.php')
        .then(response => response.json())
        .then(data => {
          imageList = data;
          if (imageList.length === 0) {
            const message = document.createElement('p');
            message.textContent = 'No images available.';
            message.className = 'text-center text-gray-600';
            slideshowContainer.appendChild(message);
            return;
          }

          // Create slides
          imageList.forEach((image, index) => {
            const img = document.createElement('img');
            img.src = image.path;
            img.alt = image.alt_text;
            img.className = 'slide gallery-img';
            img.setAttribute('loading', 'lazy');
            img.onclick = () => openLightbox(image.path);
            slideshowContainer.insertBefore(img, slideshowContainer.querySelector('.prev'));

            // Create dots
            const dot = document.createElement('span');
            dot.className = 'dot';
            dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
            dot.onclick = () => goToSlide(index);
            dotsContainer.appendChild(dot);
          });

          // Show first slide
          showSlide(currentSlide);
        })
        .catch(error => {
          console.error('Error fetching images:', error);
          const message = document.createElement('p');
          message.textContent = 'Error loading images.';
          message.className = 'text-center text-red-600';
          slideshowContainer.appendChild(message);
        });
    }

    function showSlide(index) {
      const slides = document.querySelectorAll('.slide');
      const dots = document.querySelectorAll('.dot');

      if (slides.length === 0) return;

      // Wrap around
      if (index >= slides.length) currentSlide = 0;
      if (index < 0) currentSlide = slides.length - 1;

      // Update slides and dots
      slides.forEach(slide => slide.classList.remove('active'));
      dots.forEach(dot => dot.classList.remove('active'));
      slides[currentSlide].classList.add('active');
      dots[currentSlide].classList.add('active');
    }

    function changeSlide(n) {
      currentSlide += n;
      showSlide(currentSlide);
    }

    function goToSlide(index) {
      currentSlide = index;
      showSlide(currentSlide);
    }

    // Auto-advance slideshow every 5 seconds
    setInterval(() => {
      changeSlide(1);
    }, 5000);

    // Initialize slideshow when DOM is loaded
    document.addEventListener('DOMContentLoaded', initializeSlideshow);

    // Keyboard accessibility for slideshow
    document.addEventListener('DOMContentLoaded', () => {
      const slideshow = document.querySelector('.slideshow-container');
      slideshow.setAttribute('tabindex', '0');
      slideshow.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') changeSlide(-1);
        if (e.key === 'ArrowRight') changeSlide(1);
      });
    });

    // Fade-in animation for sections on scroll
    const sections = document.querySelectorAll('section');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = 1;
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, { threshold: 0.1 });

    sections.forEach(section => {
      section.style.opacity = 0;
      section.style.transform = 'translateY(20px)';
      section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      observer.observe(section);
    });
  </script>
</body>
</html>