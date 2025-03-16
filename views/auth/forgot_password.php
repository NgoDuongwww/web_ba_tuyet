<?php
$title = "Quên mật khẩu";
include_once "../../includes/header.php";
?>
<div class="container">
  <!-- Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1>Quên mật khẩu</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Quên mật khẩu</span>
    </div>
  </div>
  <!-- Form -->
  <div class="auth">
    <h1>Quên mật khẩu</h1>
    <form action="" method="post">
      <input autofocus autocomplete="off" type="email" name="email" placeholder="Email">
      <button type="submit">Gửi mã</button>
    </form>
  </div>
</div>
<?php
include_once "../../includes/footer.php";
?>