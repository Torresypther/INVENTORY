<?php
session_start();

// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'customer') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the order data from the POST request (ensure they are arrays)
    $product_names = isset($_POST['product_names']) ? $_POST['product_names'] : [];
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
    $payables = isset($_POST['payables']) ? $_POST['payables'] : [];
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Order Summary Section -->
<div class="container mt-5">
    <h2>Your Order Summary</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Payable</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Ensure that the variables are arrays before counting
            if (is_array($product_names) && is_array($quantities) && is_array($payables)) {
                $total = 0;
                for ($i = 0; $i < count($product_names); $i++) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($product_names[$i]) . "</td>"; // Display product names
                    echo "<td>" . htmlspecialchars($quantities[$i]) . "</td>";
                    echo "<td>₱" . number_format($payables[$i], 2) . "</td>";
                    echo "</tr>";
                    $total += $payables[$i];
                }
            }
            ?>
        </tbody>
    </table>

    <p><strong>Total Payable: ₱<?php echo number_format($total, 2); ?></strong></p>

    <!-- Form for Address and Payment Method -->
    <form action="process_order.php" method="post">
        <h4>Delivery Address</h4>
        <div class="mb-3">
            <label for="address" class="form-label">Enter your delivery address</label>
            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
        </div>

        <h4>Payment Method</h4>
        <div class="mb-3">
            <label for="payment" class="form-label">Choose Payment Method</label>
            <select id="payment" name="payment_method" class="form-select" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cash_on_delivery">Cash on Delivery</option>
            </select>
        </div>

        <!-- Hidden fields to pass the order data -->
        <?php
        // Loop to pass each item in hidden inputs
        for ($i = 0; $i < count($product_names); $i++) {
            echo '<input type="hidden" name="product_names[]" value="' . htmlspecialchars($product_names[$i]) . '">';
            echo '<input type="hidden" name="quantities[]" value="' . htmlspecialchars($quantities[$i]) . '">';
            echo '<input type="hidden" name="payables[]" value="' . htmlspecialchars($payables[$i]) . '">';
        }
        ?>

        <button type="submit" class="btn btn-primary">Confirm Order</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
