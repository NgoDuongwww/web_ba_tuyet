<?php
include_once "../../includes/db_connect.php";

// Kiểm tra nếu có ID ảnh phụ cần xóa
if (isset($_GET['image_id'])) {
    $image_id = $_GET['image_id'];

    // Lấy thông tin ảnh từ bảng product_images
    $sql = "SELECT image_url FROM product_images WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $image_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $image = $result->fetch_assoc();

    // Kiểm tra nếu ảnh phụ tồn tại
    if ($image) {
        // Xóa ảnh phụ từ thư mục
        $image_path = '../../public/images/item/' . $image['image_url'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Xóa bản ghi ảnh phụ khỏi bảng product_images
        $sql_delete = "DELETE FROM product_images WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $image_id);
        $stmt_delete->execute();

        echo "Ảnh phụ đã được xóa thành công!";
    } else {
        echo "Ảnh phụ không tồn tại!";
    }
} else {
    echo "Không có ID ảnh phụ để xóa!";
}
