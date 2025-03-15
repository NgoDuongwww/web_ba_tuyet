<?php
// Kết nối cơ sở dữ liệu
include_once 'D:/ba-tuyet/includes/db_connect.php'; // Đường dẫn đầy đủ đến db_connect.php

// Kiểm tra xem người dùng có đăng nhập hay không
session_start();
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "Bạn cần đăng nhập để hủy đơn hàng.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Kiểm tra xem có thông tin đơn hàng và lý do hủy không
if (isset($_POST['order_id']) && isset($_POST['cancel_reason']) && !empty($_POST['cancel_reason'])) {
    $order_id = intval($_POST['order_id']);
    $cancel_reason = mysqli_real_escape_string($conn, $_POST['cancel_reason']);

    // Kiểm tra xem đơn hàng có thuộc về người dùng không và trạng thái có phải là "pending"
    $sql = "SELECT * FROM orders WHERE id = ? AND user_id = ? AND status = 'pending' AND is_canceled = 0"; // Kiểm tra đơn hàng chưa bị hủy
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Cập nhật trạng thái đơn hàng thành "canceled" và lưu lý do hủy
        $sql_update = "UPDATE orders SET status = 'canceled', is_canceled = 1, cancel_reason = ?, canceled_at = NOW() WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $cancel_reason, $order_id);
        if ($stmt_update->execute()) {
            echo "Đơn hàng đã được hủy thành công.";
        } else {
            echo "Đã có lỗi xảy ra khi hủy đơn hàng.";
        }
    } else {
        echo "Không tìm thấy đơn hàng hoặc đơn hàng không thể hủy.";
    }
} else {
    echo "Vui lòng cung cấp đầy đủ thông tin lý do hủy đơn hàng.";
}
?>
