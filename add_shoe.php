<?php
include('dbinit.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shoe_name = $_POST['ShoeName'];
    $shoe_desc = $_POST['ShoeDescription'];
    $quantity = $_POST['QuantityAvailable'];
    $price = $_POST['Price'];
    $shoe_type = $_POST['ShoeType'];  // New Field (Dropdown)
    $shoe_color = $_POST['ShoeColor'];
    $added_by = "JohnDoe"; // Hardcoded your name

    if (!empty($shoe_name) && !empty($shoe_desc) && !empty($quantity) && !empty($price)) {
        $stmt = $conn->prepare("INSERT INTO shoes (ShoeName, ShoeDescription, QuantityAvailable, Price,ShoeType, ShoeColor, ProductAddedBy) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissss", $shoe_name, $shoe_desc, $quantity, $price,$shoe_type, $shoe_color, $added_by);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Shoe updated successfully!</div>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shoe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        .form-control {
            border-radius: 5px;
        }
        .alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}
        .btn-add {
            background-color: #16a085;
            border: none;
            color: #fff;
            margin-bottom: 30px;
        }
        .btn-add:hover {
            background-color: #13856d;
            color: #fff;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #e74c3c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Shoe</h1>
        
        <!-- Link to View Shoes Page -->
        <div class="text-right mb-3">
            <a href="view_shoes.php" class="btn btn-primary">View All Shoes</a>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label for="ShoeName">Shoe Name</label>
                <input type="text" class="form-control" id="ShoeName" name="ShoeName" required>
            </div>
            <div class="form-group">
                <label for="ShoeDescription">Description</label>
                <textarea class="form-control" id="ShoeDescription" name="ShoeDescription" required></textarea>
            </div>
            <div class="form-group">
                <label for="QuantityAvailable">Quantity Available</label>
                <input type="number" class="form-control" id="QuantityAvailable" name="QuantityAvailable" required>
            </div>
            <div class="form-group">
                <label for="Price">Price</label>
                <input type="number" step="0.01" class="form-control" id="Price" name="Price" required>
            </div>
            <div class="form-group">
                <label for="ShoeType">Shoe Type</label>
                <select class="form-control" id="ShoeType" name="ShoeType" required>
                    <option value="">Select Shoe Type</option>
                    <option value="Sneaker">Sneaker</option>
                    <option value="Running Shoe">Running Shoe</option>
                    <option value="Formal Shoe">Formal Shoe</option>
                    <option value="Casual Shoe">Casual Shoe</option>
                </select>
            </div>
            <div class="form-group">
                <label for="ShoeColor">Shoe Color</label>
                <input type="text" class="form-control" id="ShoeColor" name="ShoeColor" required>
            </div>
            <button type="submit" class="btn btn-add btn-block">Add Shoe</button>
        </form>
    </div>
</body>
</html>
