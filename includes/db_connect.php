<?php
// db_connect.php
$servername = "localhost"; // Hoặc địa chỉ máy chủ cơ sở dữ liệu của bạn
$username = "root";        // Tên đăng nhập cơ sở dữ liệu
$password = "";            // Mật khẩu cơ sở dữ liệu
$dbname = "ba-tuyet"; // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    error_log("Kết nối thất bại: " . $conn->connect_error); // Log lỗi vào file server logs
    die("Không thể kết nối đến cơ sở dữ liệu. Vui lòng thử lại sau."); // Thông báo thân thiện hơn
}

?>
