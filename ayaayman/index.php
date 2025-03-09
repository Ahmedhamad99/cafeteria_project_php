<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./CSS/main.css">
    <title>E-Commerce</title>
</head>
<body>
    <!-- =================== Header ==================== -->
    <header class="header" id="header">
      <nav class="nav-container">
          <a href="./index.html" class="nav-logo">
              <!-- <i class='bx bxs-store' ></i> -->
              <i class='bx bxs-store bx-spin bx-flip-horizontal' ></i>
              e-shop
          </a>
          <div class="nav-menu" id="nav-menu">
              <ul class="nav-list">
                  <li class="nav-item">
                      <a href="./index.html" class="nav-link active">Home</a>
                  </li>
                  <li class="nav-item">
                      <a href="#products" class="nav-link ">Shop</a>
                  </li>
                  <li class="nav-item">
                      <a href="#cart" class="nav-link " id="cartshow">Cart</a>
                      <!-- <a href="./Pages/cart.html" class="nav-link " id="cartshow">Cart</a> -->
                  </li>
                  <li class="nav-item">
                      <a href="#services" class="nav-link ">Services</a>
                  </li>
                  <li class="nav-item">
                      <a href="#about" class="nav-link">About Us</a>
                  </li>
                  <li class="nav-item">
                      <a href="#contact" class="nav-link ">Contact Us</a>
                  </li>
              </ul>
          </div>
          <div class="nav-btns">
              <div class="login-toggle">
                  <a href="../aya_salah/loginn.php"  alt="LogOut"><i class='bx bx-log-out-circle bx-tada' ></i></a>
              </div>
              <div class="nav-shop">
                  <i class='bx bxl-shopify'>
                      <span>0</span>
                  </i>
                  
              </div>
              <div class="nav-toggle">
                  <i class='bx bx-grid' ></i>
              </div>
          </div>
      </nav>
  </header>
    <!-- ============== Slider ================ -->
    <div class="container-fluid container-header d-flex justify-content-around font-Poppins " style="margin-top: 5rem;">
      <div class="content text-start align-content-center w-25" style="font-family:Poppins;">
        <p class=" text-muted fs-4" style="color:#493628;">Coffe🤎</p>
        <h1 class="" style="color:#493628;font-size:70px; line-height:70px;text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);">Welcome to our website</h1>
        <p class="  text-dark-emphasis">Your Drinks Are Made with Love and Care🤎</p>
        <button class="btn bord" style="background-color:#493628;color:#fff">Order Now</button>
      </div>
      <div class="content-img " style="overflow: hidden;">
        <img src="pro-bg.jpg" class="" style="width:500px;height:600px"/>
      </div>
    </div>
    
    
    <!--=============== Products ===============-->
    
    <div class="container-main mb-5" id="products">
        <h2 class="product-header">Our Products</h2>
        <div class="btns">
            <button type="button" value=" " class="filter-btn" id="all">All</button>
            <button type="button" value="9" class="filter-btn" id="clothes" styl="width=150px">Hot Drinks</button>
            <button type="button" value="4" class="filter-btn" id="shoes">Cold Drinks</button>
            <button type="button" value="5" class="filter-btn" id="shoes">Juice</button>
            <button type="button" value="7" class="filter-btn" id="shoes">Diserte</button>
            <button type="button" value="8" class="filter-btn" id="shoes">Tea</button>
            <button type="button" value="10" class="filter-btn" id="shoes">Salades</button>
        </div>
        <div class="listProduct">
            
           
        </div>
        <div class="more"></div>
    </div>
    
    <!--=============== CART ===============-->
    
    <div class="cartPage">
        <h1 class="title">Shopping Cart</h1>
        <div class="cart-list"></div>
        
        <div class="mb-3">
          <label for="note" class="form-label">Your Note</label>
          <textarea class="form-control" id="note"  placeholder="Write your special instructions here..." rows="3"></textarea>
        </div>
        <div class="dropdown" >
          <button id="roomDropdownBtn" class="btn btn-dark dropdown-toggle" style="width:100%; background-color:#fff;color:black" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Choose Room
          </button>
          <ul class="dropdown-menu">
              <li><button class="dropdown-item" type="button" data-room="Room 1">Room 1</button></li>
              <li><button class="dropdown-item" type="button" data-room="Room 2">Room 2</button></li>
              <li><button class="dropdown-item" type="button" data-room="Room 3">Room 3</button></li>
          </ul>
      </div>
      
        <div class="total-section">
            
        </div>
        <div class="btn">
            <button class="close">CLOSE</button>
            <!-- <button id="confirmOrder" class="confirm-btn">Confirm Order</button> -->

            <button class="checkOut" id="confirmOrder" class="confirm-btn"  ><a href="./Pages/endPage.html">Check Out</a></button>
        </div>
    </div>
    <!--=============== About ===============-->
    <section class="about" id="about">
        <section class="about-img">
          <img src="cofffff.jpg" alt="" style="width: 600px;">
        </section>
        <section class="about-content">
          <section class="about-cap">
            <h2>
              About our <br>
              Website e-Shop</h2>
              <p class="first-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros.</p>
              <p class="second-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare.</p>
              <button>more about us</button>
          </section>
        </section>
      </section>
    
      <!--=============== Services ===============-->
    <section class="service" id="services">
        <section class="service-header ">
        <h2>Why use our service?</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non sed ab optio vel repudiandae architecto.</p>
        </section>
        <section class="main-content">
            <section class="service">
                <i class='bx bxs-window-alt' ></i>
                <h3>Tailor Sweing</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in</p>
            </section>
            <section class="service">
                <i class='bx bx-windows'></i>
                <h3>Tailor Sweing</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in</p>
            </section>
            <section class="service">
                <i class='bx bx-eraser'></i>
                <h3>Tailor Sweing</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in</p>
            </section>
            <section class="service">
                <i class='bx bx-server'></i>
                <h3>Tailor Sweing</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in</p>
            </section>
            
        </section>
        
