<?php
include_once '../../includes/db_connect.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
  $new_password = trim($_POST['new_password']);
  $confirm_password = trim($_POST['confirm_password']);

  if (empty($new_password) || empty($confirm_password)) {
    $message = "Vui lòng nhập đầy đủ thông tin.";
  } elseif ($new_password !== $confirm_password) {
    $message = "Mật khẩu không khớp nhau.";
  } else {
    $user_id = intval($_SESSION['user_id']);

    $sql = "UPDATE user SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
      $stmt->bind_param("si", $new_password, $user_id);
      if ($stmt->execute()) {
        $message = "Đổi mật khẩu thành công.";
      } else {
        $message = "Đã xảy ra lỗi. Vui lòng thử lại.";
      }
    } else {
      $message = "Lỗi khi chuẩn bị truy vấn.";
    }
  }
}
?>

<div class="password-change">
  <h2 class="password-change__title">Đổi mật khẩu</h2>
  <p class="password-change__description">
    Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.
  </p>

  <?php if (!empty($message)): ?>
    <div class="password-change__message">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <form method="POST" action="" class="password-change__form">
    <div class="password-change__form-group">
      <label class="password-change__label" for="new-password">Mật khẩu mới</label>
      <input type="password" id="new-password" name="new_password"
        class="password-change__input" placeholder="Nhập mật khẩu mới" required />
    </div>

    <div class="password-change__form-group">
      <label class="password-change__label" for="confirm-password">Xác nhận mật khẩu</label>
      <input type="password" id="confirm-password" name="confirm_password"
        class="password-change__input" placeholder="Xác nhận mật khẩu" required />
    </div>

    <button type="submit" name="change_password"
      class="password-change__submit">
      Xác Nhận
    </button>
  </form>
</div>