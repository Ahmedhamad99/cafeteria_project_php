


<?php
session_start();

$message = $_SESSION['message'] ?? ''; 

unset($_SESSION['message']); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display+SC:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="./login.css" rel="stylesheet">
    
 
</head>
<body>
    

    
<div class="container vh-100"  >
    <div class="login-box" style="height:500px">
        <div class="left">
            <h2>Log In</h2>
            <?php if (!empty($message)) : ?>
            <div class="alert alert-danger w-100 p-1"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form action="./login.php"  method="post">
                <label> Email</label>
                <input type="email" name="email"placeholder="Email" required id="Email">
                
                <label> User Password</label>
                <input type="password"name="password" placeholder="User Password" required id="Password">
                
                <button type="submit" id="logBtn" >Login</button>
                
                <p>Don't Have An Account? <a href="./register.html">Register</a></p>
            </form>
            <p id="message"></p>
        </div>
        <div class="right">
            <img src="https://images.unsplash.com/photo-1601907482852-9b02d7a8716f?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8Y3VwJTIwb2YlMjBjb2ZmZWV8ZW58MHx8MHx8fDA%3D" alt="">
        </div>
    </div>
</div>
<!--<script src="./login.js"></script>-->
</body>
</html>

