<?php
require "database.php";
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid request.");
}

$product_id = intval($_POST['id']);

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute(['id' => $product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

$cat_id = $product["category_id"];
$catogry = $pdo->prepare("SELECT * FROM categories WHERE id= :id");
$catogry->execute(['id' => $cat_id]);
$catogry_data = $catogry->fetch(PDO::FETCH_ASSOC);

?>
<?php include("../nav_footer/header.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     
<div style="margin-top:200px">

</div>
     <!-- <form action="update_product.php" method="post" enctype="multipart/form-data" class=>
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">

        <label for="name">Product Name</label><br>
        <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($product['name']); ?>" required><br><br>

        <label for="price">Price</label><br>
        <input type="text" class="form-control" name="price" id="price" value="<?= htmlspecialchars($product['price']); ?>" required><br><br>
        <label for="image">Image</label><br>
        <?php if (!empty($product['image'])): ?>
          <img class="img" src="images/<?= htmlspecialchars($product['image']); ?>" alt="Product Image" width="100">
        <?php endif; ?>
        <input type="file" name="image" class="form-control form-control-lg">
        
        <label for="category">Category</label><br>

        <input type="hidden" name="categid" value="<?= htmlspecialchars($cat_id)?>">
        <input type="text" name="category" id="category" class="form-control" value="<?= htmlspecialchars($catogry_data['name']); ?>" required><br><br>

        <button type="submit" class="btn btn-dark ">Update Product</button>
     </form> -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
     
     <div style="margin:100px">

     </div>
<div class="container mt-5 mb-5" >
    <div class="card shadow-lg p-4 rounded-3">
        <h3 class="text-center text-primary mb-4">Edit Product</h3>

        <form action="update_product.php" method="post" enctype="multipart/form-data" >
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Product Name</label>
                <input type="text" class="form-control" name="name" id="name" 
                       value="<?= htmlspecialchars($product['name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label fw-bold">Price</label>
                <input type="text" class="form-control" name="price" id="price" 
                       value="<?= htmlspecialchars($product['price']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label fw-bold">Product Image</label>
                <div class="mb-2">
                    <?php if (!empty($product['image'])): ?>
                        <img src="images/<?= htmlspecialchars($product['image']); ?>" 
                             class="img-thumbnail rounded shadow-sm" width="120" alt="Product Image">
                    <?php endif; ?>
                </div>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <label for="category" class="form-label fw-bold">Category</label>
                <input type="hidden" name="categid" value="<?= htmlspecialchars($cat_id) ?>">
                <input type="text" name="category" id="category" class="form-control" 
                       value="<?= htmlspecialchars($catogry_data['name']); ?>" required>
            </div>
            <p id="message" style="display: none; color: green; font-weight: bold; margin-top: 10px;">
                Your product has been updated!
            </p>
            <div class="d-grid">
                <button type="submit" class="btn btn-success fw-bold" >Update Product</button>
               
            </div>
        </form>
        <a class="btn btn-dark fw-bold mt-2" href="all_products.php">All Products</a>
    </div>
</div>
<div style="margin-bottom:520px">

    </div>

</body>
</html>

<?php include("../nav_footer/footer.php")?>