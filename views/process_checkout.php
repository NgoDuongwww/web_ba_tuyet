<?php
include_once '../includes/db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<p>Bạn cần đăng nhập để đặt hàng.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    // Kiểm tra tính hợp lệ
    if (empty($name) || empty($address) || empty($phone)) {
        echo "<p>Vui lòng điền đầy đủ thông tin giao hàng.</p>";
        exit;
    }

    // Lấy thông tin giỏ hàng, bao gồm cả hình ảnh sản phẩm
    $cart_query = "
        SELECT c.product_id, c.quantity, p.price, p.image
        FROM cart_items c
        JOIN product p ON c.product_id = p.id
        WHERE c.user_id = ?
    ";
    $stmt = $conn->prepare($cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_result = $stmt->get_result();
    $cart_items = $cart_result->fetch_all(MYSQLI_ASSOC);

    if (empty($cart_items)) {
        echo "<p>Giỏ hàng của bạn đang trống.</p>";
        exit;
    }

    // Tính tổng tiền
    $total_price = 0;
    foreach ($cart_items as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Lưu đơn hàng vào bảng `orders`
    $order_query = "
        INSERT INTO orders (user_id, name, address, phone, total_price, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ";
    $stmt = $conn->prepare($order_query);
    $stmt->bind_param("isssi", $user_id, $name, $address, $phone, $total_price);
    $stmt->execute();
    $order_id = $stmt->insert_id; // Lấy ID của đơn hàng vừa tạo

    // Lưu thông tin sản phẩm vào bảng `order_items`
    $order_item_query = "
        INSERT INTO order_items (order_id, product_id, quantity, price, image)
        VALUES (?, ?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($order_item_query);
    foreach ($cart_items as $item) {
        $stmt->bind_param("iiids", $order_id, $item['product_id'], $item['quantity'], $item['price'], $item['image']);
        $stmt->execute();
    }

    // Xóa giỏ hàng
    $delete_cart_query = "DELETE FROM cart_items WHERE user_id = ?";
    $stmt = $conn->prepare($delete_cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Chuyển hướng đến trang xác nhận
    header("Location: /views/confirmation.php?order_id=" . $order_id);
    exit;
}
?>
