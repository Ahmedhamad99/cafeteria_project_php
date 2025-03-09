<?php
require "database.php";

$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();



?>
<?php include("../nav_footer/header.php");?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
</head>
<body>
<div style="margin-top:200px">

</div>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <caption class="fs-3 fw-bold text-primary"><h3 class="text-primary">List of Users</h3></caption>
        <a class="btn btn-primary" href="../fatama/add_user.php">Add User</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center caption-top shadow-lg rounded-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr> 
                        <td><?= $user['id']; ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <img src="images/<?= htmlspecialchars($user['profile_picture']); ?>" 
                                 class="rounded-circle border border-2 shadow-sm" 
                                 width="50" height="50">
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <form action="edit_user.php" method="post">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">
                                    <button type="submit" class="btn btn-warning btn-sm px-3">Edit</button>
                                </form>
                                <form action="delete_user.php" method="post" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">
                                    <button type="submit" class="btn btn-danger btn-sm px-3">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

    </div>
    <div style="margin-bottom:520px">

    </div>
    
</body>
</html>
<?php include("../nav_footer/footer.php");?>