<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['role']) && isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'customer') {
        $user_id = $_SESSION['user_id'];
    } else {
        header("Location: unauthorized.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

require_once 'db_conn.php';
$connection = $newconnection->openConnection();
$result = $newconnection->getCartItems($user_id);

// Check if the order was successfully placed
$order_placed = isset($_SESSION['order_placed']) ? $_SESSION['order_placed'] : false;
unset($_SESSION['order_placed']); // Clear the session variable after showing the message
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Your Cart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            padding: 0;
            padding-bottom: 4rem;
            background-color: #fdf4ef;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #de6b48;
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
            color: #ff9800;
        }

        .navbar ul {
            list-style-type: none;
            display: flex;
            gap: 1rem;
        }

        .navbar ul li:hover,
        .navbar .icons div:hover {
            color: #ff9800;
        }

        .container {
            margin-top: 3rem;
        }

        .card {
            width: 100%;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .quantity-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .quantity-container input {
            width: 70px;
            height: 30px;
            text-align: center;
        }

        .actions-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 1rem;
        }

        .btn-checkout {
            color: white;
            background-color: #3a8e2b;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn-checkout:hover {
            background-color: #347928;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            border: none;
            padding: 0.5rem 1rem;
            color: white;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .btn-delete:hover {
            background-color: #c82333;
            color: white;
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

        .total-price {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
        $newconnection->deleteCartProduct(); 
    ?>
    
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">This is your cart!</div>
        <div class="icons">
            <div class="homebtn">
                <a href="customer_feed.php">Back to Feed</a>
            </div>
            <div class="profile">
                <span class="bi bi-person-circle"></span>
                <a href="#">Profile</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <form action="" method="post">
            <div class="row">
                <?php
                if ($result) {
                    foreach ($result as $row) {
                ?>
                <div class="col-12 mb-4">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?php echo htmlspecialchars($row->product_image); ?>" class="img-fluid rounded-start" alt="<?php echo htmlspecialchars($row->product_name); ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo htmlspecialchars($row->product_name); ?></h3>
                                    <div class="quantity-container">
                                        <label for="quantity-<?php echo $row->cart_product_id; ?>">Quantity:</label>
                                        <input type="number" 
                                            name="quantities[<?php echo $row->cart_product_id; ?>]" 
                                            id="quantity-<?php echo $row->cart_product_id; ?>" 
                                            min="1" 
                                            value="<?php echo htmlspecialchars($row->quantity); ?>" 
                                            class="form-control" required>
                                    </div>

                                    <p class="card-text"><strong>Total Payable:</strong> <?php echo htmlspecialchars($row->payable); ?></p>

                                    <div class="actions-container d-flex justify-content-start">
                                        <form action="" method="post" style="display:inline;">
                                            <input type="hidden" name="cartproduct_id" value="<?php echo $row->cart_product_id; ?>">
                                            <button type="submit" name="btn-delete" class="btn btn-delete">Delete</button>
                                        </form>
                                    </div>                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p>No products found.</p>";
                }
                ?>
            </div>
        </form>
    </div>

    <div class="footer-bar">
        <div class="total-price">
            <?php 
            $totalPayable = $newconnection->getCartTotal(); 
            echo "Total Payable: ₱" . number_format($totalPayable, 2); 
            ?>
        </div>
        <div>
        <form action="order_summary.php" method="post">
            <?php foreach ($result as $row) { ?>
                <input type="hidden" name="product_names[]" value="<?php echo htmlspecialchars($row->product_name); ?>">
                <input type="hidden" name="quantities[]" value="<?php echo $row->quantity; ?>">
                <input type="hidden" name="payables[]" value="<?php echo $row->payable; ?>">
            <?php } ?>
            <button type="submit" class="btn-checkout">Place Order</button>
        </form>
        </div>
    </div>

    <?php if ($order_placed): ?>
    <!-- Success Dialog -->
    <div class="modal fade show" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Placed Successfully!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Your order has been successfully placed. Thank you for shopping with us!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
