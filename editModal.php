<div class="modal fade" id="editModal<?php echo $row->product_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal-size">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Product Information</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form class="form-update" action="index.php" method="post">

          <input type="hidden" name="id" value="<?php echo $row->product_id; ?>">

          <div class="mb-3">
            <label class="form-label">Product Name:</label>
            <input type="text" class="form-control" name="product_name" value="<?php echo htmlspecialchars($row->product_name, ENT_QUOTES); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Category:</label>
            <select class="form-select" name="category" required>
              <option value="" disabled>Select Category</option>
              <option value="Kitchen Essentials" <?php echo ($row->category == "Kitchen Essentials") ? 'selected' : ''; ?>>Kitchen Essentials</option>
              <option value="Laundry Essentials" <?php echo ($row->category == "Laundry Essentials") ? 'selected' : ''; ?>>Laundry Essentials</option>
              <option value="Canned Goods" <?php echo ($row->category == "Canned Goods") ? 'selected' : ''; ?>>Canned Goods</option>
              <option value="Noodles" <?php echo ($row->category == "Noodles") ? 'selected' : ''; ?>>Noodles</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Unit Price:</label>
            <input type="number" class="form-control" name="unit_price" placeholder="Enter unit price" value="<?php echo htmlspecialchars($row->unit_price); ?>" min="0" step="0.01" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Quantity:</label>
            <input type="number" class="form-control" name="quantity" placeholder="Enter quantity" value="<?php echo htmlspecialchars($row->quantity); ?>" min="0" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Restock Date:</label>
            <input type="date" class="form-control" name="restock_date" value="<?php echo htmlspecialchars($row->restock_date); ?>" required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btnClose btn" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btnUpdate btn" name="update_product">Update Product</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<style>
  .modal-content{
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
    background-color: #F3F7F0;
}

.form-update {
    font-family: Arial, sans-serif;
    max-width: 800px;
    padding-left: 20px;
    padding-right: 20px;
    margin: 0 auto;
}

.row {
    display: flex;
    justify-content: space-between;
    gap: 8px;
}

.row .col {
    flex: 1;
}

.mb-3, .mb-4 {
    margin-bottom: 5px;
}

.form-label {
    display: block;
    font-weight: bold;
    margin-bottom: -.5rem;
    font-size: 0.9em;
}

.form-label-gender{
    margin-bottom: -1rem;
}

.form-control {
    width: 100%; 
    padding: 7px;
    font-size: 0.9rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.form-check-input {
    margin-right: 5px;
}

.modal-header {
    background-color: #19323c;
    color: #F3F7F0;
    justify-content: space-around;
}

.modal-footer {
    color: white;
    padding: 10px 5px;
    border-top: none;
    display: flex;
    justify-content: flex-end;
    gap: 5px;
}
.btn-close{
    color:#F3F7F0;
}

button {
    padding: 8px 16px;
    font-size: 0.9em;
}

.btnUpdate {    
    background-color: #019d4f;
    color: white;
}

.btnUpdate:hover {
    background-color: #038946;
}

.btnClose {
    background-color: #dc3545;
    color: white;
}

.btnClose:hover {
    background-color: #c82333;
}
</style>