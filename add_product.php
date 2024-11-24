<?php 
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'customer') {

    } else {
        header("Location: unauthorized.php");
        exit();
    }
} else {

    header("Location: login.php");
    exit();
}

require_once('db_conn.php');  
$categories = $newconnection->getCategories();  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="add_product.css">
    <title>Add New Product</title>
</head>
<body>

</body>

<?php
    $newconnection->addProduct();
?>

<nav class="nav_bar">
    ADD NEW PRODUCT
</nav>

<div class="form-container d-flex justify-content-center">
    <form class="row g-3" action="" method="post" enctype="multipart/form-data">
        <div class="col-md-7">
            <label for="productname" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="productname" name="name" placeholder="Senorita Sardines">
        </div>

        <div class="col-md-5">
            <label for="category" class="form-label">Category</label>
            <select id="category" class="form-select" name="category">
                <option value="">--Select Category--</option>
                <?php
                if (!empty($categories)) {
                    foreach ($categories as $category) {
                        echo '<option value="' . $category->category_id . '">' . $category->category . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-md-12">
            <label for="price" class="form-label">Product Unit Price</label>
            <input type="decimal" class="form-control" id="price" name="price" placeholder="₱100.00">
        </div>

        <div class="col-8">
            <label for="quantity" class="form-label">Product Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="100 pieces">
        </div>

        <div class="col-4">
            <label for="date" class="form-label">Date Purchased</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>

        <div class="col-md-12">
            <label for="image" class="form-label">Product Image</label>
            <input type="file" class="form-control" id="userimage" name="userimage" accept="image/*">
        </div>

        <div class="col-12">
            <button type="submit" class="btnadd btn btn-primary" name="addproduct">Add New Product</button>
            <a href="index.php" class="btncancel btn btn-danger">Cancel</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    
</body>
</html>