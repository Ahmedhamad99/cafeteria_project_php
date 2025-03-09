<?php
require "database.php";

$stmt = $pdo->prepare("SELECT * FROM users where role=:ad");
$user_ad = "admin";
$stmt->execute(['ad' => $user_ad]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($user);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link href="nav.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="nav.css">
    <title>Header</title>
   <style>
    nav div ul li a:hover{
    color:rgba(197, 135, 13, 0.61) !important;
}


nav div ul li  ul{
    background-color: #673ab7 !important;
}

#preloder {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999999;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    
}



.loader {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 4px solid #f44336;
    border-left-color: transparent;
    animation: loader 0.8s linear infinite;
}

@keyframes loader {
    0% {
        transform: rotate(0deg);
        border-color: #f44336;
        border-left-color: transparent;
    }
    50% {
        transform: rotate(180deg);
        border-color: #673ab7;
        border-left-color: transparent;
    }
    100% {
        transform: rotate(360deg);
        border-color: #f44336;
        border-left-color: transparent;
    }
}



nav section ul li a{
    color: white !important;
}


   </style>
</head>
<body style="background-color:RGB(238, 238, 238)">
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- <nav class="navbar navbar-expand-md navbar-light bg-sucsess px-3" style="background-color:rgba(220, 226, 213, 0.86);">
        <a class="navbar-brand" href="#"><img src="imagecofee/logo.png" alt="logo image" style="width: 100px; height:80px;"></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <section class="collapse navbar-collapse justify-content-between " style="margin-left:150px ;" id="navbarSupportedContent">
            <ul class="navbar-nav ">
                <li class="nav-item col-3"><a class="nav-link  active" style="" aria-current="page" href="#price">Home</a></li>
                <li class="nav-item col-3"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item col-3"><a class="nav-link" href="../html/product.html">Product</a></li>
                <li class="nav-item dropdown col-3">
                    <a class="nav-link dropdown-toggle" href="#" id="contactDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Contact
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="contactDropdown" style="background-color: #8aa0ea;">
                        <li><a class="dropdown-item" href="#footer">Email</a></li>
                        <li><a class="dropdown-item" href="#">Phone</a></li>
                        <li><a class="dropdown-item" href="#">Location</a></li>
                    </ul>
                </li>
                <li><a href="./cart.html" class="cart-icon"><i class="fa-solid fa-cart-plus"></i></a></li>
                <li class="nav-item col-2 ml-5"><h6 class="username nav-link"  style="margin-left: 30px;margin-right:30px; width: 100px; color: brown;"><?= print_r($user['username']);?></h6></li>
                <li class="nav-item col-2 ml-5"><img src="userimage/<?= $user['profile_picture']; ?>" alt="imageadmin" width="50px" height="50px" style="border-radius:50%" />
                </li>
                <li class="nav-item col-2 ml-5"><a href="./login.html" class="nav-link" style="margin-left: 20px;">logout</a></li>
                
            </ul>
    
    
        </section>
    </nav>  -->
    <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
    <div class="container-fluid d-flex align-items-center">
     
        <a class="navbar-brand me-auto" href="./index.php">☕ Coffee</a>

        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

       
        <div class="collapse navbar-collapse justify-content-center flex-grow-1" id="navbarNav">
            <ul class="navbar-nav fs-5 d-flex justify-content-center w-100">
                <li class="nav-item">
                    <a class="nav-link active" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./all_products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./all_users.php" id="cartshow">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Manual Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Checks</a>
                </li>
            </ul>
        </div>

        
        <div class="d-flex align-items-center ms-auto">
            <span class="me-2 text-brown fw-bold">
                <?= htmlspecialchars($user['username'] ?? '') ?>
            </span>
            <img src="userimage/<?= htmlspecialchars($user['profile_picture'] ?? '') ?>" 
                 alt="User Image" width="40" height="40" class="rounded-circle me-3">
            <a href="./Forms/login.php" class="btn btn-outline-danger">
                <i class='bx bx-log-out-circle'></i>
            </a>
        </div>
    </div>
</nav>

    <script src="nav/nav.js" defer></script>
</body>
</html>


