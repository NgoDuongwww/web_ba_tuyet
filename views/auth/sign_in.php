<?php
$title = "Đăng nhập";
include_once "../../includes/header.php";
include_once "../../includes/db_connect.php"; // Kết nối với cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra email trong cơ sở dữ liệu
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu trực tiếp (không mã hóa)
        if ($password == $user['password']) {
            // Đăng nhập thành công, tạo session
            session_start();
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: /index.php");
            exit();
        } else {
            echo "Mật khẩu không đúng.";
        }
    } else {
        echo "Email không tồn tại.";
    }
    $stmt->close();
}
?>

<div class="container">
  <!-- Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1>Đăng nhập</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Đăng nhập</span>
    </div>
  </div>
  <!-- Form -->
  <div class="auth">
    <h1>Đăng nhập</h1>
    <form action="" method="post">
      <input autofocus autocomplete="off" type="email" name="email" placeholder="Email" required>
      <input autocomplete="off" type="password" name="password" placeholder="Mật khẩu" required>
      <button type="submit">Đăng nhập</button>
    </form>
    <!-- Forgot Password -->
    <div class="auth__forgot">
      <a href="/views/auth/forgot_password.php">Quên mật khẩu?</a>
    </div>
    <!-- Register -->
    <div class="auth__register">
      <p>Bạn chưa có tài khoản? <a style="color: var(--orange-color);" href="/views/auth/sign_up.php">Đăng ký tại đây</a></p>
    </div>
  </div>
</div>
<?php
include_once "../../includes/footer.php";
?>
