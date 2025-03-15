<?php include_once '../../includes/header.php'; ?>
<link rel="stylesheet" href="/views/users/assets/user.css">
<script src="/views/users/assets/user.js"></script>
<div class="container__users">
  <div class="users">
    <div class="users__sidebar">
      <ul class="users__menu">
        <li class="users__menu-item">
          <a href="?tab=user_infor" data-tab="user_infor" class="users__menu-link">Thông tin tài khoản</a>
        </li>
        <li class="users__menu-item">
          <a href="?tab=user_order" data-tab="user_order" class="users__menu-link">Đơn hàng</a>
        </li>
        <li class="users__menu-item">
          <a href="?tab=user_change_password" data-tab="user_change_password" class="users__menu-link">Đổi mật khẩu</a>
        </li>
      </ul>
    </div>
    <div class="users__content" id="tab-content">
      <?php
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'user_infor'; // Kiểm tra tab hiện tại
        switch ($current_tab) {
          case 'user_infor':
            include 'tabs/user_infor.php';
            break;
          case 'user_order':
            include 'tabs/user_order.php';
            break;
          case 'user_change_password':
            include 'tabs/user_change_password.php';
            break;
          default:
            include 'tabs/user_infor.php';
            break;
        }
      ?>
    </div>
  </div>
</div>
<?php include_once '../../includes/footer.php'; ?>