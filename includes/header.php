<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Ăn cùng Bà Tuyết - Đồ ăn nhanh, ngon miệng, đảm bảo vệ sinh an toàn thực phẩm">
  <title>Ăn cùng Bà Tuyết</title>

  <!-- Favicon -->
  <link rel="icon" href="/public/images/logo.webp" type="image/x-icon">

  <!-- CSS  -->
  <link rel="stylesheet" href="/public/css/main.css">
  <link rel="stylesheet" href="/public/css/style.css">
  <link rel="stylesheet" href="/public/css/sub_page.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
  <header class="header" id="header">
    <div class="header__container space--between">
      <div class="header__logo">
        <a href="/index.php" class="header__logo__link">
          <img src="/public/images/logo.webp" alt="Logo" class="header__logo__img">
        </a>
      </div>
      <div class="header__menu">
        <ul class="header__menu__list center">
          <li class="header__menu__item"><a href="/index.php" class="header__menu__link">Trang chủ</a></li>
          <li class="header__menu__item"><a href="/views/about.php" class="header__menu__link">Giới thiệu</a></li>
          <li class="header__menu__item"><a href="/views/collection.php" class="header__menu__link">Sản phẩm</a></li>
          <li class="header__menu__item"><a href="/views/news.php" class="header__menu__link">Tin tức</a></li>
          <li class="header__menu__item"><a href="/views/contact.php" class="header__menu__link">Liên hệ</a></li>
        </ul>
      </div>
      <div class="header__action center">
        <div class="header__action__search">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div class="header__action__auth center">
          <i class="fa-solid fa-user"></i>
          <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
            <!-- Nếu người dùng đã đăng nhập -->
            <ul class="header__action__auth__list">
              <li class="header__action__auth__item"><a href="/views/users/index.php" class="header__action__auth__link">Tài khoản</a></li>
              <li class="header__action__auth__item"><a href="/views/auth/sign_out.php" class="header__action__auth__link">Đăng xuất</a></li>
            </ul>
          <?php else: ?>
            <!-- Nếu người dùng chưa đăng nhập -->
            <ul class="header__action__auth__list">
              <li class="header__action__auth__item"><a href="/views/auth/sign_in.php" class="header__action__auth__link">Đăng nhập</a></li>
              <li class="header__action__auth__item"><a href="/views/auth/sign_up.php" class="header__action__auth__link">Đăng ký</a></li>
            </ul>
          <?php endif; ?>
        </div>
        <div class="header__action__cart">
          <a href="/views/cart.php" class="header__action__link">
            <i class="fa-solid fa-cart-shopping"></i>
          </a>
        </div>
        <div class="header__action__Notification">
          <a href="#" class="header__action__link">
            <i class="fa-solid fa-bell"></i>
          </a>
        </div>
      </div>
  </header>