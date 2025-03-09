<?php


include("database.php");

$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<?php include("../nav_footer/header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
            margin-top: 100px;
        }
        .table img {
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            transition: 0.3s;
        }
        .btn-sm {
            min-width: 80px;
        }
        footer {
            margin-bottom: 0 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary fw-bold">List of Products</h3>
            <a class="btn btn-primary" href="../fatama/add-product.php">Add Product</a>
        </div> 

        <div class="table-responsive shadow-lg rounded-3">
            <table class="table table-striped table-hover align-middle text-center caption-top">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th style="width: 250px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id']; ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($product['name']); ?></td>
                            <td class="text-success fw-bold">$<?= number_format($product['price'], 2); ?></td>
                            <td>
                                <img src="images/<?= htmlspecialchars($product['image']); ?>" width="100px" height="100px">
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="edit_products.php" method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">
                                        <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                    </form>
                                    <form action="delete_product.php" method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include("../nav_footer/footer.php"); ?>
</body>
</html>
