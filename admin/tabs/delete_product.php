<?php
include_once "../../includes/db_connect.php";

// Kiểm tra xem có ID của sản phẩm cần xóa hay không
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Lấy thông tin sản phẩm để xóa ảnh chính
    $sql = "SELECT image FROM product WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    // Nếu sản phẩm tồn tại
    if ($product) {
        // Xóa ảnh chính từ thư mục
        $main_image_path = '../../public/images/item/' . $product['image'];
        if (file_exists($main_image_path)) {
            unlink($main_image_path);
        }

        // Lấy tất cả ảnh phụ liên quan từ bảng product_images
        $sql_images = "SELECT image_url FROM product_images WHERE product_id = ?";
        $stmt_images = $conn->prepare($sql_images);
        $stmt_images->bind_param("i", $product_id);
        $stmt_images->execute();
        $result_images = $stmt_images->get_result();

        // Xóa từng ảnh phụ từ thư mục
        while ($image = $result_images->fetch_assoc()) {
            $additional_image_path = '../../public/images/item/' . $image['image_url'];
            if (file_exists($additional_image_path)) {
                unlink($additional_image_path);
            }
        }

        // Xóa tất cả ảnh phụ từ bảng product_images
        $sql_delete_images = "DELETE FROM product_images WHERE product_id = ?";
        $stmt_delete_images = $conn->prepare($sql_delete_images);
        $stmt_delete_images->bind_param("i", $product_id);
        $stmt_delete_images->execute();

        // Xóa sản phẩm từ bảng product
        $sql_delete_product = "DELETE FROM product WHERE id = ?";
        $stmt_delete_product = $conn->prepare($sql_delete_product);
        $stmt_delete_product->bind_param("i", $product_id);
        $stmt_delete_product->execute();

        echo "Sản phẩm và tất cả ảnh liên quan đã được xóa thành công!";
    } else {
        echo "Sản phẩm không tồn tại!";
    }
} else {
    echo "Không có ID sản phẩm để xóa!";
}
?>
