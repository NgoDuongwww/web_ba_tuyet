<?php
// sign_out.php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['user_logged_in'])) {
    // Xóa tất cả session
    session_unset();
    // Hủy session
    session_destroy();
    // Chuyển hướng về trang chủ hoặc trang đăng nhập
    header("Location: /index.php");
    exit();
} else {
    // Nếu không có session người dùng, chuyển hướng về trang đăng nhập
    header("Location: /views/auth/sign_in.php");
    exit();
}
?>
