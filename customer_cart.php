<?php
require_once 'db_conn.php';
$connection = $newconnection->openConnection();
$result = $newconnection->getCartItems();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Navigation Bar with Item Card</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body{
        padding-bottom: 2rem;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #333;
        padding: 1rem 2rem;
        color: white;
    }

    .navbar .logo {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .navbar ul {
        list-style-type: none;
        display: flex;
        gap: 1.5rem;
    }

    .navbar ul li:hover, .navbar .icons div:hover {
        color: #ff9800;
    }

    .cart-container {
        display: flex;
        justify-content: center;
        margin-top: 5rem;
    }

    .card {
        width: 100%;
    }

    .quantity-container {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-bottom: 1rem;
    }

    .quantity-container input {
        width: 60px;
        text-align: center;
    }

    .btn-checkout, .btn-delete {
        color: white;
        transition: background-color 0.3s;
    }

    .btn-checkout {
        background-color: #28a745;
    }

    .btn-checkout:hover {
        background-color: #218838;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #c82333;
    }

    .actions-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .actions-container .btn-delete {
        margin-left: auto;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">This is your cart!</div>
        <div class="icons">
            <div class="profile">
                <span>👤</span>
                <a href="#" style="text-decoration: none; color: white;">Profile</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <form action="checkout.php" method="post">
            <div class="row">
                <?php
                if ($result) {
                    foreach ($result as $row) {
                ?>
                <div class="col-12 mb-4">
                    <div class="card h-100">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?php echo $row->image_url; ?>" class="img-fluid rounded-start" alt="<?php echo $row->product_name; ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row->product_name; ?></h5>
                                    <p class="card-text">Stocks Left: <?php echo $row->quantity; ?></p>
                                    <p class="card-text"><strong>Total Payable:</strong> <?php echo $row->payable; ?></p>

                                    <div class="quantity-container mb-3">
                                        <label for="quantity-<?php echo $row->id; ?>">Quantity:</label>
                                        <input type="number" 
                                            name="quantities[<?php echo $row->id; ?>]" 
                                            id="quantity-<?php echo $row->id; ?>" 
                                            min="1" 
                                            value="<?php echo $row->quantity; ?>" 
                                            class="form-control">
                                    </div>

                                    <div class="actions-container">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selected_items[]" value="<?php echo $row->id; ?>" id="select-<?php echo $row->id; ?>">
                                            <label class="form-check-label" for="select-<?php echo $row->id; ?>">
                                                Select for checkout
                                            </label>
                                        </div>

                                        <!-- Delete Button aligned to the right -->
                                        <form action="delete_item.php" method="post" style="display:inline;">
                                            <input type="hidden" name="product_id" value="<?php echo $row->id; ?>">
                                            <button type="submit" class="btn btn-delete">Delete</button>
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
            <button type="submit" class="btn btn-checkout mt-3">Proceed to Checkout</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
