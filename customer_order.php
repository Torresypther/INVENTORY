<?php
require_once('db_conn.php');
$connection = $newconnection->openConnection();

session_start();

if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $sql = "SELECT * FROM customer_order ORDER BY order_date DESC";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
        header("Location: unauthorized.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            padding: 0;
            padding-bottom: 4rem;
            background-color: #F3F7F0;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #19323C;
            padding: 1rem 2rem;
            color: white;
        }

        .navbar .logo {
            font-size: 1.75rem;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #00b0ff;
        }

        .container {
            margin-top: 3rem;
        }

        .table {
            width: 100%;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .table th, .table td {
            padding: 1rem;
            text-align: center;
        }

        .table th {
            background-color: #19323C;
            color: white;
        }

        .table-hover tbody tr:hover {
            background-color: #00b0ff;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.75rem; 
        }

        .btn {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.3s;
        }

        .btn.shipped {
            background-color: #28a745;
            color: #fff;
        }

        .btn.shipped:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .btn.cancelled {
            background-color: #dc3545;
            color: #fff;
        }

        .btn.cancelled:hover {
            background-color: #c82333;
            transform: translateY(-2px); 
        }

        .btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
        }

        .button-container2 {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

    </style>

    <title>View Customer Orders</title>
</head>
<body>

<nav class="navbar">
    <div class="logo">CUSTOMER ORDERS</div>
    <a href="javascript:history.back()" class="back-btn">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</nav>

<div class="container">

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Product Ordered</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Payable</th>
                <th scope="col">Order Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($orders) { 
                foreach ($orders as $order) {
            ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order->order_id); ?></td>
                        <td><?php echo htmlspecialchars($order->product_name); ?></td>
                        <td><?php echo htmlspecialchars($order->quantity); ?></td>
                        <td><?php echo htmlspecialchars(number_format($order->total_payable, 2)); ?></td>
                        <td><?php echo htmlspecialchars($order->order_date); ?></td>
                        <td>
                            <div class="button-container2">
                                <form action="#" method="POST" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order->order_id); ?>">
                                    <input type="hidden" name="status" value="shipped">
                                    <button class="btn shipped btn-success btn-sm" type="submit"
                                        style="display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-truck fs-5 me-3"></i>Shipped Out
                                    </button>
                                </form>

                                <form action="#" method="POST" style="display:inline;">
                                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order->order_id); ?>">
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="btn cancelled btn-danger btn-sm" type="submit"
                                        style="display: flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-times-circle fs-5 me-3"></i>Cancelled
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
            <?php
                }
            } else { 
                echo '<tr><td colspan="6">No orders found.</td></tr>';
            }
            ?>
        </tbody>

    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
