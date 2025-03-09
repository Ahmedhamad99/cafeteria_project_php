
<?php
include("../ahmed/database.php");

$stmt = $pdo->prepare("SELECT * FROM users WHERE role = :ad");
$stmt->execute(['ad' => "admin"]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($_POST)
?>

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
    <link rel="stylesheet" href="main.css">
    <title>E-Commerce</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

/*=========== Variables =========== */
:root {
    --header-height:3rem;
    --primary-color: #3498db;
    --title-color : #333;
    --text-color: #cac9c9;
    --body-color: #f4f4f4;
    --container-color: #fff;
    --shadow : rgba(0, 0, 0, 0.2);
    /* --first-color : #d83a3a; */
    --first-color : #865735;
    /* --first-color : #d1b6aa; */
    --bg-footer: #f7f7f7;
    /* ======= Font and Typeography ========= */
    --body-font:'Poppins', sans-serif;
    --biggest-font-size : 4rem;
    --h1-font-size:2.25rem;
    --h2-font-size:1.5rem;
    --h3-font-size:1.25rem;
    --normal-font-size : 1rem;
    --small-font-size : .875rem;
    --smaller-font-size : .81rem;

    /* ========= Font Weight ========== */
    --font-bold: 600;
    --font-meduim: 500;
    
}


* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
   
}
.grid{
    display: grid;
}
body{
    height: 190vh;
    margin: 0;
}
/*========== Container ============== */
.container {
    max-width: 968px;
    margin: 0 auto;
}
/*========== Header ============== */
.header {
    width: 100%;
    position: fixed;
    background-color: var(--container-color);
    top: 0;
    left: 0;
    z-index:99 ;
}
/*========== Nav ============== */
.nav-container {
    height: calc(var(--header-height) + 1.5rem) ;
    display: flex;
    justify-content: space-between;
    column-gap: 3rem;
    align-items: center;
    margin:0 auto;
}

.login-toggle,
.nav-logo,
.nav-shop,
.nav-toggle{
    color: var(--title-color);
}
.nav-logo{
    text-transform: lowercase;
    font-weight: var(--font-bold);
    font-size: 1.6rem;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center ;
    column-gap: .25rem;
    text-decoration: none;
    margin-left: 3rem;
}
.nav-logo i{
    font-size: 1.5rem;
    font-weight: var(--font-bold);
}

.nav-btns{
    display: flex;
    align-items: center;
    column-gap: 1rem;
    margin-right: 3rem;
    
}
.nav-toggle,
.login-toggle ,
.nav-shop{
    font-size: 2.25rem;
    cursor: pointer;
}
.nav-menu .nav-list{   
    display: flex;
    align-items: center;
    column-gap: 2rem;
    list-style: none;
}
.nav-link{
    text-decoration: none;
    color: var(--title-color);
    font-size: var(--font-meduim);
    font-weight: var(--normal-font-size);
    transition: 0.3s;
}
.nav-item a{
    font-weight: var(--font-meduim);
    font-size: 1.3rem;
}
.login-toggle a {
    color: #000;
}
.nav-link:hover,
.nav-toggle:hover,
.login-toggle a i:hover ,
.nav-shop:hover,
.nav-logo:hover{
    color: var(--first-color);
}
.nav-toggle{
    display: none;
}
.active{
    color: var(--first-color);
}
/* ============ Span in Cart ==================== */
.nav-shop{
    position: relative;
}
.nav-btns .nav-shop i span{   
    position: absolute;
    display: flex;
    width: 20px;
    height: 20px;
    background-color: var(--first-color);
    color: var(--container-color);
    border-radius: 50%;
    top: 50%;
    right: -13px;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    font-weight: var(--font-meduim);
}
/* ========= Container Header ============== */
/* .container-header{
    margin-top: 10rem;
} */
/* ============ Product==================  */
.container-main{
    width: 1100px;
    /* margin-top: 4rem; */
    margin: auto;
    max-width: 90vw;
    text-align: center;
    padding-top: 10px;
    transition: transform .5s;
    margin-top: 7rem;
}
.container-main .product-header
{
    font-weight: 500;
    font-size: 50px;
    margin: 2rem;
    color: var(--first-color);
    letter-spacing: 3px;
    text-align: center;
}
.title{
    font-size: xx-large;
}
.listProduct .item img{
    width: 95%;
    height: 200px;
    border-radius: 5px;
    /* filter: drop-shadow(0 50px 20px #0009); */
}
.listProduct{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 6rem ;
}
.listProduct .item{
    background-color: #EEEEE6;
    padding: 20px;
    border-radius: 20px;
   
}
.listProduct .item h2{
    font-weight: 500;
    font-size: large;
}
.listProduct .item .price{
    letter-spacing: 7px;
    font-size: small;
}
.container-main .btns{
    display: flex;
}
.btns a{
    margin: auto;
}
.btns button{
    width: 100px;
    margin: auto;
    background-color: var(--text-color);
    color: var(--title-color);
    font-weight: var(--font-meduim);
    border: none;
    padding: 5px 10px;
    margin: 3rem 0;
    border-radius: 20px;
    cursor: pointer;
}
.listProduct .item button{
    background-color: var(--text-color);
    color: var(--title-color);
    font-weight: var(--font-meduim);
    border: none;
    padding: 5px 10px;
    margin-top: 10px;
    border-radius: 20px;
    cursor: pointer;
}
.listProduct .item button:hover,
.btns button:hover{
    background-color: var(--first-color);
    color: var(--container-color);
    transition: 0.3s;
    transform: scale(1.1);
}
/* ============== Cart Page ============== */

