<?php
session_start();
include_once '../../includes/db_connect.php'; // Đảm bảo kết nối đúng

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Kiểm tra kết nối cơ sở dữ liệu
    if (isset($conn)) {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $admin = $result->fetch_assoc();
                // Sử dụng password_verify để kiểm tra mật khẩu mã hóa
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_role'] = $admin['role']; // Lưu vai trò admin
                    header("Location: ../index.php"); // Chuyển hướng tới trang admin
                    exit();
                } else {
                    echo "Sai mật khẩu.";
                }
            } else {
                echo "Tên đăng nhập không tồn tại.";
            }
            $stmt->close();
        } else {
            echo "Lỗi trong quá trình chuẩn bị truy vấn.";
        }
    } else {
        echo "Kết nối cơ sở dữ liệu không thành công.";
    }
}
?>
