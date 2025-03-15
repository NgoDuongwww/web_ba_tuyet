<?php
include_once '../includes/db_connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra xem có hành động và cart_item_id không
if (isset($_POST['action']) && isset($_POST['cart_item_id'])) {
    $action = $_POST['action'];
    $cart_item_id = $_POST['cart_item_id'];

    // Truy vấn lấy thông tin giỏ hàng
    $stmt = $conn->prepare("SELECT * FROM cart_items WHERE id = ?");
    $stmt->bind_param("i", $cart_item_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart_item = $result->fetch_assoc();

    if ($cart_item) {
        $new_quantity = $cart_item['quantity'];

        // Tăng hoặc giảm số lượng sản phẩm trong giỏ hàng
        if ($action == 'increase') {
            $new_quantity++;
        } elseif ($action == 'decrease' && $new_quantity > 1) {
            $new_quantity--;
        }

        // Cập nhật lại số lượng trong giỏ hàng
        $update_stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $update_stmt->bind_param("ii", $new_quantity, $cart_item_id);
        $update_stmt->execute();
    }

    // Chuyển hướng về trang giỏ hàng
    header("Location: /views/cart.php");
    exit;
}
?>
