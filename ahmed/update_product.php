



<p>your product is edited</p>


<?php


require "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
        die("Invalid product ID.");
    }
    $product_id = intval($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $price = floatval($_POST['price']); 
    $namecategory = htmlspecialchars($_POST['category']);
    $cat_id =  intval($_POST["categid"]);

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image'];
        $image_name = basename($image["name"]);
        $image_path = "images/" . $image_name;
        if (!move_uploaded_file($image["tmp_name"], $image_path)) {
            die("Error uploading image.");
        }
        
    }
    else{
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $image_name=$data["image"];
    }
   
    
  
    $stmt = $pdo->prepare("UPDATE products SET name = :name, price = :price, image = :image WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'price' => $price,
        'id' => $product_id,
        'image'=>$image_name
    ]);
    $cat = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");

    $cat->execute([
        'name' => $namecategory,
        'id' => $cat_id
    ]);

    header("Location: all_products.php");

    
   
    exit();
}

?>
