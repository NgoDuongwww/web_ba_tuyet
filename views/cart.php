<?php
include_once '../includes/header.php';
include_once '../includes/db_connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra và bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Kiểm tra session user_id
if (!isset($_SESSION['user_id'])) {
  echo "<p>Bạn cần đăng nhập để xem giỏ hàng.</p>";
  include_once '../includes/footer.php';
  exit;
}

$user_id = $_SESSION['user_id']; // Lấy ID người dùng từ session

// Truy vấn danh sách sản phẩm trong giỏ hàng của user
$query = "
    SELECT c.id AS cart_item_id, p.id AS product_id, p.image, p.name, p.price, c.quantity 
    FROM cart_items c
    JOIN product p ON c.product_id = p.id
    WHERE c.user_id = ?
";
$stmt = $conn->prepare($query);

if (!$stmt) {
  die("Lỗi chuẩn bị truy vấn: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Tính tổng tiền từ các sản phẩm trong giỏ hàng
$total_price = 0;
foreach ($cart_items as $item) {
  $total_price += $item['price'] * $item['quantity'];
}

// Xử lý khi người dùng đặt hàng

?>

<div class="container">
  <!-- Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1>Giỏ hàng</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Giỏ hàng</span>
    </div>
  </div>

  <!-- Cart -->
  <div class="cart">
    <div class="cart__item">
      <div class="cart__item__title">
        <h1>Giỏ hàng của bạn (<?php echo count($cart_items); ?> sản phẩm)</h1>
      </div>

      <!-- Hiển thị giỏ hàng -->
      <?php if (!empty($cart_items)): ?>
        <?php foreach ($cart_items as $item): ?>
          <div class="cart__item__content">
            <div class="cart__item__content__item col-1">
              <img src="../public/images/item/<?php echo htmlspecialchars($item['image']); ?>" alt="cart">
            </div>
            <div class="cart__item__content__item col-2">
              <p><?php echo htmlspecialchars($item['name']); ?></p>
              <span><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</span>
            </div>
            <div class="cart__item__content__item col-3">
              <form action="../views/update_cart.php" method="POST">
                <button type="submit" name="action" value="decrease"><i class="fa-solid fa-minus"></i></button>
                <span><?php echo $item['quantity']; ?></span>
                <button type="submit" name="action" value="increase"><i class="fa-solid fa-plus"></i></button>
                <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
              </form>
            </div>
            <div class="cart__item__content__item col-4">
              <p>Tổng tiền</p>
              <span><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>₫</span>
              <a href="../views/delete_cart_item.php?id=<?php echo $item['cart_item_id']; ?>">
                <i class="fa-solid fa-trash"></i> Xóa
              </a>
            </div>
          </div>
        <?php endforeach; ?>

        <!-- Tổng giá trị giỏ hàng -->
        <div class="cart__total">
          <p>Thành tiền</p>
          <span><?php echo number_format($total_price, 0, ',', '.'); ?>₫</span>
        </div>

        <!-- Nút điều hướng -->
        <div class="cart__button">
          <a class="cart__button__continue" href="/index.php">Tiếp tục mua hàng</a>
          <a class="cart__button__checkout" href="/views/checkout1.php">Đặt hàng ngay</a>
        </div>
      <?php else: ?>
        <a class="cart__button__continue" href="/index.php">Tiếp tục mua sắm</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include_once '../includes/footer.php'; ?>