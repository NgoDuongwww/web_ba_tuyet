<?php
include_once '../includes/header.php';
include_once '../includes/db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['user_id'])) {
  echo "<p>Bạn cần đăng nhập để đặt hàng.</p>";
  include_once '../includes/footer.php';
  exit;
}

$user_id = $_SESSION['user_id'];

$query = "
    SELECT c.id AS cart_item_id, p.image, p.name, p.price, c.quantity 
    FROM cart_items c
    JOIN product p ON c.product_id = p.id
    WHERE c.user_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = $result->fetch_all(MYSQLI_ASSOC);

$total_price = 0;
foreach ($cart_items as $item) {
  $total_price += $item['price'] * $item['quantity'];
}
?>

<link rel="stylesheet" href="/public/css/checkout1.css">
<div class="container">
  <div class="container__title">
    <div class="container__title__content">
      <h1>Đặt hàng</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Đặt hàng</span>
    </div>
  </div>

  <div class="checkout">
    <div class="checkout__item">
      <div class="checkout__item__title">
        <h1>Thông tin giỏ hàng của bạn</h1>
      </div>

      <?php if (!empty($cart_items)): ?>
        <div class="checkout__cart">
          <?php foreach ($cart_items as $item): ?>
            <div class="checkout__cart__item">
              <div class="checkout__cart__item__image">
                <img src="/public/images/item/<?php echo htmlspecialchars($item['image']); ?>" alt="cart item">
              </div>
              <div class="checkout__cart__item__details">
                <p><?php echo htmlspecialchars($item['name']); ?></p>
                <span><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</span>
                <p>Số lượng: <?php echo $item['quantity']; ?></p>
                <p>Tổng tiền: <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>₫</p>
              </div>
            </div>
          <?php endforeach; ?>

          <div class="checkout__total">
            <p>Tổng giá trị đơn hàng:</p>
            <span><?php echo number_format($total_price, 0, ',', '.'); ?>₫</span>
          </div>
        </div>

        <div class="checkout__form">
          <h2>Thông tin giao hàng</h2>
          <form action="/views/process_checkout.php" method="POST">
            <div class="form__group">
              <label for="name">Họ và tên:</label>
              <input autocomplete="off" type="text" name="name" id="name" required>
            </div>
            <div class="form__group">
              <label for="address">Địa chỉ giao hàng:</label>
              <input autocomplete="off" type="text" name="address" id="address" required>
            </div>
            <div class="form__group">
              <label for="phone">Số điện thoại:</label>
              <input autocomplete="off" type="text" name="phone" id="phone" required>
            </div>
            <button type="submit" class="checkout__submit">Xác nhận đơn hàng</button>
          </form>
        </div>
      <?php else: ?>
        <p>Giỏ hàng của bạn đang trống. Hãy thêm sản phẩm vào giỏ hàng trước khi đặt hàng.</p>
        <a href="/index.php" class="checkout__continue">Tiếp tục mua hàng</a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include_once '../includes/footer.php'; ?>