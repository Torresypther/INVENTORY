<?php
// Initialize a new Connection object
$newconnection = new Connection();

Class Connection {
    // Database connection details
    private $server = "mysql:host=localhost;dbname=sales_inventory";
    private $user = "root";
    private $pass = "";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ); 

    protected $con; // Database connection variable

    // Method to open a connection to the database
    public function openConnection() {
        try {
            // Create a new PDO connection and return it
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;

        } catch (PDOException $th) {
            // Handle connection errors
            echo "DB Connection Unsuccessful: " . $th->getMessage();
        }
    }

    // Method to close the database connection
    public function closeConnection() {

        $this->con = null;
    }

    public function addproduct(){

        if(isset($_POST["addproduct"])){
    
            $productname = $_POST["name"];
            $productcategory = $_POST["category"];
            $unit_price = $_POST["price"];
            $quantity = $_POST["quantity"];
            $date = $_POST["date"];
    
            try{
                // Ensure the connection method is defined in your class
                $connection = $this->openConnection(); 
                $query = "INSERT INTO product_table (product_name, category, unit_price, quantity, restock_date)
                VALUES (?,?,?,?,?)";
                
                $stmt = $connection->prepare($query);
                $stmt->execute([$productname, $productcategory, $unit_price, $quantity, $date]);
    
                // Redirect after successful record creation
                header("Location: index.php?msg=New record created successfully");
                exit(); // Ensure no further code is executed after header redirection
    
            } catch(PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }

    public function updateProduct(){
            // Check if the update form is submitted
            
            if (isset($_POST['update_product'])) {
                // Retrieve data from the POST request
                $product_id = $_POST['id'];
                $product_name = $_POST['product_name'];
                $category = $_POST['category'];
                $price = $_POST['unit_price'];
                $quantity = $_POST['quantity'];
                $restock_date = $_POST['restock_date'];
    
                try {
                    // Open the database connection
                    $connection = $this->openConnection();
    
                    // Prepare the SQL query for updating the user data
                    $stmt = $connection->prepare("UPDATE product_table 
                                                  SET product_name = :product_name, 
                                                      category = :category, 
                                                      unit_price = :unit_price, 
                                                      quantity = :quantity, 
                                                      restock_date = :restock_date
                                                  WHERE product_id = :product_id");
    
                    // Bind parameters to the SQL query
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':product_name', $product_name);
                    $stmt->bindParam(':category', $category);
                    $stmt->bindParam(':unit_price', $price);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':restock_date', $restock_date);
    
                    // Execute the SQL query
                    $stmt->execute();

                    // Redirect to a success message
                    header("Location: index.php?msg=Record updated successfully");
                    exit();

                } catch (PDOException $th) {
                    // Handle any errors during the update
                    echo "Error: " . $th->getMessage();
                }
            }
    }

    public function deleteProduct() {

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
    
}