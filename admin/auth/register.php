<?php
session_start();
include_once '../../includes/db_connect.php'; // Kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    // Kiểm tra dữ liệu đầu vào
    if (empty($username) || empty($password) || empty($role)) {
        echo "Vui lòng nhập đầy đủ thông tin.";
        exit();
    }

    // Kiểm tra kết nối cơ sở dữ liệu
    if (isset($conn)) {
        // Kiểm tra username đã tồn tại
        $checkSql = "SELECT * FROM admin WHERE username = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            echo "Tên đăng nhập đã tồn tại.";
            exit();
        }

        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Thêm tài khoản mới
        $insertSql = "INSERT INTO admin (username, password, role) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);

        if ($insertStmt) {
            $insertStmt->bind_param("sss", $username, $hashedPassword, $role);

            if ($insertStmt->execute()) {
                echo "Tạo tài khoản thành công.";
                header("Location: login_form.php"); // Chuyển hướng về trang đăng nhập
                exit();
            } else {
                echo "Lỗi trong quá trình tạo tài khoản.";
            }

            $insertStmt->close();
        } else {
            echo "Lỗi trong quá trình chuẩn bị truy vấn.";
        }

        $checkStmt->close();
    } else {
        echo "Kết nối cơ sở dữ liệu không thành công.";
    }
}
?>
