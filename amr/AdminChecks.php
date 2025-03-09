<?php
session_start();

// Database connection
$DBName = "cafeteria";
$host = "localhost:3307";
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

// Function to get all users for filter dropdown
function getAllUsers() {
    $connection = getConnection();
    $sql = "SELECT id, username FROM users ORDER BY username";
    
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get filtered checks (user orders summary)
function getFilteredChecks($filters = []) {
    $connection = getConnection();
    
    $sql = "SELECT u.id as user_id, u.username, u.email, 
           COUNT(o.id) as order_count, 
           SUM(o.total_price) as total_amount
           FROM users u
           LEFT JOIN orders o ON u.id = o.user_id";
    
    $where_conditions = [];
    $params = [];
    
    // Add date range filter
    if (!empty($filters['date_from'])) {
        $where_conditions[] = "o.created_at >= :date_from";
        $params[':date_from'] = $filters['date_from'] . ' 00:00:00';
    }
    
    if (!empty($filters['date_to'])) {
        $where_conditions[] = "o.created_at <= :date_to";
        $params[':date_to'] = $filters['date_to'] . ' 23:59:59';
    }
    
    // Add user filter
    if (!empty($filters['user_id'])) {
        $where_conditions[] = "u.id = :user_id";
        $params[':user_id'] = $filters['user_id'];
    }
    
    // Combine WHERE conditions if any exist
    if (!empty($where_conditions)) {
        $sql .= " WHERE " . implode(" AND ", $where_conditions);
    }
    
    $sql .= " GROUP BY u.id, u.username, u.email ORDER BY total_amount DESC";
    
    $stmt = $connection->prepare($sql);
    
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get user's orders for a specific date range
function getUserOrders($userId, $dateFrom = null, $dateTo = null) {
    $connection = getConnection();
    
    $sql = "SELECT o.id, o.created_at as date, o.total_price, o.status
            FROM orders o
            LEFT JOIN rooms r ON o.room_id = r.id
            WHERE o.user_id = :user_id";
    
    $params = [':user_id' => $userId];
    
    if ($dateFrom) {
        $sql .= " AND o.created_at >= :date_from";
        $params[':date_from'] = $dateFrom . ' 00:00:00';
    }
    
    if ($dateTo) {
        $sql .= " AND o.created_at <= :date_to";
        $params[':date_to'] = $dateTo . ' 23:59:59';
    }
    
    $sql .= " ORDER BY o.created_at DESC";
    
    $stmt = $connection->prepare($sql);
    
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get order items
function getOrderItems($orderId) {
    $connection = getConnection();
    $sql = "SELECT p.name, p.price, oi.quantity, p.image, 
            (p.price * oi.quantity) as item_total
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :orderId";
    
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get user details
function getUserDetails($userId) {
    $connection = getConnection();
    $sql = "SELECT id, username, email FROM users WHERE id = :user_id";
    
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get order details
function getOrderDetails($orderId) {
    $connection = getConnection();
    $sql = "SELECT o.id, o.created_at, o.total_price, o.status, r.room_number as room_name, 
            u.username as user
            FROM orders o
            JOIN users u ON o.user_id = u.id
            LEFT JOIN rooms r ON o.room_id = r.id
            WHERE o.id = :order_id";
    
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Initialize filter variables
$filters = [
    'date_from' => isset($_GET['date_from']) ? $_GET['date_from'] : '',
    'date_to' => isset($_GET['date_to']) ? $_GET['date_to'] : '',
    'user_id' => isset($_GET['user_id']) ? $_GET['user_id'] : ''
];

// Selected user for detailed view
$selectedUserId = isset($_GET['view_user']) ? $_GET['view_user'] : null;

// Selected order for detailed view
$selectedOrderId = isset($_GET['view_order']) ? $_GET['view_order'] : null;

// Get data for filter dropdown
$users = getAllUsers();

// Get filtered checks
$filteredChecks = getFilteredChecks($filters);

// Get user's orders if a user is selected
$userOrders = [];
$userDetails = null;
if ($selectedUserId) {
    $userOrders = getUserOrders($selectedUserId, $filters['date_from'], $filters['date_to']);
    $userDetails = getUserDetails($selectedUserId);
}

// Get order details if an order is selected
$orderDetails = null;
$orderItems = [];
if ($selectedOrderId) {
    $orderDetails = getOrderDetails($selectedOrderId);
    $orderItems = getOrderItems($selectedOrderId);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Checks</title>
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
        }
        .order-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .order-items {
            display: flex;
            gap: 10px;
            padding: 15px;
            flex-wrap: wrap;
        }
        .item {
            text-align: center;
            width: 90px;
            margin-bottom: 10px;
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
            border-top: 1px solid #dee2e6;
        }
        .filter-card {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #f8f9fa;
            padding: 15px;
        }
        .filter-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }
        .check-row {
            cursor: pointer;
        }
        .check-row:hover {
            background-color: #f1f1f1;
        }
        .check-row.active {
            background-color: #e2f0ff;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
        }
        .status-processing {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-out-for-delivery {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        .status-done {
            background-color: #d4edda;
            color: #155724;
        }
        .order-notes {
            font-style: italic;
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 5px;
        }
        body {
    display: flex;
    flex-direction: column;
 
}

.container {
    flex: 1 0 auto;
    margin-top: 100px;
}

footer {
    flex-shrink: 0;
    margin-top: auto !important;
    margin-bottom: 0 !important;
}
    </style>
</head>
<body>
<?php 
include("../nav_footer/header.php")
?>
<div class="container" style="margin-top:100px;">
    <!-- Navigation -->
     


    <h2><i class="fas fa-receipt"></i> Checks</h2>
    
    <!-- Filter Form -->
    <div class="filter-card">
        <form method="GET" action="" id="filter-form">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Date Range</label>
                    <div class="input-group">
                        <input type="date" name="date_from" class="form-control" value="<?php echo $filters['date_from']; ?>" placeholder="From">
                        <span class="input-group-text">to</span>
                        <input type="date" name="date_to" class="form-control" value="<?php echo $filters['date_to']; ?>" placeholder="To">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">All Users</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo ($filters['user_id'] == $user['id']) ? 'selected' : ''; ?>>
                                <?php echo $user['username']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="filter-buttons">
                <button type="button" class="btn btn-secondary" onclick="resetFilters()">Reset Filters</button>
                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </div>
            
            <!-- If viewing user details, keep the view_user parameter -->
            <?php if ($selectedUserId): ?>
                <input type="hidden" name="view_user" value="<?php echo $selectedUserId; ?>">
            <?php endif; ?>
            
            <!-- If viewing order details, keep the view_order parameter -->
            <?php if ($selectedOrderId): ?>
                <input type="hidden" name="view_order" value="<?php echo $selectedOrderId; ?>">
            <?php endif; ?>
        </form>
    </div>
    
    <div class="row">
        <!-- User Checks Summary -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>User Summary</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th class="text-center">Orders</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($filteredChecks)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-3">No data found for the selected filters</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($filteredChecks as $check): ?>
                                        <tr class="check-row <?php echo ($selectedUserId == $check['user_id']) ? 'active' : ''; ?>" 
                                            onclick="viewUserOrders(<?php echo $check['user_id']; ?>)">
                                            <td><?php echo htmlspecialchars($check['username']); ?></td>
                                            <td><?php echo htmlspecialchars($check['email']); ?></td>
                                            <td class="text-center"><?php echo $check['order_count']; ?></td>
                                            <td class="text-end">$<?php echo number_format($check['total_amount'] ?? 0, 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User Orders Detail -->
        <div class="col-md-6">
            <?php if ($selectedUserId && $userDetails): ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>
                            Orders for <?php echo htmlspecialchars($userDetails['username']); ?>
                        </h5>
                        <span class="badge bg-primary"><?php echo count($userOrders); ?> Orders</span>
                    </div>
                    <div class="card-body p-0">
                        <?php if (empty($userOrders)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-coffee fa-3x text-muted mb-3"></i>
                                <p>No orders found for this user in the selected date range.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Room</th>
                                            <th>Status</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($userOrders as $order): ?>
                                            <tr class="check-row <?php echo ($selectedOrderId == $order['id']) ? 'active' : ''; ?>" 
                                                onclick="viewOrderDetails(<?php echo $order['id']; ?>)">
                                                <td>#<?php echo $order['id']; ?></td>
                                                <td><?php echo date('M d, Y H:i', strtotime($order['date'])); ?></td>
                                                <td><?php echo htmlspecialchars($order['room_name'] ?? 'N/A'); ?></td>
                                                <td>
                                                    <?php 
                                                        $statusClass = '';
                                                        switch($order['status']) {
                                                            case 'processing':
                                                                $statusClass = 'status-processing';
                                                                break;
                                                            case 'out for delivery':
                                                                $statusClass = 'status-out-for-delivery';
                                                                break;
                                                            case 'done':
                                                                $statusClass = 'status-done';
                                                                break;
                                                        }
                                                    ?>
                                                    <span class="status-badge <?php echo $statusClass; ?>">
                                                        <?php echo ucfirst($order['status']); ?>
                                                    </span>
                                                </td>
                                                <td class="text-end">$<?php echo number_format($order['total_price'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif (!$selectedUserId): ?>
                <div class="card h-100">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                        <i class="fas fa-hand-point-left fa-3x text-muted mb-3"></i>
                        <p>Select a user from the list to view their orders.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Order Details Modal -->
    <?php if ($selectedOrderId && $orderDetails): ?>
        <div class="modal fade show" id="orderDetailModal" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order #<?php echo $orderDetails['id']; ?> Details</h5>
                        <button type="button" class="btn-close" onclick="closeOrderDetails()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Customer:</strong> <?php echo htmlspecialchars($orderDetails['user']); ?></p>
                                <p><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($orderDetails['created_at'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong> 
                                    <?php 
                                        $statusClass = '';
                                        switch($orderDetails['status']) {
                                            case 'processing':
                                                $statusClass = 'status-processing';
                                                break;
                                            case 'out for delivery':
                                                $statusClass = 'status-out-for-delivery';
                                                break;
                                            case 'done':
                                                $statusClass = 'status-done';
                                                break;
                                        }
                                    ?>
                                    <span class="status-badge <?php echo $statusClass; ?>">
                                        <?php echo ucfirst($orderDetails['status']); ?>
                                    </span>
                                </p>
                                <p><strong>Room:</strong> <?php echo htmlspecialchars($orderDetails['room_name'] ?? 'N/A'); ?></p>
                            </div>
                        </div>
                        
                        <h6>Order Items</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderItems as $item): ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($item['name']); ?>
                                                <?php if (!empty($item['notes'])): ?>
                                                    <div class="order-notes">Note: <?php echo htmlspecialchars($item['notes']); ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">$<?php echo number_format($item['price'], 2); ?></td>
                                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                                            <td class="text-end">$<?php echo number_format($item['item_total'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Total</th>
                                        <th class="text-end">$<?php echo number_format($orderDetails['total_price'], 2); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeOrderDetails()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <script>
        function resetFilters() {
            document.querySelector('input[name="date_from"]').value = '';
            document.querySelector('input[name="date_to"]').value = '';
            document.querySelector('select[name="user_id"]').value = '';
            document.getElementById('filter-form').submit();
        }
        
        function viewUserOrders(userId) {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Update view_user parameter
            urlParams.set('view_user', userId);
            
            // Remove view_order parameter if exists
            if (urlParams.has('view_order')) {
                urlParams.delete('view_order');
            }
            
            // Redirect to new URL
            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }
        
        function viewOrderDetails(orderId) {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Update view_order parameter
            urlParams.set('view_order', orderId);
            
            // Redirect to new URL
            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }
        
        function closeOrderDetails() {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Remove view_order parameter
            urlParams.delete('view_order');
            
            // Redirect to new URL
            window.location.href = window.location.pathname + '?' + urlParams.toString();
        }
    </script>
</div>
<?php 
include("../nav_footer/footer.php")
?>
</body>
</html>
