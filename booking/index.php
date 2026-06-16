<?php
session_start();
?>

<!-- Floating Appointment Form - Available to all users -->
<div id="floatingForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000; background: white; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 8px; text-align: center;">
    <h3>Select Appointment Type</h3>
    <div style="display: flex; flex-direction: column; gap: 15px; padding-top: 35px;">
        <button onclick="window.location.href='appointmentForm.php'" class="btn">Appointment</button>
        <button onclick="window.location.href='walkinForm.php'" class="btn">Appointment (Walk-in)</button>
        <button onclick="closeFloatingForm()" class="btn" style="background-color: red; color: white;">Cancel</button>
    </div>
</div>


<!DOCTYPE html>
      <html lang="en">
      <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css"
      rel="stylesheet"

      />
      <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
       <link rel="stylesheet" href="styles.css" />
      <title>Appointment Management System</title>
      </head>
      
    <body>
      <header class="header">
      <nav>
      <div class="nav__bar">
      <div class="logo">
      <h1>EXE</h1>
      </div>
      <div class="nav__menu__btn" id="menu-btn">
      <i class="ri-menu-line"></i>
      </div>
      </div>
        <ul class="nav__links" id="nav-links">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#service">Services</a></li>
            <li><a href="#explore">Explore</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <button class="btn nav__btn" onclick="openFloatingForm()">Appoint Now</button>
      </nav>
      <div class="section__container header__container" id="home">
      <p class="curating-text">Curating your style -- one thread at a time</p>
      <h1 class="smooth-animated-text">Make Yourself At Home<br />In Our <span>Fashion Brand</span>.</h1>
    </div>
  </header>




      <section class="section__container about__container" id="about">
        <div class="about__image">
          <img src="image.avif" alt="about" />
      </div>
      <div class="about__content">
           <p class="section__subheader">ABOUT US</p>
                <h2 class="section__header">The Best Holidays Start Here!</h2>
                <p class="section__description">
      Book an appointment with our fashion experts for a personalized shopping experience. Enjoy tailored styling advice and exclusive access to our latest collections. Let us help you find the perfect pieces to elevate your wardrobe
      </p>
      <div class="about__btn">
      <button class="btn"><a href="readmore.php">Read More</a></button>
      </div>
      </div>
      </section>

    <section class="section__container room__container">
                   <p class="section__subheader">OUR COLLECTIONS</p>
               <h2 class="section__header">The Most Stylish Moments Begin Here.</h2>
        <div class="room__grid">
         <div class="room__card">
           <div class="room__card__image">
              <img src="oo.jpg" alt="Top seller" />
                 <div class="room__card__icons">
            <span><i class="ri-heart-fill"></i></span>
            <span><i class="ri-paint-fill"></i></span>
            <span><i class="ri-shield-star-line"></i></span>
        </div>
        </div>
            <div class="room__card__details">
              <h4>Deluxe Luxe Collection</h4>
                <p>
                Indulge in elegance with stunning designs that elevate your wardrobe.
                </p>


    </div>
    </div>
      <div class="room__card">
      <div class="room__card__image">
        <img src="mm.jpg" alt="New Arrival" />
        <div class="room__card__icons">
          <span><i class="ri-heart-fill"></i></span>
           <span><i class="ri-paint-fill"></i></span>
            <span><i class="ri-shield-star-line"></i></span>
      </div>
      </div>
      <div class="room__card__details">
      <h4>Executive Chic Collection</h4>
    <p>
    Embrace modern sophistication and comfort with urban-inspired pieces.
    </p>


    </div>
    </div>
      <div class="room__card">
      <div class="room__card__image">
      <img src="collection3.webp" alt="Top seller" />
        <div class="room__card__icons">
        <span><i class="ri-heart-fill"></i></span>
        <span><i class="ri-paint-fill"></i></span>
        <span><i class="ri-shield-star-line"></i></span>
      </div>
      </div>
      <div class="room__card__details">
        <h4>Family Style Retreat</h4>
    <p>
    Casual yet chic, perfect for making fashion memories with your loved ones.
    </p>


  </div>
  </div>
  </div>
  </section>

    <section class="service" id="service">
      <div class="section__container service__container">
        <div class="service__content">
        <p class="section__subheader">SERVICES</p>
        <h2 class="section__header">Strive Only For The Best.</h2>
        <ul class="service__list">
    <li>
    <span><i class="ri-shield-star-line"></i></span>
              Secured
        </li>
        <li>
        <span><i class="ri-24-hours-line"></i></span>
              Styling Assistance
        </li>
        <li>
        <span><i class="ri-headphone-line"></i></span>
              Exclusive Fashion Consultations
        </li>
        <li>
        <span><i class="ri-map-2-line"></i></span>
             Personal Shopper Support
    </li>
    </ul>
    </div>
    </div>
    </section>

    <section class="section__container banner__container">
      <div class="banner__content">
      <div class="banner__card">
        <h4>300+</h4>
            <p>New Collections Available</p>
          </div>
          <div class="banner__card">
            <h4>450+</h4>
            <p>Orders Completed</p>
          </div>
          <div class="banner__card">
         <h4>600+</h4>
           <p>Happy shoppers</p>
      </div>
      </div>
    </section>

    <section class="explore" id="explore">
      <p class="section__subheader">EXPLORE</p>
          <h2 class="section__header">What's New Today.</h2>
        <div class="explore__bg">
        <div class="explore__content">
              <p class="section__description">25th NOV 2024</p>
         <h4>A New Collection Is Available in Our Fashion Brand.<h4>
            <button class="btn">Continue</button>
        </div>
        </div>
        </section>

      <footer class="footer" id="contact">
   <div class="section__container footer__container">
      <div class="footer__col">
        <div class="logo">
         <div class="logo">
            <h1>Fashion brand</h1>
  </div>
  </div>
  <p class="section__description">
  Discover a world of comfort, luxury, and adventure as you explore our curated selection of fashion brands, making every moment of your shopping experience truly extraordinary.
  </p>
  <button class="btn nav__btn" onclick="openFloatingForm()">Appoint Now</button>
  </div>
    <div class="footer__col">
      <h4>QUICK LINKS</h4>
        <ul class="footer__links">
          <li><a href="#">Browse Collections</a></li>
          <li><a href="#">Special Offers & Discounts</a></li>
          <li><a href="#">Product Categories & Features</a></li> 
          <li><a href="#">Customer Reviews & Testimonials</a></li>
          <li><a href="#">Fashion Tips & Style Guides</a></li>
        </ul>
      </div>
      
    <div class="footer__col">
      <h4>OUR SERVICES</h4>
        <ul class="footer__links">
          <li><a href="#">Concierge Assistance</a></li>
          <li><a href="#">Flexible Shopping Options</a></li>
          <li><a href="#">Exclusive Brand Transfers</a></li>
          <li><a href="#">Wellness & Recreation</a></li>
  </ul>
  </div>
    <div class="footer__col"> 
      <h4>CONTACT US</h4>
        <ul class="footer__links">
          <li><a href="#">fashion brand@ info.com</a></li>
          </ul>
            <div class="footer__socials">
              <a href="#" target="_blank"><i class='bx bxl-github'></i></a>
              <a href="#"><i class='bx bxl-linkedin'></i></a>
              <a href="#"><i class='bx bxl-twitter'></i></a>
              <a href="#" target="_blank"><i class='bx bxl-facebook'></i></a>
        </div>
        </div>
        </div>
    <div class="footer__bar">
    Copyright © 2024 fashion brand. All rights reserved.
    </div>
    </footer>


    <script>
    function openFloatingForm() {
        document.getElementById('floatingForm').style.display = 'block';
    }

    function closeFloatingForm() {
        document.getElementById('floatingForm').style.display = 'none';
    }
  </script>
  <script src="main.js"></script>
  </body>
  </html>