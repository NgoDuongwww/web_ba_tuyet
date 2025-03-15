<?php
// Bắt đầu phiên làm việc
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '../includes/db_connect.php'; // Đường dẫn đầy đủ đến db_connect.php

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: auth/login_form.php");
    exit();
}

// Kiểm tra nếu có yêu cầu cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Cập nhật trạng thái đơn hàng
    if (isset($_POST['update_status']) && isset($_POST['order_id']) && isset($_POST['status'])) {
        $order_id = $_POST['order_id'];
        $status = $_POST['status'];

        // Cập nhật trạng thái đơn hàng
        $query = "UPDATE `orders` SET `status` = ? WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Order status updated successfully.";
        } else {
            echo "Failed to update order status.";
        }
    }

    // Nhận thông tin hủy đơn hàng
    if (isset($_POST['cancel_order']) && isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];
        $cancel_reason = $_POST['cancel_reason'];

        if (!empty($cancel_reason)) {
            // Cập nhật trạng thái đơn hàng thành 'canceled'
            $query = "UPDATE `orders`
                      SET `status` = 'canceled',
                          `is_canceled` = 1,
                          `cancel_reason` = ?, 
                          `canceled_at` = NOW()
                      WHERE `id` = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $cancel_reason, $order_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "Order canceled successfully.";
            } else {
                echo "Failed to cancel the order.";
            }
        } else {
            echo "Cancel reason is required.";
        }
    }

    // Xóa đơn hàng sau khi đã hủy
    if (isset($_POST['delete_order']) && isset($_POST['order_id'])) {
        $order_id = $_POST['order_id'];

        // Kiểm tra xem đơn hàng đã bị hủy chưa
        $check_query = "SELECT `is_canceled` FROM `orders` WHERE `id` = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Kiểm tra nếu có kết quả trả về
        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();

            if ($order['is_canceled'] == 1) {
                // Xóa các mục trong đơn hàng
                $delete_items_query = "DELETE FROM `order_items` WHERE `order_id` = ?";
                $stmt = $conn->prepare($delete_items_query);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();

                // Xóa đơn hàng
                $delete_order_query = "DELETE FROM `orders` WHERE `id` = ?";
                $stmt = $conn->prepare($delete_order_query);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "Đơn hàng và các mục đã được xóa thành công.";
                } else {
                    echo "Xóa đơn hàng không thành công.";
                }
            } else {
                echo "Đơn hàng chưa bị hủy, không thể xóa.";
            }
        } else {
            echo "Order not found.";
        }
    }
}

// Hiển thị các đơn hàng
$query = "SELECT * FROM `orders`";
$result = $conn->query($query);
?>

