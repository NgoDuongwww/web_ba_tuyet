<?php
include_once "../../includes/db_connect.php";

// Kiểm tra xem có id của danh mục không
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Lấy thông tin danh mục
    $sql = "SELECT * FROM category WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();

    if (!$category) {
        echo "Danh mục không tồn tại!";
        exit;
    }
}

// Xử lý cập nhật danh mục
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['category_name'];
    $description = $_POST['category_description'];

    $sql = "UPDATE category SET name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $description, $category_id);
    $stmt->execute();

    echo "Danh mục đã được cập nhật!";
}
?>

<h2>Edit Category</h2>
<style>
    /* General styles for the form and page */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 0;
}

/* Title */
h2 {
    text-align: center;
    margin-top: 30px;
    color: #333;
}

/* Form styles */
form {
    max-width: 600px;
    margin: 0 auto;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Form group for inputs */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    font-size: 16px;
    color: #333;
    display: block;
    margin-bottom: 8px;
}

.form-group input, 
.form-group textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    background-color: #f9f9f9;
}

.form-group input:focus, 
.form-group textarea:focus {
    outline: none;
    border-color: #007BFF;
    background-color: #fff;
}

/* Button style */
button.btn {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    font-size: 16px;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    border: none;
    cursor: pointer;
}

button.btn:hover {
    background-color: #0056b3;
}

/* Optional: Styling for success or error messages */
.success-message {
    color: green;
    font-size: 16px;
    margin-top: 20px;
}

.error-message {
    color: red;
    font-size: 16px;
    margin-top: 20px;
}

</style>
<form action="edit_category.php?id=<?php echo $category['id']; ?>" method="POST">
    <div class="form-group">
        <label for="category_name">Category Name</label>
        <input type="text" name="category_name" id="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="category_description">Description</label>
        <textarea name="category_description" id="category_description"><?php echo htmlspecialchars($category['description']); ?></textarea>
    </div>

    <button type="submit" class="btn">Update Category</button>
</form>
