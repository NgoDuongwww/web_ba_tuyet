<?php
// Bắt đầu session nếu chưa có session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra lại đường dẫn đến tệp db_connect.php
include_once "../includes/db_connect.php"; // Đường dẫn tuyệt đối (kiểm tra đúng đường dẫn trên hệ thống của bạn)



// Kiểm tra kết nối cơ sở dữ liệu
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Lấy danh sách người dùng từ cơ sở dữ liệu
$sql = "SELECT * FROM user";
$result = $conn->query($sql);

// Hiển thị thông báo nếu có
if (isset($_SESSION['message'])) {
    echo "<p>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
}

?>
<link rel="stylesheet" href="../../admin/assets/user.css">
<h2>User Management</h2>

<!-- Hiển thị danh sách người dùng -->
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Kiểm tra và hiển thị các tài khoản người dùng
        if ($result->num_rows > 0) {
            while ($user = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $user['id'] . "</td>";
                echo "<td>" . $user['name'] . "</td>";
                echo "<td>" . $user['email'] . "</td>";
                echo "<td>" . $user['phone'] . "</td>";
                echo "<td>" . $user['created_at'] . "</td>";
                echo "<td><a href='/admin/tabs/delete_user.php?id=" . $user['id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No users found</td></tr>";
        }
        ?>
    </tbody>
</table>

<?php
// Đóng kết nối
$conn->close();
?>