<body>
    <h2 class="order-management__title">Order Management</h2>

    <?php
    if ($result->num_rows > 0) {
        while ($order = $result->fetch_assoc()) {
            echo "<div class='order-management__order'>";
            echo "<p class='order-management__order-id'><strong>Order ID:</strong> " . $order['id'] . "</p>";
            echo "<p class='order-management__order-name'><strong>Name:</strong> " . $order['name'] . "</p>";
            echo "<p class='order-management__order-status'><strong>Status:</strong> " . $order['status'] . "</p>";
            echo "<p class='order-management__order-total-price'><strong>Total Price:</strong> " . $order['total_price'] . "</p>";
            echo "<p class='order-management__order-created-at'><strong>Created At:</strong> " . $order['created_at'] . "</p>";

            // Hiển thị các sản phẩm trong đơn hàng
            $order_id = $order['id'];
            $item_query = "SELECT * FROM `order_items` WHERE `order_id` = ?";
            $item_stmt = $conn->prepare($item_query);
            $item_stmt->bind_param("i", $order_id);
            $item_stmt->execute();
            $item_result = $item_stmt->get_result();
            echo "<h3 class='order-management__order-items-title'>Order Items</h3>";
            while ($item = $item_result->fetch_assoc()) {
                echo "<p class='order-management__order-item'><strong>Product ID:</strong> " . $item['product_id'] . " - <strong>Quantity:</strong> " . $item['quantity'] . " - <strong>Price:</strong> " . $item['price'] . "</p>";
            }

            // Nếu đơn hàng chưa hủy, hiển thị form hủy đơn hàng
            if ($order['is_canceled'] == 0) {
                echo '<form class="order-management__cancel-form" method="POST" action="">
                    <input type="hidden" name="order_id" value="' . $order['id'] . '">
                    <label for="cancel_reason" class="order-management__cancel-label">Cancel Reason:</label>
                    <textarea name="cancel_reason" class="order-management__cancel-textarea" required></textarea>
                    <button type="submit" name="cancel_order" class="order-management__cancel-button">Cancel Order</button>
                </form>';
            } else {
                echo "<p class='order-management__cancel-reason'><strong>Cancel Reason:</strong> " . $order['cancel_reason'] . "</p>";
            }

            // Form chỉnh sửa trạng thái (ẩn hoặc vô hiệu hóa khi đơn hàng đã hủy)
            if ($order['is_canceled'] == 1) {
                echo "<p class='order-management__order-status-canceled'><strong>Status:</strong> " . $order['status'] . " (Canceled)</p>";
            } else {
                echo '<form class="order-management__status-form" method="POST" action="">
                    <input type="hidden" name="order_id" value="' . $order['id'] . '">
                    <label for="status" class="order-management__status-label">Change Status:</label>
                    <select name="status" class="order-management__status-select" required>
                        <option value="pending" ' . ($order['status'] == 'pending' ? 'selected' : '') . '>Pending</option>
                        <option value="shipped" ' . ($order['status'] == 'shipped' ? 'selected' : '') . '>Shipped</option>
                        <option value="delivered" ' . ($order['status'] == 'delivered' ? 'selected' : '') . '>Delivered</option>
                    </select>
                    <button type="submit" name="update_status" class="order-management__status-button">Update Status</button>
                </form>';
            }

            // Nếu đơn hàng đã hủy, hiển thị nút xóa
            if ($order['is_canceled'] == 1) {
                echo '<form class="order-management__delete-form" method="POST" action="">
                    <input type="hidden" name="order_id" value="' . $order['id'] . '">
                    <button type="submit" name="delete_order" class="order-management__delete-button">Delete Order</button>
                </form>';
            }

            echo "</div><hr>";
        }
    } else {
        echo "<p class='order-management__no-orders'>No orders found.</p>";
    }
    ?>
</body>

<style>
    /* Block: order-management */
    .order-management__title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .order-management__order {
        background-color: #f9f9f9;
        padding: 20px 50px;
        border: 1px solid #ddd;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 14px;
    }

    .order-management__order-id,
    .order-management__order-name,
    .order-management__order-status,
    .order-management__order-total-price,
    .order-management__order-created-at {
        margin: 5px 0;
    }

    .order-management__order-id strong,
    .order-management__order-name strong,
    .order-management__order-status strong,
    .order-management__order-total-price strong,
    .order-management__order-created-at strong {
        font-weight: bold;
    }

    .order-management__order-items-title {
        font-size: 20px;
        margin-top: 10px;
    }

    .order-management__order-item {
        margin-left: 10px;
        font-size: 14px;
    }

    .order-management__cancel-form,
    .order-management__status-form,
    .order-management__delete-form {
        margin-top: 20px;
    }

    .order-management__cancel-form textarea,
    .order-management__status-form select {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .order-management__cancel-form button,
    .order-management__status-form button,
    .order-management__delete-form button {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 10px 15px;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
    }

    .order-management__cancel-form button:hover,
    .order-management__status-form button:hover,
    .order-management__delete-form button:hover {
        background-color: #0056b3;
    }

    .order-management__cancel-label,
    .order-management__status-label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .order-management__cancel-textarea {
        height: 50px;
        resize: none;
    }

    /* Modifier for canceled orders */
    .order-management__order-status-canceled {
        color: red;
        font-weight: bold;
    }

    .order-management__cancel-reason {
        margin-top: 10px;
        color: #ff6347;
    }

    .order-management__delete-button {
        background-color: #dc3545;
    }

    .order-management__delete-button:hover {
        background-color: #c82333;
    }

    /* When no orders are found */
    .order-management__no-orders {
        font-size: 18px;
        color: #888;
        font-style: italic;
        text-align: center;
    }
</style>