<?php
include_once '../includes/db_connect.php'; // Kết nối cơ sở dữ liệu

if (isset($_GET['id'])) {
    $cart_item_id = $_GET['id'];

    // Xóa sản phẩm khỏi giỏ hàng
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $cart_item_id);
    $stmt->execute();
}

// Chuyển hướng về trang giỏ hàng
header("Location: /views/cart.php");
exit;
?>
