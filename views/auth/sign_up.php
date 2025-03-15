<?php
$title = "Đăng ký";
include_once "../../includes/header.php";
include_once "../../includes/db_connect.php"; // Kết nối với cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Kiểm tra nếu email đã tồn tại
    $sql = "SELECT * FROM user WHERE email = ? OR name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Tên hoặc email này đã được đăng ký.";
    } else {
        // Không mã hóa mật khẩu, lưu trực tiếp vào cơ sở dữ liệu
        $sql = "INSERT INTO user (name, email, phone, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $phone, $password);

        if ($stmt->execute()) {
            echo "Đăng ký thành công. <a href='/views/auth/login_form.php'>Đăng nhập tại đây</a>";
        } else {
            echo "Có lỗi xảy ra. Vui lòng thử lại.";
        }
    }
    $stmt->close();
}
?>
<div class="container">
  <!-- Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1>Đăng ký tài khoản</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Đăng ký</span>
    </div>
  </div>
  <!-- Form -->
  <div class="auth">
    <h1>Đăng ký tài khoản</h1>
    <form action="" method="post">
      <input autofocus autocomplete="off" type="text" name="name" placeholder="Họ và tên">
      <input autocomplete="off" type="email" name="email" placeholder="Email">
      <input autocomplete="off" type="tel" name="phone" placeholder="Số điện thoại">
      <input autocomplete="off" type="password" name="password" placeholder="Mật khẩu">
      <button type="submit">Đăng ký</button>
    </form>
  </div>
</div>
<?php
include_once "../../includes/footer.php";
?>