<?php
require_once 'db_conn.php';
$connection = $newconnection->openConnection();
$newconnection->addCart();
$result = $newconnection->getItems();
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <title>Shop Now at PPESHO</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
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
        padding-top: 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 1.5rem;
    }

    .col-lg-3, .col-md-4, .col-sm-6 {
        flex: 0 0 calc(33.333% - 1.5rem);
        padding-right: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .card {
        width: 100%;
        height: 350px;
        margin-bottom: 1.5rem;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        border-radius: 8px;
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-body {
        padding: 1rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
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

    .btn-add-to-cart {
        background-color: #de6b48;
        color: #f9e5db;
        transition: background-color 0.3s, transform 0.2s;
        width: 100%;
        padding: 0.75rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
    }

    .btn-add-to-cart:hover {
        background-color: #da5535;
        transform: translateY(-2px);
    }

    .btn-add-to-cart:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
    }

    .alert-success {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9999;
        width: 20rem;
        max-width: 400px;
        padding: 15px;
        padding-bottom: 30px;
        border-radius: 8px;
        text-align: center;
        background-color: #f9e5db;
        color: #6d2421;
        font-weight: bold;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        opacity: 1;
        animation: fadeOut 2.5s forwards;
        height: auto;
    }

    .alert-success .bi-check-circle {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .alert-success strong {
        display: block;
        font-size: 1.2rem;
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }
        99% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Buy All at PPESHO</div>
        <div class="icons">
            <div class="cart">
                <span class="bi bi-cart"></span>
                <a href="customer_cart.php">Cart</a>
            </div>
            <div class="profile">
                <span class="bi bi-person-circle"></span>
                <a href="#">Profile</a>
            </div>
        </div>
    </nav>

    <?php

    if ($msg) {
        echo '<div class="alert alert-success alert-dismissible fade-out show" role="alert">
                <i class="bi bi-check-circle"></i>
                <strong>Item Added to Cart!</strong>
            </div>';
    }
    ?>

<div class="container">
    <div class="row">
        <?php if ($result) {
            foreach ($result as $row) { ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100">
                    <img src="<?php echo $row->product_image; ?>" class="card-img-top" alt="<?php echo $row->product_name; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row->product_name; ?></h5>
                        <p class="card-text">Stocks Left: <strong><?php echo $row->stocks_left; ?></strong> kilo(s)</p>
                        <p class="card-text"><strong>Price:</strong> ₱<?php echo $row->product_price; ?></p>
                        
                        <form action="" method="post">
                            <div class="quantity-container">
                                <label for="quantity-<?php echo $row->product_id; ?>">Quantity:</label>
                                <input name="quantity" type="number" id="quantity-<?php echo $row->product_id; ?>" min="1" value="1" class="form-control">
                            </div>
                            <input type="hidden" name="product_image" value="<?php echo $row->product_image; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $row->product_name; ?>">
                            <input type="hidden" name="price" value="<?php echo $row->product_price; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $row->product_id; ?>">
                            <!-- Submit button sends quantity directly -->
                            <button type="submit" name="addtocart_btn" class="btn-add-to-cart">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php }
        } else {
            echo "<p>No products found.</p>";
        } ?>
    </div>
</div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
