<?php
include_once '../includes/db_connect.php';
include_once '../includes/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    echo "<p>Bạn cần đăng nhập để xem giỏ hàng.</p>";
    include_once '../includes/footer.php';
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['order_id']) && is_numeric($_GET['order_id']) && $_GET['order_id'] > 0) {
    $order_id = $_GET['order_id'];

    // Lấy thông tin đơn hàng
    $query = "SELECT * FROM orders WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();

    // Lấy danh sách sản phẩm trong đơn hàng
    $items_query = "
        SELECT oi.product_id, p.name AS product_name, oi.quantity, oi.price, oi.image
        FROM order_items oi
        JOIN product p ON oi.product_id = p.id
        WHERE oi.order_id = ?
    ";
    $stmt = $conn->prepare($items_query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $items_result = $stmt->get_result();
    $order_items = $items_result->fetch_all(MYSQLI_ASSOC);
} else {
    echo "<p>Mã đơn hàng không hợp lệ.</p>";
    exit;
}

if (!$order) {
    echo "<p>Đơn hàng không tồn tại hoặc không thuộc về bạn.</p>";
    exit;
}
?>

<link rel="stylesheet" href="/public/css/confirmation.css">
<div class="container">
    <h1>Đặt hàng thành công!</h1>
    <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xác nhận.</p>
    <p><strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
    <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total_price'], 0, ',', '.'); ?>₫</p>
    <p><strong>Thông tin giao hàng:</strong> <?php echo htmlspecialchars($order['address']); ?></p>

    <h2>Chi tiết đơn hàng</h2>
    <table class="order-details">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><img src="../public/images/item/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="product-image"></td>
                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</td>
                    <td><?php echo number_format($item['quantity'] * $item['price'], 0, ',', '.'); ?>₫</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="/index.php">Quay lại trang chủ</a>
</div>

<?php include_once '../includes/footer.php'; ?>