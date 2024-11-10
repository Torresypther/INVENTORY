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
        margin-top: 2rem;
    }

    .card {
        width: 18rem;
    }

    .quantity-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
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
        <div class="logo">Brand</div>
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

    <div class="container mt-5">
        <div class="row">
            <?php
            if ($result) {
                // Loop through each product as an object
                while ($row = $result->fetch_object()) {
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Display product image -->
                    <img src="<?php echo $row->image_url; ?>" class="card-img-top"
                        alt="<?php echo $row->product_name; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row->product_name; ?></h5>
                        <p class="card-text">Quantity: <?php echo $row->quantity; ?></p>
                        <p class="card-text"><strong>Price:</strong> $<?php echo $row->product_price; ?></p>

                        <!-- Quantity Selector -->
                        <div class="quantity-container mb-3">
                            <label for="quantity-<?php echo $row->id; ?>">Quantity:</label>
                            <input type="number" id="quantity-<?php echo $row->id; ?>" name="quantity" min="1" value="1"
                                class="form-control">
                        </div>

                        <!-- Add to Cart Button -->
                        <a href="add_to_cart.php?id=<?php echo $row->id; ?>" class="btn btn-primary w-100">Add to
                            Cart</a>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No products found.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Card Section -->
    <div class="cart-container">
        <div class="card">
            <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product Image">
            <form action="" method="post">
                <div class="card-body">
                    <h5 class="card-title" name="prod_name" value="Coke">Coke</h5>
                    <p class="card-text">Coke the refreshes heavy souls</p>
                    <div class="quantity-container">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" value="1" class="form-control">
                    </div>
                    <button type="submit" name="addtocart_btn">Add to Cart</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>