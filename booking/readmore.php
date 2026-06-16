<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <title>Read More Page</title>
  <style>
    /* General Reset and Fonts */
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      line-height: 1.6;
      color: #fff;
      background: url(https://www.shutterstock.com/image-photo/beautiful-female-wardrobe-party-dresses-600nw-2008887053.jpg) no-repeat center center/cover;
      background-size: cover;
      position: relative;
    }

    /* Remove or reduce white overlay */
    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.3); /* Dark overlay for contrast */
      z-index: -1;
    }

    /* Header and Navigation */
    .header {
      background-color: rgba(0, 0, 0, 0.6);
      color: #fff;
      padding: 1rem 2rem;
      position: sticky;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      animation: slideInDown 1s ease;
    }

    .nav__bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 600;
      color: #7FC15E;
    }

    .nav__menu__btn {
      display: none;
      font-size: 1.5rem;
      background: none;
      border: none;
      color: #fff;
      cursor: pointer;
    }

    .nav__links {
      list-style: none;
      display: flex;
      gap: 1.5rem;
    }

    .nav__links a {
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      transition: color 0.3s, transform 0.3s;
    }

    .nav__links a:hover {
      color: #7FC15E;
      transform: scale(1.1);
    }

    /* Responsive Navigation */
    @media (max-width: 768px) {
      .nav__menu__btn {
        display: block;
      }

      .nav__links {
        flex-direction: column;
        background-color: rgba(0, 0, 0, 0.8);
        position: absolute;
        top: 100%;
        right: 0;
        width: 100%;
        display: none;
      }

      .nav__links.active {
        display: flex;
      }
    }

    /* Main Section */
    .section__container {
      max-width: 1200px;
      margin: 3rem auto;
      padding: 0 1rem;
      text-align: center;
      color: #fff;
      animation: fadeIn 1.5s ease-in-out;
    }

    .section__header {
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #fff;
      text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.6);
    }

    .section__description {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      color: #ddd;
    }

    /* Read More Content */
    .read-more__content article {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s ease-in-out;
      text-align: left;
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 1.5rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .read-more__content article.show {
      max-height: 1000px;
    }

    .read-more-btn {
      background-color: #7FC15E;
      color: #fff;
      border: none;
      padding: 0.8rem 1.5rem;
      font-size: 1rem;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s, transform 0.3s;
      animation: bounceIn 1s;
    }

    .read-more-btn:hover {
      background-color: #679C4E;
      transform: scale(1.05);
    }

    /* Image Addition */
    .section__image {
      margin-top: 2rem;
      text-align: center;
    }

    .section__image img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
      animation: fadeIn 1.5s ease-in-out;
    }

    /* Footer */
    .footer {
      background-color: rgba(0, 0, 0, 0.6);
      color: #ddd;
      text-align: center;
      padding: 1rem;
      margin-top: 2rem;
      font-size: 0.9rem;
    }

    .footer__container a {
      color: #7FC15E;
      text-decoration: none;
    }

    .footer__container a:hover {
      color: #679C4E;
    }

    /* Animations */
    @keyframes slideInDown {
      from {
        transform: translateY(-100%);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes bounceIn {
      0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
      }
      40% {
        transform: translateY(-20px);
      }
      60% {
        transform: translateY(-10px);
      }
    }
  </style>
</head>
<body>
  <header class="header">
    <nav class="nav__bar">
      <div class="logo">Fashion Brand</div>
      <button class="nav__menu__btn" id="menuButton">☰</button>
      <ul class="nav__links" id="navLinks">
        <li><a href="index.php">Home</a></li>
        <li><a href="index.phh">About</a></li>
        <li><a href="index.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <section class="section__container">
    <h1 class="section__header">Explore More About Our Fashion Brand</h1>
    <p class="section__description">Discover the essence of our fashion brand and why we stand out in the industry. We offer a unique blend of style, quality, and innovation that resonates with fashion-forward individuals.</p>

    <div class="section__image">
      <img src="background.webp" alt="Fashion Showcase">
    </div>

    <div class="read-more__content">
      <article>
        <h2 class="section__subheader">Detailed Overview</h2>
        <p>Our fashion brand is built on a commitment to excellence, providing pieces that are not only trendy but also timeless. With a focus on premium fabrics, sustainable practices, and cutting-edge designs, we create collections that elevate your wardrobe for any occasion.</p>

        <h2 class="section__subheader">Unique Features</h2>
        <ul>
          <li>Exclusive Designs: Crafted with creativity and individuality.</li>
          <li>Sustainability: Eco-friendly materials and ethical processes.</li>
          <li>Customizable Options: Personalize your wardrobe with made-to-order options.</li>
        </ul>

        <h2 class="section__subheader">Contact Us for More Information</h2>
        <p>For inquiries or to learn more about our latest collections, reach out via email or phone. We are here to offer personalized fashion advice.</p>
      </article>
      <button class="read-more-btn" id="toggleButton">Read More</button>
    </div>
  </section>

  <footer class="footer">
    <div class="footer__container">
      <p>© 2024 MyBrand. All rights reserved. <a href="#">Privacy Policy</a></p>
    </div>
  </footer>

  <script>
    // Toggle Navigation Menu
    const menuButton = document.getElementById('menuButton');
    const navLinks = document.getElementById('navLinks');

    menuButton.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });

    // Toggle Read More Content
    const toggleButton = document.getElementById('toggleButton');
    const content = document.querySelector('.read-more__content article');

    toggleButton.addEventListener('click', () => {
      content.classList.toggle('show');
      toggleButton.textContent = content.classList.contains('show') ? 'Read Less' : 'Read More';
    });
  </script>
</body>
</html>
