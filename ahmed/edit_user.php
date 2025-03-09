<?php include("../nav_footer/header.php");?>

<?php
require "database.php";
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid request.");
}

$user_id = intval($_POST['id']);

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


// var_dump($user)
?>




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
<div class="container mt-5">
    <div class="card shadow-lg p-4 rounded-3">
        <h3 class="text-center text-primary mb-4">Edit User</h3>
     <form action="update_user.php" method="post" enctype="multipart/form-data" class=>
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">
         <div class="mb-3">
            <label for="name" class="form-label fw-bold">User Name</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($user['username']); ?>" required>

         </div>
        <div>
        <label for="price" class="form-label fw-bold">Email</label>
        <input type="text" class="form-control" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
        <label for="image" class="form-label fw-bold">Image</label>
        <div class="mb-2">
        <?php if (!empty($user['profile_picture'])): ?>
          <img class="img-thumbnail rounded shadow-sm" src="images/<?= htmlspecialchars($user['profile_picture']); ?>" alt="User Image" width="100" style="border-radius: 50%;">
        <?php endif; ?>

        </div>
        
        <input type="file" name="image" class="form-control ">

        </div>
        
        <div class="mb-3">
        <label for="password" class="form-label fw-bold">Password</label><br>

        <input type="text" class="form-control" name="password" value="<?= htmlspecialchars($user['password'])?>" >
        </div>
        <div class="d-grid">
        <button type="submit" class="btn btn-success fw-bold">Update</button>
            </div>

        
     </form>
     <a class="btn btn-dark fw-bold mt-2" href="all_users.php">All users</a>

    </div>
</div>
<div style="margin-bottom:520px">

</div>
</body>

</html>

<?php include("../nav_footer/footer.php")?>