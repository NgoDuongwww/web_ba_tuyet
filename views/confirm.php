<?php 
include_once '../includes/db_connect.php';
include_once '../includes/header.php';

// Kiểm tra nếu order_id tồn tại trong URL
if (!isset($_GET['order_id'])) {
    echo "Lỗi: Không tìm thấy đơn hàng.";
    exit();
}

$order_id = $_GET['order_id'];

// Lấy thông tin đơn hàng từ cơ sở dữ liệu
$order_query = "
    SELECT o.total_price, o.delivery_method, o.payment_method, o.user_id, o.address, o.city, o.district, o.ward, o.street, o.note
    FROM orders o
    WHERE o.id = ?
";

$stmt = $conn->prepare($order_query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    echo "Lỗi: Đơn hàng không tồn tại.";
    exit();
}

$order = $order_result->fetch_assoc();

// Lấy thông tin người dùng từ bảng `user` dựa vào `user_id` trong đơn hàng
$user_query = "
    SELECT u.name, u.email, u.phone 
    FROM user u
    WHERE u.id = ?
";

$stmt = $conn->prepare($user_query);
$stmt->bind_param('i', $order['user_id']);
$stmt->execute();
$user_result = $stmt->get_result();

if ($user_result->num_rows === 0) {
    echo "Lỗi: Không tìm thấy thông tin người dùng.";
    exit();
}

$user = $user_result->fetch_assoc();

// Lấy các sản phẩm trong đơn hàng
$order_items_query = "
    SELECT p.name, oi.quantity, oi.price 
    FROM order_items oi
    JOIN product p ON oi.product_id = p.id
    WHERE oi.order_id = ?
";

$stmt = $conn->prepare($order_items_query);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order_items_result = $stmt->get_result();
$order_items = $order_items_result->fetch_all(MYSQLI_ASSOC); // Lấy tất cả sản phẩm cho đơn hàng
?>

<div class="container">
  <!-- Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1>Đặt hàng thành công</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Đặt hàng thành công</span>
    </div>
  </div>
  
  <div class="confirm">
    <div class="confirm__content">
      <h1>Cảm ơn bạn đã đặt hàng</h1>
      <span>Một email xác nhận đã được gửi tới <?php echo htmlspecialchars($user['email']); ?>. Xin vui lòng kiểm tra email của bạn.</span>
      
      <div class="confirm__content__info">
        
        <!-- Thông tin khách hàng -->
        <div class="confirm__content__info__item">
          <h3>Thông tin mua hàng</h3>
          <p><?php echo count($order_items); ?> sản phẩm</p>
          <p>Tên: <?php echo htmlspecialchars($user['name']); ?></p>
          <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
          <p>Số điện thoại: <?php echo htmlspecialchars($user['phone']); ?></p>
        </div>

        <!-- Địa chỉ nhận hàng -->
        <div class="confirm__content__info__item">
          <h3>Địa chỉ nhận hàng</h3>
          <p><?php echo htmlspecialchars($order['address']); ?></p>
          <p><?php echo htmlspecialchars($order['ward']) . ', ' . htmlspecialchars($order['district']) . ', ' . htmlspecialchars($order['city']); ?></p>
          <p>Số điện thoại: <?php echo htmlspecialchars($user['phone']); ?></p>
        </div>

        <!-- Phương thức thanh toán -->
        <div class="confirm__content__info__item">
          <h3>Phương thức thanh toán</h3>
          <p><?php echo ($order['payment_method'] === 'COD') ? 'Thanh toán khi giao hàng (COD)' : 'Thanh toán trực tuyến'; ?></p>
        </div>

        <!-- Phương thức vận chuyển -->
        <div class="confirm__content__info__item">
          <h3>Phương thức vận chuyển</h3>
          <p><?php echo ($order['delivery_method'] === 'standard') ? 'Giao hàng tiêu chuẩn' : 'Giao hàng nhanh'; ?></p>
        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="confirm__content__info__item">
          <h3>Chi tiết sản phẩm</h3>
          <?php foreach ($order_items as $item): ?>
            <p><?php echo htmlspecialchars($item['name']); ?> - Số lượng: <?php echo $item['quantity']; ?> - Giá: <?php echo number_format($item['price'], 0, ',', '.'); ?>₫</p>
          <?php endforeach; ?>
        </div>

        <!-- Tổng tiền -->
        <div class="confirm__content__info__item">
          <h3>Tổng tiền</h3>
          <p><?php echo number_format($order['total_price'], 0, ',', '.'); ?>₫</p>
        </div>
      </div>
      
      <a class="confirm__content__button" href="/index.php">Tiếp tục mua hàng</a>
    </div>
  </div>
</div>

<?php include_once '../includes/footer.php'; ?>
