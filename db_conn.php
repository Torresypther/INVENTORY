<?php
$newconnection = new Connection();

class Connection
{
    private $server = "mysql:host=localhost;dbname=sales_inventory";
    private $user = "root";
    private $pass = "";
    private $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    );

    protected $con;


    public function openConnection()
    {
        try {
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;
        } catch (PDOException $th) {
            echo "DB Connection Unsuccessful: " . $th->getMessage();
        }
    }

    public function closeConnection()
    {

        $this->con = null;
    }

    public function addproduct()
    {

        if (isset($_POST["addproduct"])) {

            $productname = $_POST["name"];
            $productcategory = $_POST["category"];
            $price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $date = $_POST["date"];

            try {

                $connection = $this->openConnection();
                $query = "INSERT INTO product_table (product_name, category_id, product_price, quantity, restock_date)
                VALUES (?,?,?,?,?)";

                $stmt = $connection->prepare($query);
                $stmt->execute([$productname, $productcategory, $price, $quantity, $date]);

                header("Location: index.php?msg=New record created successfully");
                exit();
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }

    // add ug bag-ong category
    public function addCategory()
    {
        if (isset($_POST["add_category"])) {
            $categoryname = $_POST["new_category"];

            try {

                $connection = $this->openConnection();
                $query = "INSERT INTO categories (category) VALUES (?)";

                $stmt = $connection->prepare($query);
                $stmt->execute([$categoryname]);

                header("Location: index.php?msg=CAtegory Added");
                exit();
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }

    public function updateProduct()
    {

        if (isset($_POST['update_product'])) {
            $product_id = $_POST['id'];
            $product_name = $_POST['product_name'];
            $category = $_POST['category'];
            $price = $_POST['unit_price'];
            $quantity = $_POST['quantity'];
            $restock_date = $_POST['restock_date'];

            try {

                $connection = $this->openConnection();

                $stmt = $connection->prepare("UPDATE product_table 
                                                  SET product_name = :product_name, 
                                                      category = :category, 
                                                      unit_price = :unit_price, 
                                                      quantity = :quantity, 
                                                      restock_date = :restock_date
                                                  WHERE product_id = :product_id");

                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':product_name', $product_name);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':unit_price', $price);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':restock_date', $restock_date);

                $stmt->execute();

                header("Location: index.php?msg=Record updated successfully");
                exit();
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }

    public function deleteProduct()
    {

        if (isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];

            try {

                $connection = $this->openConnection();
                $query = "DELETE FROM product_table WHERE product_id = :product_id";
                $stmt = $connection->prepare($query);

                $query_execute = $stmt->execute(["product_id" => $product_id]);

                if ($query_execute) {
                    header("Location: index.php?msg=User deleted successfully");
                }
            } catch (PDOException $th) {
                echo "" . $th->getMessage();
            }
        }
    }

    public function getCategories()
    {
        try {
            $connection = $this->openConnection();
            $query = "SELECT category_id, category FROM categories";
            $stmt = $connection->prepare($query);
            $stmt->execute();

            $categories = $stmt->fetchAll();

            return $categories;
        } catch (PDOException $th) {
            echo "Error: " . $th->getMessage();
        }
    }

    public function userRegistration()
    {

        if (isset($_POST['register'])) {
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $address = $_POST['address'];
            $birthdate = $_POST['birthdate'];
            $gender = $_POST['gender'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            try {

                $connection = $this->openConnection();
                $query = "INSERT INTO user_data (first_name, last_name, address, birthdate, gender, username, password, date_created) VALUES (?, ?, ?, ?, ?, ?, ?)";

                $stmt = $connection->prepare($query);
                $stmt->execute([$firstname, $lastname, $address, $birthdate, $gender, $username, $password]);

                header("Location: login.php?msg=User Registration Successfully");
                exit();
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }

    public function addCart()
    {

        if (isset($_POST['addtocart_btn'])) {

            $product_name = $_POST['product_name'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $totalpayable = $quantity * $price;

            try {
                $connection = $this->openConnection();
                $query = "INSERT INTO customer_cart (product_name, quantity, product_price, payable) VALUES (?,?,?,?)";
                $stmt = $connection->prepare($query);
                $stmt->execute([$product_name, $quantity, $price, $totalpayable]);

                header("Location: customer_feed.php?msg=item added to cart");
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }
    public function getItems()
    { 
        {
            try {
                $connection = $this->openConnection();
                $query = "SELECT product_name, quantity, product_price FROM product_table";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $items = $stmt->fetchAll();

                return $items;
            } catch (PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }

    public function getCartItems(){
        {
            try{
                $connection = $this->openConnection();
                $query = "SELECT product_name, quantity, product_price, payable FROM customer_cart";
                $stmt = $connection->prepare($query);
                $stmt->execute();

                $items = $stmt->fetchAll();

                return $items;
            }catch(PDOException $th){
                echo "Error: " . $th->getMessage();
            }
        }
    }
}