.cartPage {
    width: 500px;
    max-width: 90%;
    background-color: #353432;
    color: #eee;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
    z-index: 1000;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    opacity: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
}

body.showCart .cartPage {
    transform: translate(-50%, -50%) scale(1);
    opacity: 1;
}

.cartPage h1 {
    margin-bottom: 15px;
    text-align: center;
}

.cart-list {
    max-height: 300px;
    overflow-y: auto;
}

.cart-list .item {
    display: flex;
    align-items: center;
    gap: 30px;
    padding: 10px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.cart-list .item img {
    width: 50px;
    height: 50px;
    border-radius: 5px;
}

.cart-list .quantity span {
    display: inline-block;
    width: 25px;
    height: 25px;
    background-color: #eee;
    border-radius: 50%;
    color: #555;
    cursor: pointer;
    text-align: center;
    line-height: 25px;
    font-weight: bold;
}

.total-section {
    padding: 20px;
    font-size: 18px;
    font-weight: bold;
    background-color: #f8f9fa;
    color: #333;
    margin-top: 10px;
    text-align: center;
    border-radius: 5px;
}


.mainprice {
    color: #000;
}

.cartPage .btn {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.cartPage button {
    width: 48%;
    padding: 10px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
}

.cartPage .checkOut {
    color: white;
}
.cartPage .checkOut a{
    text-decoration: none;
    color: var(--first-color);
}
.cartPage .close {
    background-color: var(--first-color);
    color: var(--container-color);
}

.cart-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
}

body.showCart .cart-overlay {
    display: block;
}

@media only screen and (max-width: 992px) {
    .listProduct{
        grid-template-columns: repeat(3, 1fr);
    }
}


/* mobile */
@media only screen and (max-width: 768px) {
    .listProduct{
        grid-template-columns: repeat(2, 1fr);
    }
}
/* =========== Details Section ================*/
/* .container-details{
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    overflow: hidden;
}
.product-details{
    text-align: center;
    background-color: #ffffff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    animation: fadeIn 1.5s ease-in-out;
    transition: transform 0.5s ease, box-shadow 0.5s ease;

}
.product-details:hover{
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
} */

/* =========== Scroll up ================*/
#myBtn {
    display: none;
    position: fixed;
    bottom: 15px;
    right: 15px;
    z-index: 100;
    font-size: 14px;
    border: none;
    outline: none;
    background-color: var(--first-color);
    color: var(--container-color);
    cursor: pointer;
    padding: 10px;
    border-radius: 50%;
     
  }
  #myBtn i{
    font-size: 40px;
    color:var(--container-color);
    transition: color 0.2s;
  }
  #myBtn:hover {
    background-color: var(--container-color);
    border : 1px solid var(--first-color);
    transition: 0.2s;
    
  }
  #myBtn i:hover{
    color: var(--first-color) ;
    transition: 0.2s;
  }

/* ================ Slider ============ */
.slider {
    width: 100%; 
    height: 500px; 
    overflow: hidden;
    position: relative;
    display: flex;
}

.img-box {
    width: 100%;
    height: 100%;
}

.slides_image {
    width: 100%;
    height: 100%; 
    object-fit: cover; 
    display: block;
}
.dots-container {
    text-align: center;
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
}

.dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    margin: 5px;
    background-color: #bbb;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.dot.active {
    background-color: #614436; 
    width: 14px;
    height: 14px;
}
/* =============== Footer =============== */
footer{
    width: 100%;
    height: auto;
    background-color: var(--bg-footer);
  
    position: fixed;
    bottom:0;
    
}
footer .footer-container{
    width: 80%;
    height: 100%;
    padding-top: 3rem ;
    margin: 0 auto;
    display: block;
}
.footer-container .content-container{
    width: 100%;
    height: 80%;
    display: flex;
    justify-content: space-between;
    padding: 2rem 0;
}
.footer-container .content-container .content-left{
    width: 30%;
    height: 100%;
    text-align: left;
    /* line-height: 60px; */
    color: #808086;
}
.footer-container .content-container .content-left .text{
    font-size: 20px;
    font-weight: 400;
    padding-top: 1.5rem;
}
.footer-container .content-container .content-left .text p{
    padding: 0.5rem 0;
}
.footer-container .content-container .content-left .icons-media {
    font-size: 20px;
    font-weight: 400;
    margin-top: 3rem;
}
.footer-container .content-container .content-left .icons-media a img{
    width: 30px;
    font-weight: 400;
    margin-top: 1rem;
    text-decoration: none;
}
.footer-container .content-container .content-left .icons-media a{
    text-decoration: none;
}
.footer-container .content-container .content-right{
    width: 50%;
    height: 100%;
    display: flex;
    line-height: 40px;
    justify-content: space-around;
}
.footer-container .content-container .content-right .about-footer,
.footer-container .content-container .content-right .offer,
.footer-container .content-container .content-right .support{
    width: 18%;
    /* margin-right:2rem; */
}

.footer-container .content-container .content-right .about-footer h5,
.footer-container .content-container .content-right .offer h5 ,
.footer-container .content-container .content-right .support h5 {
    font-size: 20px;
    text-transform: capitalize;
    font-weight: 500;
    color: var(--first-color);
    
}
.footer-container .content-container .content-right .about-footer ul,
.footer-container .content-container .content-right .offer ul,
.footer-container .content-container .content-right .support ul {
    list-style: none;
}
.footer-container .content-container .content-right .about-footer .links-about li a,
.footer-container .content-container .content-right .offer .links-offer li a,
.footer-container .content-container .content-right .support .links-support li a{
    text-decoration: none;
    color: #808086;
    font-size: 20px;
    font-weight: 400;
    opacity: 0.7;
}
.footer-container  .content-bottom{
    width: 100%;
    height: 10%;
    display: flex;
    justify-content: space-between;
}
.footer-container  .content-bottom .left ,
.footer-container  .content-bottom .right {
    font-family: 300;
    font-size: 15px;
    color: var(--first-color);
    padding: 3rem 0 1rem;
    /* margin-right: 3rem; */
}
.footer-container  .content-bottom .right{
    text-align: right;
    margin-right: 1.2rem;
}

/* ============ Services ============ */
.service{
    position: relative;
    width :90%;
    margin: 7rem auto;
    height: 500px;
    /* padding: 100px 0px; */
  }
  .service .service-header{
    position: absolute;
    text-align: center;
    width: 50%;
    height: 40px;
    left: 25%;
    
  }
  .service .service-header h2{
    font-size: 53px;
    color: var(--first-color);
  }
  .service .service-header p{
    font-weight: 500;
    font-size: 18px;
    color: #808086;
    margin-top: 1rem;
  }
  .service .main-content{
    display: flex;
    /* margin-left: 4rem; */
    top: 4rem;
    position: absolute;
    left: 5%;
    justify-content: center;
    
  }
  .service .main-content i{
    color: var(--first-color);
    font-size: 50px;
    margin-top: 1rem;
    margin-left: 4.3rem ;
  }
  .service .main-content h3{
    font-size: 25px;
    color: rgb(114, 82, 59);
    margin-left: 1.3rem;
  }
  .service .main-content p{
    font-size: 18px;
    color: #808086;
    line-height: 60px;
  }

  @keyframes showservice{
    from{
      transform: translateY(100px);
      opacity: 0;
    }
    to{
      transform: translateY(0px);
      opacity: 1;
    }
  }
/* ========= About ============== */

.about {
    width: 85%;
    margin: auto;
    position: relative;
    height: 800px;
  }
  
  .about-img {
    position: absolute;
    z-index: 3;
    top: 15%;
  
  }
  
  .about-img img {
    width: 660px;
    height: 570px;
  }
  
  .about .about-content {
    width: 70%;
    position: absolute;
    background-color:rgb(114, 82, 59);
    color:#fff;
    right: 0;
    height: 100%;
  }
  
  .about-content .about-cap {
    position: absolute;
    top: 25%;
    left: 38%;
    width: 60%;
  }
  
  .about-cap h2 {
    font-size:
      56px;
    line-height:
      67.2px;
    font-weight:
      600
  }
  
  .about-cap .first-p {
    font-size:
      18px;
    line-height:
      30.6px;
    color:#fff;
    width: 80%;
    margin-bottom: 15px;
  }
  
  .about-cap .second-p {
    font-size:
      14px;
    line-height:
      30px;
    color: #fff;
    width: 80%;
  }
  