</section>
    
    <!-- ============== Contact Us =========== -->
    
    <section class="contact-section m-5 rounded overflow-hidden" id="contact" style="background-color:#fff;">
      <div class="row g-3 align-items-stretch" style="min-height: 500px;">
          <!-- Left: Image -->
          <div class="col-md-6">
              <img src="coffe-bg.jpeg" alt="Contact Us" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 100%;">
          </div>
  
          <!-- Right: Contact Form -->
          <div class="col-md-6 d-flex align-items-center p-5 bg-white">
              <div class="w-100">
                  <h3 class="mb-4 " style="color:#493628;">Get in Touch</h3>
                  <p class="fs-5">Contact us and we'll get back to you within 24 hours.</p>
  
                  <form>
                      <div class="row g-3">
                          <div class="col-md-6">
                              <label for="name" class="form-label">Name</label>
                              <input type="text" class="form-control" id="name" placeholder="Enter your name">
                          </div>
                          <div class="col-md-6">
                              <label for="email" class="form-label">Email</label>
                              <input type="email" class="form-control" id="email" placeholder="Enter your email">
                          </div>
                      </div>
                      <div class="my-3">
                          <label for="query" class="form-label">Message</label>
                          <textarea class="form-control" id="query" rows="4" placeholder="Write your message"></textarea>
                      </div>
                      <div class="text-end">
                          <button type="submit" class="btn px-4 fw-bold" style="background-color:#493628; color:#fff;">Send</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </section>
    
    
   
    
    
    
    <!--=============== FOOTER ===============-->
    <!-- Footer -->
  
  <!-- Footer -->

    <!--=============== SCROLL UP ===============-->
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class='bx bxs-up-arrow-alt bx-tada' ></i></button>
    <!--=============== STYLE SWITCHER ===============-->
    

    <!--=============== SWIPER JS ===============-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/swiper-bundle.min.js"></script>
    <script src="main.js"></script>
    
</body>
</html>

<?php

include("../nav_footer/footer.php")
?>