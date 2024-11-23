<?php
require_once('db_conn.php');
$connection = $newconnection->openConnection();

session_start();

if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'customer') {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Corrected Bootstrap Icons link -->
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

        .navbar .icons {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .navbar .icons div {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.1rem;
        }

        .navbar .icons span {
            font-size: 1.3rem;
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

        .navbar ul {
            list-style-type: none;
            display: flex;
            gap: 1rem;
        }

        .navbar ul li:hover,
        .navbar .icons div:hover {
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

        .btnButtons {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .button-container a {
            background-color: #1a3a5a;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            color: white;
            font-size: 1.1rem;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .button-container a:hover {
            background-color: #004c74;
        }

        .footer-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            border-top: 1px solid #ddd;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .back-btn {
            color: white;
            font-size: 1.1rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s;
        }

        .back-btn:hover {
            color: #00b0ff;
        }

    </style>
    <title>View Customer Orders</title>
</head>
<body>

<nav class="navbar">
    <div class="logo">CUSTOMER ORDERS</div>
    <div class="icons">
        <a href="javascript:history.back()" class="back-btn">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</nav>

<div class="container">

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Order ID</th>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total Payable</th>
                <th scope="col">Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($orders) {
                foreach ($orders as $order) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($order->order_id) . "</td>";
                    echo "<td>" . htmlspecialchars($order->product_name) . "</td>";
                    echo "<td>" . htmlspecialchars($order->quantity) . "</td>";
                    echo "<td>" . htmlspecialchars(number_format($order->total_payable, 2)) . "</td>";
                    echo "<td>" . htmlspecialchars($order->order_date) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

