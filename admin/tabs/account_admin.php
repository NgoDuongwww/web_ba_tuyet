<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/db_connect.php'; // Đường dẫn đầy đủ đến db_connect.php

// Kiểm tra xem admin đã đăng nhập chưa
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}


// Xử lý yêu cầu xóa tài khoản admin
if (isset($conn) && isset($delete_id)) {
    // Kiểm tra xem id có hợp lệ không
    $stmt = $conn->prepare("DELETE FROM admin WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Account deleted successfully.";
        } else {
            echo "Failed to delete the account.";
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
    header("Location: account_admin.php");
    exit();
}


// Cập nhật vai trò admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $admin_id = (int)$_POST['admin_id'];
    $new_role = $_POST['role'];
    if (isset($conn)) {
        $stmt = $conn->prepare("UPDATE admin SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $new_role, $admin_id);
        $stmt->execute();
        $stmt->close();
        echo "Vai trò admin đã cập nhật!";
        exit();
    }
}

// Lấy danh sách tất cả các tài khoản admin từ cơ sở dữ liệu
$admins = [];
if (isset($conn)) {
    $sql = "SELECT id, username, role FROM admin";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $admins = $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>

<body>
    <div class="admin">
        <h1 class="admin__title">Manage Admin Accounts</h1>

        <table class="admin__table">
            <thead class="admin__table-head">
                <tr class="admin__table-row">
                    <th class="admin__table-cell">ID</th>
                    <th class="admin__table-cell">Username</th>
                    <th class="admin__table-cell">Role</th>
                </tr>
            </thead>
            <tbody class="admin__table-body">
                <?php foreach ($admins as $admin) : ?>
                    <tr class="admin__table-row">
                        <td class="admin__table-cell"><?php echo htmlspecialchars($admin['id']); ?></td>
                        <td class="admin__table-cell"><?php echo htmlspecialchars($admin['username']); ?></td>
                        <td class="admin__table-cell">
                            <form class="admin__role-form" method="POST" action="">
                                <input type="hidden" name="admin_id" value="<?php echo $admin['id']; ?>">
                                <select name="role" class="admin__role-select" onchange="this.form.submit()">
                                    <option value="admin" <?php echo $admin['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                    <option value="adminOrder" <?php echo $admin['role'] === 'adminOrder' ? 'selected' : ''; ?>>Admin Order</option>
                                    <option value="adminNews" <?php echo $admin['role'] === 'adminNews' ? 'selected' : ''; ?>>Admin News</option>
                                    <option value="adminProduct" <?php echo $admin['role'] === 'adminProduct' ? 'selected' : ''; ?>>Admin Product</option>
                                </select>
                                <input type="hidden" name="update_role" value="1">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<style>
    /* Block: admin */
    .admin__title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .admin__table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .admin__table-head {
        background-color: #f0f0f0;
    }

    .admin__table-row {
        border-bottom: 1px solid #ddd;
    }

    .admin__table-cell {
        padding: 10px;
        text-align: left;
    }

    .admin__role-form {
        margin: 0;
    }

    .admin__role-select {
        padding: 5px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Hover effect for table rows */
    .admin__table-row:hover {
        background-color: #f9f9f9;
    }

    /* Modifier: for selected role */
    .admin__role-select option[selected] {
        font-weight: bold;
    }
</style>