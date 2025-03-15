<?php
include_once "../includes/db_connect.php";

// Xử lý thêm sản phẩm mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $description = $_POST['product_description'];
    $quantity = $_POST['product_quantity'];
    $status = $_POST['product_status'];
    $category_id = $_POST['product_category']; // Lấy category từ form
    
    // Xử lý ảnh chính
    $image = $_FILES['product_image']['name'];
    $uploadDir = '../../public/images/item/'; // Đường dẫn lưu ảnh chính và ảnh phụ
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Tạo thư mục nếu chưa tồn tại
    }
    $target_main = $uploadDir . basename($image);
    
    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_main)) {
        // Thêm sản phẩm vào bảng `product` với category_id
        $sql = "INSERT INTO product (name, price, description, image, quantity, status, category_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdssiii", $name, $price, $description, $image, $quantity, $status, $category_id);
        $stmt->execute();
        $product_id = $conn->insert_id;

        // Xử lý ảnh phụ (nếu có)
        if (!empty($_FILES['product_images']['name'][0])) {
            foreach ($_FILES['product_images']['name'] as $key => $image_name) {
                if (!empty($image_name)) {
                    $target = $uploadDir . basename($image_name);
                    if (move_uploaded_file($_FILES['product_images']['tmp_name'][$key], $target)) {
                        // Lưu ảnh phụ vào bảng `product_images`
                        $sql = "INSERT INTO product_images (product_id, image_url) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("is", $product_id, $image_name);
                        $stmt->execute();
                    }
                }
            }
        }
        echo "Product added successfully!";
    } else {
        echo "Error uploading main image.";
    }
}

// Lấy danh sách sản phẩm hiện có
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="../../admin/assets/product.css">
<h2>Product Management</h2>

<!-- Form thêm sản phẩm -->
<form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="add_product" value="1">
    
    <div class="form-group">
        <label for="product_name">Product Name</label>
        <input type="text" name="product_name" id="product_name" required>
    </div>
    
    <div class="form-group">
        <label for="product_price">Price (₫)</label>
        <input type="number" name="product_price" id="product_price" required min="0" step="0.01">
    </div>
    
    <div class="form-group">
        <label for="product_description">Description</label>
        <textarea name="product_description" id="product_description" required></textarea>
    </div>
    
    <div class="form-group">
        <label for="product_image">Main Product Image</label>
        <input type="file" name="product_image" id="product_image" accept="image/*" required>
    </div>
    
    <div class="form-group" id="additional-images">
        <label for="product_images">Additional Images</label>
        <input type="file" name="product_images[]" accept="image/*">
    </div>
    
    <!-- Nút thêm ảnh phụ -->
    <button type="button" onclick="addImageField()" class="btn">Thêm ảnh phụ</button>
    
    <div class="form-group">
        <label for="product_quantity">Quantity</label>
        <input type="number" name="product_quantity" id="product_quantity" required min="0">
    </div>
    
    <div class="form-group">
        <label for="product_status">Status</label>
        <select name="product_status" id="product_status" required>
            <option value="1">In Stock</option>
            <option value="0">Out of Stock</option>
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
                echo "<option value='" . $category['id'] . "'>" . htmlspecialchars($category['name']) . "</option>";
            }
            ?>
        </select>
    </div>

    <button type="submit" class="btn">Add Product</button>
</form>

<h2>Product List</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Description</th>
        <th>Main Image</th>
        <th>Additional Images</th>
        <th>Quantity</th>
        <th>Status</th>
        <th>Category</th> <!-- Thêm cột Category -->
        <th>Actions</th>
    </tr>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?php echo htmlspecialchars($product['name']); ?></td>
        <td><?php echo htmlspecialchars($product['price']); ?> ₫</td>
        <td><?php echo htmlspecialchars($product['description']); ?></td>
        
        <!-- Hiển thị ảnh chính -->
        <td><img src="../../public/images/item/<?php echo htmlspecialchars($product['image']); ?>" width="50"></td>
        
        <!-- Hiển thị ảnh phụ -->
        <td>
            <?php
            $sql_images = "SELECT image_url FROM product_images WHERE product_id = ?";
            $stmt_images = $conn->prepare($sql_images);
            $stmt_images->bind_param("i", $product['id']);
            $stmt_images->execute();
            $additional_images = $stmt_images->get_result()->fetch_all(MYSQLI_ASSOC);
            
            foreach ($additional_images as $img) {
                echo "<img src='../../public/images/item/" . htmlspecialchars($img['image_url']) . "' width='30'> ";
            }
            ?>
        </td>
        
        <td><?php echo htmlspecialchars($product['quantity']); ?></td>
        <td><?php echo $product['status'] ? 'In Stock' : 'Out of Stock'; ?></td>
        
        <!-- Hiển thị tên category -->
        <td>
            <?php
            $category_id = $product['category_id'];
            $sql_category = "SELECT name FROM category WHERE id = ?";
            $stmt_category = $conn->prepare($sql_category);
            $stmt_category->bind_param("i", $category_id);
            $stmt_category->execute();
            $result_category = $stmt_category->get_result();
            $category = $result_category->fetch_assoc();
            echo htmlspecialchars($category['name']);
            ?>
        </td>
        
        <td>
            <a href="../../admin/tabs/edit_product.php?id=<?php echo $product['id']; ?>">Edit</a> |
            <a href="../../admin/tabs/delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<script>
// JavaScript to dynamically add additional image input fields
function addImageField() {
    const additionalImagesContainer = document.getElementById('additional-images');
    const newInput = document.createElement('input');
    newInput.type = 'file';
    newInput.name = 'product_images[]';
    newInput.accept = 'image/*';
    additionalImagesContainer.appendChild(newInput);
}
</script>
