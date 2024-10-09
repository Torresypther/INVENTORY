<?php
$newconnection = new Connection();

Class Connection {
    private $server = "mysql:host=localhost;dbname=sales_inventory";
    private $user = "root";
    private $pass = "";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ); 

    protected $con;

    public function openConnection() {
        try {
            $this->con = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->con;

        } catch (PDOException $th) {
            echo "DB Connection Unsuccessful: " . $th->getMessage();
        }
    }

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
 
                $connection = $this->openConnection(); 
                $query = "INSERT INTO product_table (product_name, category, unit_price, quantity, restock_date)
                VALUES (?,?,?,?,?)";
                
                $stmt = $connection->prepare($query);
                $stmt->execute([$productname, $productcategory, $unit_price, $quantity, $date]);
    
                header("Location: index.php?msg=New record created successfully");
                exit();
    
            } catch(PDOException $th) {
                echo "Error: " . $th->getMessage();
            }
        }
    }

    public function updateProduct(){
            
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