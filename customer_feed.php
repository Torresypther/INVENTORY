<?php
require_once 'db_conn.php';
$connection = $newconnection->openConnection();
$result = $newconnection->getItems();
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

    /* Navbar Styling */
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

    .navbar ul li {
        cursor: pointer;
    }

    .navbar ul li:hover {
        color: #ff9800;
    }

    .navbar .icons {
        display: flex;
        gap: 1rem;
    }

    .navbar .icons div {
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .navbar .icons div:hover {
        color: #ff9800;
    }

    /* Card Styling */
    .cart-container {
        display: flex;
        justify-content: center;
        margin-top: 5rem;
    }

    .card {
        width: 20rem;
    }

    .quantity-container {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-bottom: 2rem;
    }

    .quantity-container input {
        width: 60px;
        text-align: center;
    }

    .btn-add-to-cart {
        background-color: #28a745;
        color: white;
        transition: background-color 0.3s;
    }

    .btn-add-to-cart:hover {
        background-color: #218838;
    }
    </style>

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">Hi Welcome, Buy Before you Log Out betch!</div>
        <div class="icons">
            <div class="cart">
                <span>🛒</span>
                <a href="customer_cart.php" style="text-decoration: none; color: white;">Cart</a>
            </div>
            <div class="profile">
                <span>👤</span>
                <a href="#" style="text-decoration: none; color: white;">Profile</a>
            </div>
        </div>
    </nav>

    <?php
        $newconnection->addCart();
    ?>

    <div class="container mt-5">
        <div class="row">
            <?php
            if ($result) {
                // Loop through each product as an object
                foreach ($result as $row) {
            ?>
            <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <!-- Display product image -->
                        <img src="<?php echo $row->image_url; ?>" class="card-img-top"
                            alt="<?php echo $row->product_name; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row->product_name; ?></h5>
                            <p class="card-text">Stocks Left: <?php echo $row->quantity; ?></p>
                            <p class="card-text"><strong>Price:</strong><?php echo $row->product_price; ?>
                            </p>

                        <form action="" method="post">
                            <input type="hidden" name="product_name" value="<?php echo $row->product_name; ?>">
                            <input type="hidden" name="price" value="<?php echo $row->product_price; ?>">
                            <div class="quantity-container mb-3">
                                <label for="quantity-<?php echo $row->id; ?>">Quantity:</label>
                                <input name="quantity" type="number" id="quantity" name="quantity" min="1" value="1"
                                    class="form-control">
                            </div>
                            <!-- Add to Cart Button -->
                            <button type="submit" name="addtocart_btn">Add to Cart</button>
                        </form>
                            

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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>