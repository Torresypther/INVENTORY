<?php
    require_once('db_conn.php');

    $connection = $newconnection->openConnection();

    $searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
    $availability = isset($_POST['availability']) ? $_POST['availability'] : '';
    $categoryFilter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';
    $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

    $sql = 'SELECT * FROM product_table WHERE 1=1';

    if (!empty($searchTerm)) {
        $sql .= ' AND (product_name LIKE :searchTerm OR category LIKE :searchTerm)';
        }

    if ($availability == 'in_stock') {
        $sql .= ' AND quantity > 0';
    } elseif ($availability == 'out_of_stock') {
        $sql .= ' AND quantity = 0';
        }

    if (!empty($categoryFilter)) {
        $sql .= ' AND category = :categoryFilter';
        }

    if (!empty($startDate) && !empty($endDate)) {
        $sql .= ' AND restock_date BETWEEN :startDate AND :endDate';
        }

    $sql .= ' ORDER BY product_id DESC';

    $stmt = $connection->prepare($sql);

    if (!empty($searchTerm)) {
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        }

    if (!empty($categoryFilter)) {
        $stmt->bindValue(':categoryFilter', $categoryFilter);
        }

    if (!empty($startDate) && !empty($endDate)) {
        $stmt->bindValue(':startDate', $startDate);
        $stmt->bindValue(':endDate', $endDate);
        }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    
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

    <div class="search-container">
        <form action="index.php" method="POST">
            <div class="search">
                <input type="text" class="search_input" name="search" placeholder="Search..." id="search" />
            </div>
            <div class="button-container">
                <button type="submit" class="search_button">Search</button>
                <a class="add_productbtn" href="add_product.php">Add Product</a>
            </div>
        </form>
    </div>

<div class="filters-container">
    <form action="index.php" method="POST">
        <div class="filters">
            <select name="availability" class="form-select clearFilters">
                <option value="" disabled <?php echo ($availability == '') ? 'selected' : ''; ?>>Filter by Availability</option>
                <option value="in_stock" <?php echo ($availability == 'in_stock') ? 'selected' : ''; ?>>In Stock</option>
                <option value="out_of_stock" <?php echo ($availability == 'out_of_stock') ? 'selected' : ''; ?>>Out of Stock</option>
            </select>

            <select name="category_filter" class="form-select">
                <option value="" disabled <?php echo ($categoryFilter == '') ? 'selected' : ''; ?>>Filter by Category</option>
                <option value="Kitchen Essentials" <?php echo ($categoryFilter == 'Kitchen Essentials') ? 'selected' : ''; ?>>Kitchen Essentials</option>
                <option value="Laundry Essentials" <?php echo ($categoryFilter == 'Laundry Essentials') ? 'selected' : ''; ?>>Laundry Essentials</option>
                <option value="Canned Goods" <?php echo ($categoryFilter == 'Canned Goods') ? 'selected' : ''; ?>>Canned Goods</option>
                <option value="Noodles" <?php echo ($categoryFilter == 'Noodles') ? 'selected' : ''; ?>>Noodles</option>
            </select>

            <div class="date-filters">
                <input type="date" name="start_date" class="form-select" placeholder="Start Date" value="<?php echo htmlspecialchars($startDate); ?>">
                <input type="date" name="end_date" class="form-select" placeholder="End Date" value="<?php echo htmlspecialchars($endDate); ?>">
            </div>
        </div>

        <div class="button-container">
            <button type="submit" class="filter_button">Filter</button>
        </div>
    </form>
</div>

</div>

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
        if ($result) {
            foreach ($result as $row) {
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row->product_id) ?></td>
                <td><?php echo htmlspecialchars($row->product_name) ?></td>
                <td><?php echo htmlspecialchars($row->category) ?></td>
                <td><?php echo htmlspecialchars(number_format($row->unit_price, 2)) ?></td>
                <td><?php echo htmlspecialchars($row->quantity) ?></td>
                <td><?php echo htmlspecialchars($row->restock_date) ?></td>
                <td>
                    <div class="button-container2">
                        <button type="button" class="btnEdit btn btn-primary btn-sm" name="product"
                            data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row->product_id; ?>"
                            style="display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-pen-to-square fs-5 me-3"></i>Edit
                        </button>
                        <?php include("editModal.php"); ?>

                        <form action="" method="POST" style="display:inline;">
                            <button class="btndelete btn btn-danger btn-sm" type="submit" value="<?php echo htmlspecialchars($row->product_id); ?>"
                                name="product_id" style="display: flex; align-items: center; justify-content: center;">
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
