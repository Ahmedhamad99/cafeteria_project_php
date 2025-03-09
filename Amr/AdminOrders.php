<?php
session_start();

// Database connection
$DBName = "project";
$host = "localhost";
$DBtype = "mysql";
$userName = "root";
$userPassword = "";

// Function to get database connection
function getConnection() {
    global $DBName, $host, $DBtype, $userName, $userPassword;
    
    try {
        $connection = new PDO("$DBtype:host=$host;dbname=$DBName", $userName, $userPassword);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit();
    }
}

// Function to get all active orders (with optional user filter)
function getActiveOrders($userId = null) {
    $connection = getConnection();
    $sql = "SELECT o.id, o.created_at as date, u.id as user_id, u.username as name, r.room_number as room, 
           o.total_price, o.status
           FROM orders o
           JOIN users u ON o.user_id = u.id
           JOIN rooms r ON o.room_id = r.id
           WHERE o.status != 'Done'";
           
    if ($userId) {
        $sql .= " AND u.id = :userId";
    }
    
    $sql .= " ORDER BY o.created_at DESC";
    
    $stmt = $connection->prepare($sql);
    
    if ($userId) {
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get order items
function getOrderItems($orderId) {
    $connection = getConnection();
    $sql = "SELECT p.id, p.name, p.price, oi.quantity, (p.price * oi.quantity) as item_total
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :orderId";
    
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to update order status
function updateOrderStatus($orderId, $status) {
    $connection = getConnection();
    $sql = "UPDATE orders SET status = :status WHERE id = :id";
    
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
    
    return $stmt->execute();
}

// Function to get all users
function getAllUsers() {
    $connection = getConnection();
    $sql = "SELECT id, username FROM users ORDER BY username ASC";
    
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get order details (for detailed view)
function getOrderDetails($orderId) {
    $connection = getConnection();
    $sql = "SELECT o.id, o.created_at as date, u.username as name, r.room_number as room, 
           o.total_price, o.status, u.email, u.phone
           FROM orders o
           JOIN users u ON o.user_id = u.id
           JOIN rooms r ON o.room_id = r.id
           WHERE o.id = :orderId";
    
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle status update if form is submitted
if (isset($_POST['order_id']) && isset($_POST['status'])) {
    updateOrderStatus($_POST['order_id'], $_POST['status']);
    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF'] . (isset($_GET['user_id']) ? "?user_id=" . $_GET['user_id'] : ""));
    exit();
}

// Get user filter if set
$filteredUserId = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

// Get selected order for detailed view
$selectedOrderId = isset($_GET['order_id']) ? intval($_GET['order_id']) : null;
$orderDetails = null;
$orderItems = null;

if ($selectedOrderId) {
    $orderDetails = getOrderDetails($selectedOrderId);
    $orderItems = getOrderItems($selectedOrderId);
}

// Get all users for filter dropdown
$users = getAllUsers();

// Get orders based on filter
$activeOrders = getActiveOrders($filteredUserId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .nav-links {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .nav-links a {
            margin-right: 15px;
            text-decoration: none;
            color: #0d6efd;
        }
        .order-container {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .order-container:hover {
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .order-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .order-items {
            display: flex;
            gap: 10px;
            padding: 15px;
            flex-wrap: wrap;
        }
        .item {
            text-align: center;
            width: 70px;
        }
        .item-icon {
            background-color: #f8f9fa;
            border-radius: 50%;
            padding: 10px;
            display: inline-block;
            margin-bottom: 5px;
        }
        .total {
            text-align: right;
            padding: 10px 15px;
            font-weight: bold;
        }
        .detail-card {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .detail-header {
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        .detail-body {
            padding: 15px;
        }
        .status-processing {
            background-color: #fff3cd;
        }
        .status-out-for-delivery {
            background-color: #cfe2ff;
        }
        .status-done {
            background-color: #d1e7dd;
        }
    </style>
</head>
<body>
<div class="container mt-3">
    <!-- Navigation -->
    <div class="nav-links mb-3">
    <a href="index.php"><i class="fas fa-home"></i> Home</a>
        <a href="products.php"><i class="fas fa-coffee"></i> Products</a>
        <a href="users.php"><i class="fas fa-users"></i> Users</a>
        <a href="AdminOrders.php"><i class="fas fa-shopping-cart"></i> Manual Order</a>
        <a href="AdminChecks.php" class="active"><i class="fas fa-receipt"></i> Checks</a>
        <span class="float-end"><i class="fas fa-user-shield"></i> Admin</span>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Orders</h2>
        </div>
        <div class="col-md-4">
            <form method="get" class="d-flex">
                <select name="user_id" class="form-select me-2">
                    <option value="">All Users</option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo ($filteredUserId == $user['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($user['username']); ?>
                        </option>
                    <?php } ?>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <?php if ($filteredUserId) { ?>
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-outline-secondary ms-2">Clear</a>
                <?php } ?>
            </form>
        </div>
    </div>
    
    <?php if ($selectedOrderId && $orderDetails) { ?>
        <!-- Detailed Order View -->
        <div class="mb-4">
            <a href="<?php echo $_SERVER['PHP_SELF'] . (isset($_GET['user_id']) ? "?user_id=" . $_GET['user_id'] : ""); ?>" class="btn btn-outline-secondary mb-3">
                &larr; Back to Orders
            </a>
            
            <div class="detail-card">
                <div class="detail-header">
                    <h4>Order #<?php echo $orderDetails['id']; ?> Details</h4>
                    <div class="badge bg-<?php echo ($orderDetails['status'] == 'Processing') ? 'warning' : (($orderDetails['status'] == 'Out for Delivery') ? 'primary' : 'success'); ?>">
                        <?php echo $orderDetails['status']; ?>
                    </div>
                </div>
                <div class="detail-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Customer Information</h5>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($orderDetails['name']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($orderDetails['email'] ?? 'N/A'); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($orderDetails['phone'] ?? 'N/A'); ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5>Order Information</h5>
                            <p><strong>Order Date:</strong> <?php echo date('Y/m/d h:i A', strtotime($orderDetails['date'])); ?></p>
                            <p><strong>Room:</strong> <?php echo htmlspecialchars($orderDetails['room']); ?></p>
                            <p><strong>Extension:</strong> 6506</p>
                        </div>
                    </div>
                    
                    <h5>Order Items</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            foreach ($orderItems as $item) { 
                                $total += $item['item_total'];
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td>EGP <?php echo number_format($item['price'], 2); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td class="text-end">EGP <?php echo number_format($item['item_total'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th class="text-end">EGP <?php echo number_format($total, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    
                    <div class="mt-4">
                        <h5>Update Status</h5>
                        <form method="post" class="d-flex align-items-center">
                            <input type="hidden" name="order_id" value="<?php echo $orderDetails['id']; ?>">
                            <select name="status" class="form-select me-2" style="max-width: 200px;">
                                <option value="Processing" <?php echo $orderDetails['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="Out for Delivery" <?php echo $orderDetails['status'] == 'Out for Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>
                                <option value="Done" <?php echo $orderDetails['status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <!-- Orders List View -->
        <?php if (empty($activeOrders)) { ?>
            <div class="alert alert-info">No active orders found.</div>
        <?php } else { ?>
            <?php foreach ($activeOrders as $order) { 
                $orderItems = getOrderItems($order['id']);
            ?>
                <div class="order-container <?php echo ($order['status'] == 'Processing') ? 'status-processing' : (($order['status'] == 'Out for Delivery') ? 'status-out-for-delivery' : ''); ?>" 
                     onclick="window.location.href='<?php echo $_SERVER['PHP_SELF']; ?>?order_id=<?php echo $order['id']; ?><?php echo $filteredUserId ? '&user_id=' . $filteredUserId : ''; ?>'">
                    <div class="order-header">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Order Date</strong><br>
                                <?php echo date('Y/m/d h:i A', strtotime($order['date'])); ?>
                            </div>
                            <div class="col-md-3">
                                <strong>Name</strong><br>
                                <?php echo htmlspecialchars($order['name']); ?>
                            </div>
                            <div class="col-md-2">
                                <strong>Room</strong><br>
                                <?php echo htmlspecialchars($order['room']); ?>
                            </div>
                            <div class="col-md-2">
                                <strong>Ext.</strong><br>
                                6506
                            </div>
                            <div class="col-md-2">
                                <form method="post" onclick="event.stopPropagation();">
                                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="Out for Delivery" <?php echo $order['status'] == 'Out for Delivery' ? 'selected' : ''; ?>>Out for Delivery</option>
                                        <option value="Done" <?php echo $order['status'] == 'Done' ? 'selected' : ''; ?>>Done</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-items">
                        <?php 
                        foreach ($orderItems as $item) { ?>
                            <div class="item">
                                <div class="item-icon"><?php echo $item['price']; ?> LE</div>
                                <div><?php echo htmlspecialchars($item['name']); ?></div>
                                <div><?php echo $item['quantity']; ?></div>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="total">
                        Total: EGP <?php echo number_format($order['total_price'], 2); ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>

<script>
    // Prevent order container from redirecting when clicking on forms
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.order-container form');
        forms.forEach(form => {
            form.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
</body>
</html>