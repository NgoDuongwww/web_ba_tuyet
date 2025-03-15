<?php
// Bắt đầu session nếu chưa có session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra lại đường dẫn đến tệp db_connect.php
include_once "../../includes/db_connect.php"; // Cập nhật đường dẫn nếu cần thiết

// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Kiểm tra xem có ID người dùng để xóa không
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = $_GET['id'];

    // Xóa người dùng khỏi cơ sở dữ liệu
    $sql = "DELETE FROM user WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $userId); // Liên kết tham số (kiểu số nguyên)
        if ($stmt->execute()) {
            // Thông báo xóa thành công
            $_SESSION['message'] = "User deleted successfully.";
        } else {
            // Thông báo lỗi xóa
            $_SESSION['message'] = "Error deleting user: " . $stmt->error;
        }
        $stmt->close();
    } else {
        // Thông báo lỗi khi chuẩn bị câu lệnh SQL
        $_SESSION['message'] = "Error preparing statement: " . $conn->error;
    }
} else {
    // Nếu không có ID hợp lệ
    $_SESSION['message'] = "Invalid user ID.";
}
header("Location: ./user.php");
// Đóng kết nối
$conn->close();
exit;
?>
