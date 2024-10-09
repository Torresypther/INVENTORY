<link rel="stylesheet" href="edit.css">

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