.about-cap button {
    display: inline-block;
    /* background-color: #493628;
    color: #fff; */
    background-color: #fff;
    color: #493628;
    text-transform: uppercase;
    padding: 25px 60px;
    border: none;
    margin-top: 30px;
    font-weight:700;
  
}
/* ======== product Details ============== */
/* Product Details Container */
.container-main .list-Product {
    max-width: 1000px;
    width: 90%;
    margin: 40px auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

/* Product Card */
.div-main {
    width: 500px;
    background-color: var(--first-color);
    padding: 50px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.div-main:hover {
    transform: translateY(-5px);
}

/* Product Image */
.list-Product .div-main img {
    width: 70%;
    max-width: 400px;
    border-radius: 15px;
    filter: drop-shadow(0 15px 20px rgba(0, 0, 0, 0.3));
    transition: transform 0.3s ease-in-out;
}

.list-Product .div-main img:hover {
    transform: scale(1.05);
}

/* Product Title */
.div-main h2 {
    font-weight: 600;
    font-size: 1.8rem;
    color: var(--title-color);
    margin: 15px 0;
}

/* Product Price */
.div-main .price {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--container-color);
    letter-spacing: 2px;
    margin-bottom: 15px;
}

/* Add to Cart Button */
.btn-cart-product {
    background-color: var(--container-color);
    color: var(--first-color);
    font-weight: var(--font-medium);
    border: none;
    padding: 10px 20px;
    margin-top: 15px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease-in-out;
}

.btn-cart-product:hover {
    background-color: var(--container-color);
    color: var(--first-color);
    transform: scale(1.08);
    font-weight:500;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .div-main {
        padding: 20px;
    }

    .div-main h2 {
        font-size: 1.5rem;
    }

    .div-main .price {
        font-size: 1rem;
    }

    .btn-cart-product {
        padding: 8px 15px;
        font-size: 0.9rem;
    }
}
/* ========Contact ========= */
.contact{
    margin: 20px 0;
}
html, body {
    
   
}

footer {
    width: 100%;
    position: relative;
    margin: 0;
    background-color: #f8f9fa; /* Adjust if needed */
    color: #493628;
    text-align: center;
    padding: 10px 0;
}



    </style>
</head>


<header class="header" id="header">
        <nav class="nav-container">
            <a href="./index.php" class="nav-logo" >
                <!-- <i class='bx bxs-store' ></i> -->
                <!-- <i class='bx bxs-store bx-spin bx-flip-horizontal' ></i>
                e-Coffe -->
                ☕Coffee
            </a>
            <div class="nav-menu" id="nav-menu">
                <ul class="nav-list">
                    <!-- <li class="nav-item" >
                        <a href="../abdalla/index.php" class="nav-link active" >Home</a>
                    </li> -->
                    <li class="nav-item">
                        <a href="../ahmed/all_products.php" class="nav-link ">Products</a>
                    </li>
                    <li class="nav-item">
                        <a href="../ahmed/all_users.php" class="nav-link " id="cartshow">Users</a>
                        <!-- <a href="./Pages/cart.php" class="nav-link " id="cartshow">Cart</a> -->
                    </li>
                    <li class="nav-item">
                        <a href="../abdalla/index.php" class="nav-link ">Manual Orders</a>
                    </li>
                    <li class="nav-item">
                        <a href="../amr/AdminChecks.php" class="nav-link">Checks</a>
                    </li>
                    <li class="nav-item">
                        <a href="../amr/AdminOrders.php" class="nav-link ">Orders</a>
                    </li>
                </ul>
            </div>
            <div class="nav-shop">
            <img  src="../ahmed/images/<?= htmlspecialchars($user['profile_picture']); ?>" alt="User Image" width="50" height="50" style="border-radius: 50%;">

                    
                </div> 
            <div class="nav-btns">
                 <div class="nav-sh">
                    <h5><?= $user['username']; ?></h5>
                </div> 
              
                <div class="login-toggle">
                    <!-- <a href="./Forms/login.php"  ><i class='bx bx-log-out-circle'><span></span></i></a> -->
                    <a href="../aya_salah/loginn.php"  alt="LogOut"><i class='bx bx-log-out-circle bx-tada' ></i></a>
                </div>
               
            </div>
        </nav>
</header>


