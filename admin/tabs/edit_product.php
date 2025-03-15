<?php
include_once "../../includes/db_connect.php";

// Kiểm tra xem có id của sản phẩm cần chỉnh sửa hay không
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Lấy danh sách ảnh phụ của sản phẩm
    $sql_images = "SELECT * FROM product_images WHERE product_id = ?";
    $stmt_images = $conn->prepare($sql_images);
    $stmt_images->bind_param("i", $product_id);
    $stmt_images->execute();
    $result_images = $stmt_images->get_result();
    $additional_images = $result_images->fetch_all(MYSQLI_ASSOC);

    // Kiểm tra nếu sản phẩm không tồn tại
    if (!$product) {
        echo "Sản phẩm không tồn tại!";
        exit;
    }
}

// Xử lý cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $description = $_POST['product_description'];
    $quantity = $_POST['product_quantity'];
    $status = $_POST['product_status'];
    $category_id = $_POST['product_category']; // Lấy category từ form
    $image = $_FILES['product_image']['name'];

    if ($image) {
        // Upload ảnh mới nếu có
        $target = '../../public/images/item/' . basename($image);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target);
    } else {
        // Nếu không có ảnh mới, giữ nguyên ảnh cũ
        $image = $product['image'];
    }

    // Cập nhật dữ liệu vào bảng
    $sql = "UPDATE product SET name = ?, price = ?, description = ?, image = ?, quantity = ?, status = ?, category_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssiiii", $name, $price, $description, $image, $quantity, $status, $category_id, $product_id);
    $stmt->execute();

    // Thêm ảnh phụ nếu có
    if (!empty($_FILES['product_images']['name'][0])) {
        foreach ($_FILES['product_images']['name'] as $key => $additional_image) {
            $additional_image_target = '../../public/images/item/' . basename($additional_image);
            move_uploaded_file($_FILES['product_images']['tmp_name'][$key], $additional_image_target);

            // Lưu ảnh phụ vào bảng product_images
            $sql = "INSERT INTO product_images (product_id, image_url) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $product_id, $additional_image);
            $stmt->execute();
        }
    }

    echo "Sản phẩm đã được cập nhật!";
}
?>

<h2>Edit Product</h2>
<link rel="stylesheet" href="../../admin/assets/product.css">
<!-- Form chỉnh sửa sản phẩm -->
<form action="edit_product.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="product_name">Product Name</label>
        <input type="text" name="product_name" id="product_name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    </div>

    <div class="form-group">
        <label for="product_price">Price (₫)</label>
        <input type="number" name="product_price" id="product_price" value="<?php echo htmlspecialchars($product['price']); ?>" required min="0" step="0.01">
    </div>

    <div class="form-group">
        <label for="product_description">Description</label>
        <textarea name="product_description" id="product_description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="product_image">Main Product Image</label>
        <input type="file" name="product_image" id="product_image" accept="image/*">
        <p>Current image: <img src="../../public/images/item/<?php echo htmlspecialchars($product['image']); ?>" width="50"></p>
    </div>

    <div class="form-group" id="additional-images">
        <label for="product_images">Additional Images</label>
        <?php foreach ($additional_images as $img): ?>
            <div>
                <img src="../../public/images/item/<?php echo htmlspecialchars($img['image_url']); ?>" width="50">
                <a href="../../admin/tabs/delete_image.php?id=<?php echo $img['id']; ?>&product_id=<?php echo $product_id; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </div>
        <?php endforeach; ?>
        <input type="file" name="product_images[]" accept="image/*" multiple>
    </div>
    
    <div class="form-group">
        <label for="product_quantity">Quantity</label>
        <input type="number" name="product_quantity" id="product_quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" required min="0">
    </div>

    <div class="form-group">
        <label for="product_status">Status</label>
        <select name="product_status" id="product_status" required>
            <option value="1" <?php echo $product['status'] == 1 ? 'selected' : ''; ?>>In Stock</option>
            <option value="0" <?php echo $product['status'] == 0 ? 'selected' : ''; ?>>Out of Stock</option>
        </select>
    </div>

    <div class="form-group">
        <label for="product_category">Category</label>
        <select name="product_category" id="product_category" required>
            <?php
            // Lấy danh sách các category từ cơ sở dữ liệu
            $sql_categories = "SELECT * FROM category";
            $result_categories = $conn->query($sql_categories);
            while ($category = $result_categories->fetch_assoc()) {
                $selected = $category['id'] == $product['category_id'] ? 'selected' : '';
                echo "<option value='" . $category['id'] . "' $selected>" . htmlspecialchars($category['name']) . "</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn">Update Product</button>
</form>
