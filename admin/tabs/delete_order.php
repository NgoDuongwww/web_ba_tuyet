<?php
include_once "../../includes/db_connect.php";

if (isset($_POST['id']) && !empty($_POST['id'])) {
          // Lấy id từ POST request
          $id = intval($_POST['id']);

          // Bắt đầu transaction để đảm bảo tính toàn vẹn dữ liệu
          $conn->begin_transaction();

          try {
                    // Xóa dữ liệu từ bảng order_items
                    $sql_items = "DELETE FROM order_items WHERE order_id = ?";
                    $stmt_items = $conn->prepare($sql_items);

                    if ($stmt_items) {
                              $stmt_items->bind_param("i", $id);
                              $stmt_items->execute();
                              $stmt_items->close();
                    } else {
                              throw new Exception("Lỗi khi chuẩn bị câu lệnh DELETE từ order_items");
                    }

                    // Xóa dữ liệu từ bảng orders
                    $sql_orders = "DELETE FROM orders WHERE id = ?";
                    $stmt_orders = $conn->prepare($sql_orders);

                    if ($stmt_orders) {
                              $stmt_orders->bind_param("i", $id);
                              $stmt_orders->execute();
                              $stmt_orders->close();
                    } else {
                              throw new Exception("Lỗi khi chuẩn bị câu lệnh DELETE từ orders");
                    }

                    // Commit transaction
                    $conn->commit();
                    echo "Đơn hàng đã được xóa thành công!";
          } catch (Exception $e) {
                    // Rollback transaction nếu có lỗi xảy ra
                    $conn->rollback();
                    echo "Lỗi: " . $e->getMessage();
          }
} else {
          echo "Không tìm thấy ID hợp lệ để xóa!";
}
?>