<?php
session_start();
session_unset();
session_destroy();

header("Location: login_form.php"); // Chuyển hướng về trang đăng nhập sau khi đăng xuất
exit();
?>
