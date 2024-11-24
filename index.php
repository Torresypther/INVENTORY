<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {

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
$connection = $newconnection->openConnection();

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$availability = isset($_POST['availability']) ? $_POST['availability'] : '';
$categoryFilter = isset($_POST['category_filter']) ? $_POST['category_filter'] : '';
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';

$sql = 'SELECT product_table.*, categories.category
        FROM product_table
        INNER JOIN categories 
        ON product_table.category_id = categories.category_id
        WHERE 1
        ';

if (!empty($searchTerm)) {
    $sql .= ' AND (product_name LIKE :searchTerm OR category LIKE :searchTerm)';
}

if ($availability == 'in_stock') {
    $sql .= ' AND stocks_left > 0';
} elseif ($availability == 'out_of_stock') {
    $sql .= ' AND stocks_left = 0';
}

if (!empty($categoryFilter)) {
    $sql .= ' AND product_table.category_id = :categoryFilter';
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <title>Sales Inventory</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
        background-color: #F3F7F0;
    }

    .nav_bar {
        background-color: #19323C;
        color: #F3F7F0;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 1rem;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .nav_buttons {
        display: flex;
        gap: 20px;
        justify-content: center; 
        align-items: center;
        flex-wrap: wrap;
    }

    .nav_buttons a,
    .nav_buttons button {
        padding: 8px 12px;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        border: 2px solid #19323C;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px; 
        transition: color 0.3s ease, border-color 0.3s ease;
    }

    .nav_buttons a:hover,
    .nav_buttons button:hover {
        color: #0056b3;
        border-color: #0056b3;
    }

    .nav_buttons i {
        font-size: 18px;
    }

    .nav_buttons button.addcat_button {
        background-color: transparent;
        border: 2px solid #19323C; 
        color: white;
    }

    .nav_buttons button.addcat_button:hover {
        background-color: transparent;
        color: #0056b3;
        border-color: #0056b3;
    }

    .container {
        display: flex;
        justify-content: space-between;
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .search-container,
    .filters-container {
        flex: 1;
        display: flex;
        align-items: center;
    }

    .search {
        width: 450px;
        margin-right: 15px;
    }

    .search_input {
        width: 100%;
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 8px;
    }

    .filters {
        display: flex;
        gap: 10px;
        flex: 2;
    }

    .filters select {
        min-width: 130px;
        flex: 0;
    }

    .date-filters {
        display: flex;
        gap: 10px;
    }

    .filters input[type="date"] {
        flex: 1;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 8px;
    }

    .button-container {
        display: flex;
        gap: 10px;
        flex: 1;
    }

    .search_button,
    .filter_button {
        padding: 10px 10px;
        border-radius: 10px;
        color: white;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s;
        margin-top: 1.2rem;
        flex: 1;    
        height: 45px;
        border: none;
    }

    .search_button {
        background-color: #d18821;
    }

    .search_button:hover {
        background-color: #c3780f;
    }

    .filter_button {
        background-color: #d18821;
        color: white;
    }

    .filter_button:hover {
        background-color: #c3780f;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .table-container {
        margin: 3rem;
        margin-top: 1rem;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .table-hover tbody tr:hover {
        background-color: #ebebeb;
    }

    .table tr {
        height: 2rem;
        line-height: 3rem;
    }

    .link-dark {
        text-decoration: none;
        color: #343a40;
    }

    .button-container2 {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btnEdit,
    .btndelete {
        background-color: #04ae59;
        color: white;
        padding: 5px 15px;
        border-radius: 10px;
        border: none;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .btnEdit {
        background-color: #04ae59;
    }

    .btnEdit:hover {
        background-color: #019d4f;
    }

    .btndelete {
        background-color: #dc3545;
    }

    .btndelete:hover {
        background-color: #c82333;
    }

    button.btn {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btnButtons {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: transparent;
        padding: 10px;
        margin: 100px;
    }

    .button-container a {
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        font-weight: bold;
    }

    .button-container a {
        margin-right: 10px;
    }


    </style>
</head>

<body>

    <?php
    $newconnection->deleteProduct();
    $newconnection->updateProduct();
    $newconnection->addCategory();
    ?>

    <nav class="nav_bar">
        <span>PESHO MEATERY</span>
        <div class="nav_buttons">
            <a href="customer_order.php">
                <i class="fa-solid fa-box-open"></i> View Orders
            </a>
            <a href="add_product.php" class="add_productbtn">
                <i class="fa-solid fa-plus-circle"></i> Add Product
            </a>
            <button type="button" class="addcat_button" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fa-solid fa-folder-plus"></i> Add Category
            </button>
            <?php include 'add_category.php' ?>
            <a href="terminate.php">
                <i class="fa-solid fa-sign-out-alt"></i> Log Out
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="search-container">
            <form action="index.php" method="POST">
                <div class="search">
                    <input type="text" class="search_input" name="search" placeholder="Search..." id="search" />
                </div>

                <div class="button-container">
                    <button type="submit" class="search_button">Search</button>
                </div>
            </form>
        </div>

        <div class="filters-container">
            <form action="index.php" method="POST">
                <div class="filters">
                    <select name="availability" class="drop1 form-select clearFilters">
                        <option value="" <?php echo ($availability == '') ? 'selected' : ''; ?>>Availability
                        </option>
                        <option value="in_stock" <?php echo ($availability == 'in_stock') ? 'selected' : ''; ?>>In Stock
                        </option>
                        <option value="out_of_stock" <?php echo ($availability == 'out_of_stock') ? 'selected' : ''; ?>>
                            Out of Stock</option>
                    </select>

                    <select name="category_filter" class="drop1 form-select">
                        <option value="" <?php echo ($categoryFilter == '') ? 'selected' : ''; ?>>Category
                        </option>
                        <?php
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    echo '<option value="' . $category->category_id . '" ' . 
                                        (($categoryFilter == $category->category_id) ? 'selected' : '') . '>' . 
                                        $category->category . '</option>';
                                }
                            }
                        ?>

                    </select>

                    <div class="date-filters">
                        <input type="date" name="start_date" class="form-select" placeholder="Start Date"
                            value="<?php echo htmlspecialchars($startDate); ?>">
                        <input type="date" name="end_date" class="form-select" placeholder="End Date"
                            value="<?php echo htmlspecialchars($endDate); ?>">
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
            <thead class="tablehead">
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
                            <!-- below kay name sa category name nimo na column sa categories na table -->
                            <td><?php echo htmlspecialchars($row->category) ?></td>
                            <td><?php echo htmlspecialchars(number_format($row->product_price, 2)) ?></td>
                            <td><?php echo htmlspecialchars($row->stocks_left) ?></td>
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
                                        <button class="btndelete btn btn-danger btn-sm" type="submit"
                                            value="<?php echo htmlspecialchars($row->product_id); ?>" name="product_id"
                                            style="display: flex; align-items: center; justify-content: center;">
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