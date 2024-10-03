<?php
// Include the database initialization file
include('dbinit.php');

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_stmt = $conn->prepare("DELETE FROM shoes WHERE ShoeID = ?");
    $delete_stmt->bind_param("i", $delete_id);
    
    if ($delete_stmt->execute()) {
        echo "<div class='alert alert-success'>Shoe deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting shoe: " . $delete_stmt->error . "</div>";
    }
    $delete_stmt->close();
}

// Handle update operation (this is done via modal and POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $shoe_name = $_POST['ShoeName'];
    $shoe_desc = $_POST['ShoeDescription'];
    $quantity = $_POST['QuantityAvailable'];
    $price = $_POST['Price'];
    $shoe_type = $_POST['ShoeType'];
    $shoe_color = $_POST['ShoeColor'];
    
    if (!empty($shoe_name) && !empty($shoe_desc) && !empty($quantity) && !empty($price) && !empty($shoe_type) && !empty($shoe_color)) {
        $update_stmt = $conn->prepare("UPDATE shoes SET ShoeName=?, ShoeDescription=?, QuantityAvailable=?, Price=?, ShoeType=?, ShoeColor=? WHERE ShoeID=?");
        $update_stmt->bind_param("ssisssi", $shoe_name, $shoe_desc, $quantity, $price, $shoe_type, $shoe_color, $edit_id);
        
        if ($update_stmt->execute()) {
            echo "<div class='alert alert-success'>Shoe updated successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error updating shoe: " . $update_stmt->error . "</div>";
        }
        $update_stmt->close();
    }
}

// Fetch all shoes from the database
$sql = "SELECT * FROM shoes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shoes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f0f4f8;
        }
        h1 {
            color: #9b59b6;
            margin-top: 30px;
            margin-bottom: 20px;
            text-align: center;
        }
        .table {
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #9b59b6;
            color: white;
        }
        .table td {
            vertical-align: middle;
        }
        .btn-primary {
            background-color: #e74c3c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #c0392b;
        }
        .btn-add {
            background-color: #16a085;
            border: none;
            color: #fff;
        }
        .btn-add:hover {
            background-color: #13856d;
            color: #fff;
        }
        .btn-edit {
            /* background-color: #f1c40f; */
            border: none;
            color: #43A047;
            padding: 5px 10px;
           
        }
        
        .btn-delete {
            /* background-color: #ff4757; */
            border: none;
            color: #ec0e29;
            padding: 5px 10px;
            
        }
        
        .fa-pencil-alt {
            color: #43A047;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View All Shoes</h1>
        
        <!-- Link to Add Shoe Page -->
        <div class="text-right mb-3">
            <a href="add_shoe.php" class="btn btn-add">Add New Shoe</a>
        </div>
        
        <!-- Table for displaying shoes -->
        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr>
                    <th>Shoe Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Color</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['ShoeName']}</td>";
                        echo "<td>{$row['ShoeDescription']}</td>";
                        echo "<td>{$row['QuantityAvailable']}</td>";
                        echo "<td>\${$row['Price']}</td>";
                        echo "<td>{$row['ShoeType']}</td>";
                        echo "<td>{$row['ShoeColor']}</td>";
                        echo "<td>
                                <a href='#editModal' class='btn-edit' data-toggle='modal' data-id='{$row['ShoeID']}' data-name='{$row['ShoeName']}' data-desc='{$row['ShoeDescription']}' data-quantity='{$row['QuantityAvailable']}' data-price='{$row['Price']}' data-type='{$row['ShoeType']}' data-color='{$row['ShoeColor']}'><i class='fas fa-pencil-alt'></i></a>
                                <a href='?delete_id={$row['ShoeID']}' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this item?\")'><i class='fas fa-trash-alt'></i></a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No shoes found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="view_shoes.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Shoe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label for="ShoeName">Shoe Name</label>
                            <input type="text" class="form-control" id="edit_name" name="ShoeName" required>
                        </div>
                        <div class="form-group">
                            <label for="ShoeDescription">Description</label>
                            <textarea class="form-control" id="edit_desc" name="ShoeDescription" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="QuantityAvailable">Quantity Available</label>
                            <input type="number" class="form-control" id="edit_quantity" name="QuantityAvailable" required>
                        </div>
                        <div class="form-group">
                            <label for="Price">Price</label>
                            <input type="number" step="0.01" class="form-control" id="edit_price" name="Price" required>
                        </div>
                        <div class="form-group">
                            <label for="ShoeType">Shoe Type</label>
                            <select class="form-control" id="edit_type" name="ShoeType" required>
                                <option value="Sneaker">Sneaker</option>
                                <option value="Running Shoe">Running Shoe</option>
                                <option value="Formal Shoe">Formal Shoe</option>
                                <option value="Casual Shoe">Casual Shoe</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ShoeColor">Shoe Color</label>
                            <input type="text" class="form-control" id="edit_color" name="ShoeColor" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript for Bootstrap Modals -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script to populate the Edit Modal with existing data -->
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id');
            var name = button.data('name');
            var desc = button.data('desc');
            var quantity = button.data('quantity');
            var price = button.data('price');
            var type = button.data('type');
            var color = button.data('color');

            var modal = $(this);
            modal.find('#edit_id').val(id);
            modal.find('#edit_name').val(name);
            modal.find('#edit_desc').val(desc);
            modal.find('#edit_quantity').val(quantity);
            modal.find('#edit_price').val(price);
            modal.find('#edit_type').val(type);
            modal.find('#edit_color').val(color);
        });
    </script>
</body>
</html>
