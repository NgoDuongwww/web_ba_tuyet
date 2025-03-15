<?php
include_once "../../includes/db_connect.php";

// Kiểm tra id của danh mục
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    // Xóa danh mục khỏi cơ sở dữ liệu
    $sql = "DELETE FROM category WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();

    echo "Danh mục đã được xóa!";
}
?>
