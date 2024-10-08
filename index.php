<?php
    require_once('db_conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title>Sales Inventory</title>
</head>
<body>

<?php
    $newconnection->deleteProduct();
    $newconnection->updateProduct(); 
?>

<nav class="nav_bar">
    SARI-SARI INVENTORY SYSTEM
</nav>

<div class="container">
    
    <div class="search">
        <form action="index.php" method="post"> 
            <input type="text" class="search_input" name="search" placeholder="Search..." id="search" />
            <button type="submit" class="search_button">Search</button>
        </form>
    </div>

    <div class="button-container">
        <a class="add_productbtn btn btn-success" href="add_product.php">Add Product</a>
    </div>
</div>

<?php
    // Display messages if any
    if (isset($_GET["msg"])) {
      $msg = htmlspecialchars($_GET["msg"]);
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
?>

<div class="table-container">
    <table class="table table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Product Name</th>
                <th scope="col">Product Category</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Quantity</th>
                <th scope="col">Restock Date</th>
                <th scope="col">Product Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php

        $connection = $newconnection->openConnection();

        $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

        if (!empty($searchTerm)) {
            $stmt = $connection->prepare('SELECT * FROM product_table WHERE product_name LIKE :searchTerm OR category LIKE :searchTerm ORDER BY product_id DESC');
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        } else {
            $stmt = $connection->prepare('SELECT * FROM product_table ORDER BY product_id DESC');
        }

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        if ($result){
            foreach ($result as $row){
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row->product_id) ?></td>
                <td><?php echo htmlspecialchars($row->product_name) ?></td>
                <td><?php echo htmlspecialchars($row->category) ?></td>
                <td><?php echo htmlspecialchars($row->unit_price) ?></td>
                <td><?php echo htmlspecialchars($row->quantity) ?></td>
                <td><?php echo htmlspecialchars($row->restock_date) ?></td>

                <td>
                    <div class="button-container2">
                        <!-- Edit Button -->
                        <button type="button" class="btnEdit btn btn-primary btn-sm" name="product"
                            data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row->product_id; ?>">
                            <i class="fa-solid fa-pen-to-square fs-5 me-3"></i>Edit
                        </button>

                        <?php include("editModal.php"); ?>

                        <!-- Delete Button -->
                        <form action="" method="POST" style="display:inline;">
                            <button class="btndelete btn btn-danger btn-sm" type="submit" value="<?php echo htmlspecialchars($row->product_id); ?>" 
                                name="product_id">
                                <i class="fa-solid fa-trash fs-5 me-3"></i>Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

        <?php
            }
        } else {
            echo '<tr><td colspan="7">No products found.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>
</html>
