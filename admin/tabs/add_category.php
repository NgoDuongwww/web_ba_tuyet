<?php
include_once "../../includes/db_connect.php";

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['category_name'];
    $description = $_POST['category_description'];

    // Chèn vào cơ sở dữ liệu
    $sql = "INSERT INTO category (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);
    $stmt->execute();

    echo "Danh mục đã được thêm!";
}
?>
<style>
    /* General styles for the form */
form {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

/* Title */
h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Styling for the form groups (input fields and labels) */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    color: #333;
}

.form-group input:focus,
.form-group textarea:focus {
    border-color: #007BFF;
    outline: none;
}

/* Styling for the submit button */
button[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #218838;
}

/* Optional: Styling for any success or error messages */
.success-message {
    color: green;
    font-weight: bold;
    text-align: center;
    margin-top: 15px;
}

.error-message {
    color: red;
    font-weight: bold;
    text-align: center;
    margin-top: 15px;
}

</style>
<h2>Add Category</h2>
<link rel="stylesheet" href="../../admin/assets/category.css">
<form action="add_category.php" method="POST">
    <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name" required>
    </div>

    <div class="form-group">
        <label for="category_description">Description</label>
        <textarea name="category_description" id="category_description"></textarea>
    </div>

    <button type="submit" class="btn">Add Category</button>
</form>
