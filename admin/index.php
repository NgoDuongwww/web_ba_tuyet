<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: auth/login_form.php");
  exit();
}

// Lấy vai trò của admin từ session
$admin_role = isset($_SESSION['admin_role']) ? $_SESSION['admin_role'] : '';

// Kiểm tra quyền để hiển thị các mục menu phù hợp
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="icon" href="/public/images/logo.webp">
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
  <div class="dashboard">
    <div class="dashboard__sidebar">
      <div class="dashboard__logo">
        <h2>Admin Control Panel</h2>
      </div>
      <nav class="dashboard__nav">
        <ul class="dashboard__menu">
          <?php if ($admin_role === 'admin' || $admin_role === 'adminOrder' || $admin_role === 'adminNews' || $admin_role === 'adminProduct') : ?>
            <li class="dashboard__item <?php echo $current_tab == 'dashboard' ? 'active' : ''; ?>">
              <a href="?tab=dashboard" class="dashboard__link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($admin_role === 'admin') : ?>
            <li class="dashboard__item <?php echo $current_tab == 'user' ? 'active' : ''; ?>">
              <a href="?tab=user" class="dashboard__link">
                <i class="fas fa-users"></i>
                <span>Users</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($admin_role === 'admin' || $admin_role === 'adminProduct') : ?>
            <li class="dashboard__item <?php echo $current_tab == 'product' ? 'active' : ''; ?>">
              <a href="?tab=product" class="dashboard__link">
                <i class="fas fa-box"></i>
                <span>Products</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($admin_role === 'admin' || $admin_role === 'adminOrder') : ?>
            <li class="dashboard__item <?php echo $current_tab == 'order' ? 'active' : ''; ?>">
              <a href="?tab=order" class="dashboard__link">
                <i class="fas fa-shopping-cart"></i>
                <span>Orders</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($admin_role === 'admin' || $admin_role === 'adminProduct') : ?>
            <li class="dashboard__item <?php echo $current_tab == 'category' ? 'active' : ''; ?>">
              <a href="?tab=category" class="dashboard__link">
                <i class="fas fa-shopping-cart"></i>
                <span>Category</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($admin_role === 'admin' || $admin_role === 'adminNews') : ?>
            <li class="dashboard__item <?php echo $current_tab == 'news' ? 'active' : ''; ?>">
              <a href="?tab=news" class="dashboard__link">
                <i class="fas fa-info-circle"></i>
                <span>News</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($admin_role === 'admin') : ?>
            <li class="dashboard__item <?php echo $current_tab == 'account_admin' ? 'active' : ''; ?>">
              <a href="?tab=account_admin" class="dashboard__link">
                <i class="fas fa-users"></i>
                <span>Admin Account</span>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
      <div class="dashboard__logout">
        <a href="auth/logout.php" class="dashboard__link">
          <i class="fas fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </div>
    </div>

    <div class="dashboard__main">
      <div class="dashboard__header">
        <div class="dashboard__search">
          <input type="text" placeholder="Search...">
        </div>
        <div class="dashboard__profile">
          <span>Welcome, Admin</span>
          <img src="/public/images/logo.webp" alt="Profile">
        </div>
      </div>

      <div class="dashboard__content">
        <?php
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard'; // Kiểm tra tab hiện tại

        switch ($current_tab) {
          case 'user':
            include 'tabs/user.php';
            break;
          case 'product':
            include 'tabs/product.php';
            break;
          case 'order':
            include 'tabs/order.php';
            break;
          case 'category':
            include 'tabs/category.php';
            break;
          case 'news':
            include 'tabs/news.php';
            break;
          case 'account_admin':
            include 'tabs/account_admin.php';
            break;
          default:
            echo "<h2>Welcome to Dashboard</h2>";
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>
