<?php
// Bắt đầu phiên làm việc
session_start();
// Sau khi cập nhật trạng thái thành công, redirect đến notifications.php với thông báo
if ($stmt->affected_rows > 0) {
    // Lưu thông báo trong session
    $_SESSION['notification'] = "Trạng thái đơn hàng của bạn đã được cập nhật thành '$status'.";
    header("Location: ../../../views/notification.php");
    exit();
} else {
    echo "Failed to update order status.";
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Báo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .notification-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .notification {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 5px solid #4CAF50;
            border-radius: 8px;
        }

        .notification p {
            margin: 0;
        }

        .notification strong {
            color: #333;
        }
    </style>
</head>
<body>

<div class="notification-container">
    <h2>Thông Báo</h2>

    <?php
    // Hiển thị thông báo nếu có trong session
    if (isset($_SESSION['notification'])) {
        echo '<div class="notification">';
        echo '<p><strong>' . $_SESSION['notification'] . '</strong></p>';
        echo '</div>';

        // Xóa thông báo khỏi session sau khi hiển thị
        unset($_SESSION['notification']);
    } else {
        echo '<p>Không có thông báo mới.</p>';
    }
    ?>
</div>

</body>
</html>
