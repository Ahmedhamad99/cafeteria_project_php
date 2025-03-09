<?php
   
    try {
        $conn = new PDO("mysql:host=localhost:3307;dbname=cafeteria", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $productname = $_POST['productname'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_FILES['image']['name'];
    
        move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $image);
    
       
        $stmt = $conn->prepare("SELECT id FROM categories WHERE name = ?");
        $stmt->execute([$category]);
        $categoryRow = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($categoryRow) {
           
            $category_id = $categoryRow['id'];
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$category]);
            $category_id = $conn->lastInsertId(); 
        }
    
        $stmt = $conn->prepare("INSERT INTO products (name, price, image, category_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$productname, $price, $image, $category_id]);

        header("Location: ../ahmed/all_products.php");
        exit;
        
    
        
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
    
    $conn = null;
    ?>
    
