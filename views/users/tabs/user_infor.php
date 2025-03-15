<?php
include_once '../../includes/db_connect.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user_info = $result->fetch_assoc();
} else {
  die("Lỗi khi truy vấn cơ sở dữ liệu.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $new_name = trim($_POST['name']);
  $new_email = trim($_POST['email']);
  $new_phone = trim($_POST['phone']);

  if (empty($new_name) || empty($new_email) || empty($new_phone)) {
    echo "<p class='user-profile__error'>Vui lòng điền đầy đủ thông tin.</p>";
  } else {
    $update_sql = "UPDATE user SET name = ?, email = ?, phone = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);

    if ($update_stmt) {
      $update_stmt->bind_param("sssi", $new_name, $new_email, $new_phone, $user_id);
      if ($update_stmt->execute()) {
        echo "<p class='user-profile__success'>Cập nhật thông tin thành công!</p>";
      } else {
        echo "<p class='user-profile__error'>Lỗi khi cập nhật thông tin. Vui lòng thử lại.</p>";
      }
    } else {
      echo "<p class='user-profile__error'>Lỗi khi chuẩn bị truy vấn. Vui lòng thử lại.</p>";
    }
  }
}
?>

<div class="user-profile">
  <h1 class="user-profile__title">Hồ Sơ Của Tôi</h1>
  <p class="user-profile__description">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>

  <form method="POST" class="user-profile__form">
    <div class="user-profile__form-group">
      <label class="user-profile__label">Tên</label>
      <input type="text" name="name" value="<?= $user_info['name']; ?>"
        class="user-profile__input" />
    </div>

    <div class="user-profile__form-group">
      <label class="user-profile__label">Email</label>
      <input type="email" name="email" value="<?= $user_info['email']; ?>"
        class="user-profile__input" />
    </div>

    <div class="user-profile__form-group">
      <label class="user-profile__label">Số điện thoại</label>
      <input type="text" name="phone" value="<?= $user_info['phone']; ?>"
        class="user-profile__input" />
    </div>

    <div class="user-profile__form-group">
      <label class="user-profile__label">Ngày tạo tài khoản</label>
      <p class="user-profile__static-field">
        <?= date('d/m/Y', strtotime($user_info['created_at'])); ?>
      </p>
    </div>

    <button type="submit" class="user-profile__submit">Lưu</button>
  </form>
</div>