<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-3">
      <div class="modal-header" style="background-color: #19323C; color: white;">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label for="new_category" class="form-label">Category Name</label>
            <input type="text" name="new_category" id="new_category" class="form-control" placeholder="Enter category name" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="add_category">Add Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
  .modal-dialog-centered {
    max-width: 400px;
  }

  .modal-content {
    border-radius: 10px;
    background-color: #F3F7F0;
    border: none;
  }

  .modal-header {
    border-bottom: 2px solid white;
    padding: 10px;
    
  }

  .modal-title {
    font-size: 1.25rem;
    font-weight: bold;
  }

  .modal-body {
    padding: 20px;
  }

  .form-label {
    font-weight: 400;
    color: #19323C;
  }

  .form-control {
    border-radius: 8px;
    border: 1px solid #ddd;
    margin-top: 15px;
    padding: 12px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    height: 40px;
  }

  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
  }

  .modal-footer button {
    font-size: 1rem;
    padding: 8px 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }

  .modal-footer .btn-primary {
    background-color: #007e2e;
    border: none;
  }

  .modal-footer .btn-primary:hover {
    background-color: #00712d;
    color: white;
  }

  .modal-footer .btn-secondary {
    background-color: #b71e1e;
    border: none;
  }

  .modal-footer .btn-secondary:hover {
    background-color: #981c1c;
    color: white;
  }

  .btn-close {
    background-color: transparent;
    border: none;
    color: white;
  }
</style>
