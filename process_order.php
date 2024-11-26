<?php
session_start();
require_once 'db_conn.php';

$database = new Connection();
$connection = $database->openConnection();

if (!isset($_SESSION['user_id']) || !isset($_POST['product_names'], $_POST['quantities'], $_POST['payables'], $_POST['address'], $_POST['payment_method'])) {
    echo "Required data missing.";
    exit();
}

$product_names = $_POST['product_names'];
$quantities = $_POST['quantities'];
$payables = $_POST['payables'];
$address = $_POST['address'];
$payment_method = $_POST['payment_method'];

try {
    $connection->beginTransaction();

    $query = "INSERT INTO customer_order (user_id, product_name, quantity, product_price, total_payable, delivery_address, order_date) 
              VALUES (:user_id, :product_name, :quantity, :product_price, :total_payable, :delivery_address, NOW())";
    $stmt = $connection->prepare($query);

    for ($i = 0; $i < count($product_names); $i++) {
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':product_name', $product_names[$i], PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantities[$i], PDO::PARAM_INT);
        $stmt->bindParam(':product_price', $payables[$i], PDO::PARAM_STR);
        $stmt->bindParam(':total_payable', $payables[$i], PDO::PARAM_STR);
        $stmt->bindParam(':delivery_address', $address, PDO::PARAM_STR);
        $stmt->execute();

        $queryUpdateStock = "UPDATE product_table SET stocks_left = stocks_left - :quantity WHERE product_name = :product_name";
        $stmtUpdateStock = $connection->prepare($queryUpdateStock);
        $stmtUpdateStock->bindParam(':quantity', $quantities[$i], PDO::PARAM_INT);
        $stmtUpdateStock->bindParam(':product_name', $product_names[$i], PDO::PARAM_STR);

        if (!$stmtUpdateStock->execute()) {
            throw new Exception("Failed to update stock for product: " . $product_names[$i]);
        }
    }

    $querySummary = "INSERT INTO order_summary (user_id, total_amount, delivery_address, payment_method, order_date) 
                     VALUES (:user_id, :total_amount, :delivery_address, :payment_method, NOW())";
    $stmtSummary = $connection->prepare($querySummary);
    $stmtSummary->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmtSummary->bindParam(':total_amount', array_sum($payables), PDO::PARAM_STR);
    $stmtSummary->bindParam(':delivery_address', $address, PDO::PARAM_STR);
    $stmtSummary->bindParam(':payment_method', $payment_method, PDO::PARAM_STR);
    $stmtSummary->execute();

    $orderId = $connection->lastInsertId();

    $queryUpdate = "UPDATE customer_order SET order_id = :order_id WHERE user_id = :user_id AND order_id IS NULL";
    $stmtUpdate = $connection->prepare($queryUpdate);
    $stmtUpdate->bindParam(':order_id', $orderId, PDO::PARAM_INT);
    $stmtUpdate->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmtUpdate->execute();

    $connection->commit();

    clearCart($_SESSION['user_id'], $connection);

    $_SESSION['order_id'] = $orderId;
    $_SESSION['order_placed'] = true;
    header("Location: customer_cart.php?msg=Item Checked Out");
    exit();

} catch (Exception $e) {
    $connection->rollBack();
    error_log("Error: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
}

function clearCart($userId, $connection) {
    try {
        $query = "DELETE FROM customer_cart WHERE user_id = :user_id";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        echo "An error occurred while clearing the cart. Please try again later.";
    }
}
?>
