<?php include_once '../../includes/db_connect.php';

$order = [];

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
  $user_id = intval($_SESSION['user_id']);
  $sql = "SELECT 
                  o.id AS order_id,
                  ot.quantity,
                  p.name AS product_name,
                  p.image AS product_image,
                  ot.price AS product_price,
                  o.total_price,
                  o.status,
                  o.created_at,
                  o.cancel_reason
              FROM orders o
              INNER JOIN order_items ot ON o.id = ot.order_id
              INNER JOIN product p ON ot.product_id = p.id
              WHERE o.user_id =?";

  $stmt = $conn->prepare($sql);

  if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_all(MYSQLI_ASSOC);
  }
}
?>

<div class="order-container">
  <?php if (!empty($order)): ?>
    <?php
    $current_order_id = null;
    $order_total_price = 0;
    ?>
    <?php foreach ($order as $orders): ?>
      <?php if ($current_order_id != $orders['order_id']): ?>
        <!-- Mới bắt đầu một đơn hàng mới -->
        <?php if ($current_order_id !== null): ?>
          <!-- Hiển thị tổng tiền của đơn hàng cũ -->
          <p class="order-summary__total-price">Tổng tiền: <?= number_format($order_total_price) ?> VND</p>
        <?php endif; ?>

        <div class="order-item">
          <div class="order__left">
            <p class="order-item__id">Mã đơn hàng: <?= $orders['order_id'] ?></p>
            <p class="order-item__status">Tình trạng đơn hàng: <?= $orders['status'] ?></p>
            <p class="order-item__date">Ngày đặt: <?= date('d/m/Y', strtotime($orders['created_at'])) ?></p>

            <!-- Hiển thị lý do hủy đơn hàng nếu có -->
            <?php if (!empty($orders['cancel_reason'])): ?>
              <p class="order-item__cancel-reason order-item__cancel-reason--highlight">Lý do hủy: <?= $orders['cancel_reason'] ?></p>
            <?php endif; ?>

            <!-- Hiển thị nút hủy đơn hàng -->
            <?php if ($orders['status'] === 'pending'): ?>
              <form method="POST" action="../../../views/users/tabs/cancel_order.php" class="cancel-order-form">
                <input type="hidden" name="order_id" value="<?= $orders['order_id'] ?>" />
                <button type="button" class="cancel-order-form__button" onclick="showCancelReasonForm(<?= $orders['order_id'] ?>)">Hủy đơn hàng <?= $orders['order_id'] ?></button>
              </form>

              <!-- Form nhập lý do hủy đơn hàng, ẩn ban đầu -->
              <div id="cancel-form-<?= $orders['order_id'] ?>" class="cancel-form" style="display:none;">
                <form method="POST" action="../../../views/users/tabs/cancel_order.php">
                  <textarea name="cancel_reason" class="cancel-form__textarea" required placeholder="Nhập lý do hủy đơn hàng..."></textarea>
                  <input type="hidden" name="order_id" value="<?= $orders['order_id'] ?>" />
                  <button type="submit" class="cancel-form__submit">Xác nhận hủy đơn</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
          <div class="order__right">
            <!-- Hiển thị chi tiết sản phẩm trong đơn hàng -->
            <div class="order-item__product">
              <img src="../../public/images/item/<?= $orders['product_image'] ?>" class="order-item__product-image" width="100px" height="75px" alt="Product Image" />
              <div class="order-item__product-details">
                <h2 class="order-item__product-name"><?= $orders['product_name'] ?></h2>
                <p class="order-item__product-quantity">Số lượng: <?= $orders['quantity'] ?></p>
                <p class="order-item__product-price">Giá: <?= number_format($orders['product_price']) ?> VND</p>
              </div>
            </div>
          </div>
        </div>

        <?php $current_order_id = $orders['order_id']; ?>
        <?php $order_total_price = 0; ?>
      <?php endif; ?>

      <?php
      // Cộng tổng tiền cho đơn hàng
      $order_total_price += $orders['product_price'] * $orders['quantity'];
      ?>
    <?php endforeach; ?>

    <!-- Hiển thị tổng tiền cho đơn hàng cuối cùng -->
    <p class="order-summary__total-price">Tổng tiền: <?= number_format($order_total_price) ?> VND</p>
  <?php else: ?>
    <p class="order-container__no-orders">Không tìm thấy đơn hàng nào.</p>
  <?php endif; ?>
</div>

<script>
  // Hiển thị form lý do hủy khi nhấn nút "Hủy đơn hàng"
  function showCancelReasonForm(order_id) {
    var cancelForm = document.getElementById('cancel-form-' + order_id);
    cancelForm.style.display = 'block';
  }
</script>