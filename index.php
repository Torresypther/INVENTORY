<?php
    require_once('db_conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"">
    <link rel="stylesheet" href="index.css">
    <title>Sales Inventory</title>
</head>
<body>

<nav class="nav_bar">
    SARI-SARI INVENTORY SYSTEM
</nav>

<?php
    $newconnection->deleteProduct();
    $newconnection->updateProduct();
        
?>

<div class="container">
    
    <div class="search">
        <form action="index.php" method="post"> 
            <input type="text" class="search_input" name="search" placeholder="Search..." id="search" />
            <button type="submit" class="search_button">Search</button>
        </form>
    </div>

    <div class="button-container">
        <!-- <form action="index.php" method="GET">
            <select class="sort_dropdown" name="sort_by" onchange="this.form.submit()">
                <option value="" disabled selected>Sort By</option>
                <option value="product_name">Product Name</option>
                <option value="category">Product Category</option>
                <option value="unit_price">Unit Price</option>
                <option value="quantity">Quantity</option>
                <option value="restock_date">Restock Date</option>
            </select>
        </form> -->
        <a class="add_productbtn" href="add_product.php">Add Product</a>
    </div>
</div>

<?php
    // if (isset($_GET["msg"])) {
    //   $msg = $_GET["msg"];
    //   echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    //   ' . $msg . '
    //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    // }
?>

<div class="table-container">

    <table class="table table-hover text-center">
        <thead class="table_dark">
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
 
        <?php

        $connection = $newconnection->openConnection();

        $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

        if (!empty($searchTerm)) {
            $stmt = $connection->prepare('SELECT * FROM product_table WHERE product_name LIKE :searchTerm OR category LIKE :searchTerm ORDER BY product_id DESC');
            $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        } else {
            $stmt = $connection->prepare('SELECT * FROM product_table ORDER BY product_id DESC');
        }

        $stmt->execute();
        $result = $stmt->fetchAll();

        if ($result){
            foreach ($result as $row){
        ?>
            <tr>
                <td><?php echo $row->product_id ?></td>
                <td><?php echo $row->product_name ?></td>
                <td><?php echo $row->category ?></td>
                <td><?php echo $row->unit_price ?></td>
                <td><?php echo $row->quantity ?></td>
                <td><?php echo $row->restock_date ?></td>

                <td>
                <div class="button-container2">
                    <!-- Edit Button -->
                    <button type="button" class="btnEdit btn btn-primary btn-sm" name="product"
                        data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row->product_id; ?>">
                        <i class="fa-solid fa-pen-to-square fs-5 me-3"></i>Edit
                    </button>

                    <?php include("edit.php") ?>

                    <!-- Delete Button -->
                    <form action="" method="POST" class="d-inline">
                        <button class="btndelete btn btn-danger btn-sm" type="submit" value="<?php echo $row->product_id; ?>" 
                            name="product_id">
                            <i class="fa-solid fa-trash fs-5 me-3"></i>Delete
                        </button>
                    </form>
                </div>


                </td>
            </tr>

        <?php
            }
        }
        ?>

        </table>
    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>  
</body>
</html>