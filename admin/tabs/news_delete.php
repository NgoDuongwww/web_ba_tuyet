<?php
include_once "../../includes/db_connect.php";

// Kiểm tra nếu có tham số 'id' trong URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
          // Lấy ID của bài viết cần xóa
          $news_id = $_GET['id'];

          // Kết nối tới cơ sở dữ liệu và xử lý xóa
          try {
                    // Lấy thông tin ảnh của bài viết
                    $sql = "SELECT image FROM news WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $news_id); // Tham số kiểu integer
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $news = $result->fetch_assoc();

                    // Nếu tìm thấy bài viết, xóa ảnh khỏi thư mục
                    if ($news && !empty($news['image'])) {
                              $imagePath = '../../uploads/news/' . $news['image'];
                              if (file_exists($imagePath)) {
                                        unlink($imagePath); // Xóa ảnh
                              }
                    }

                    // Xóa bài viết khỏi cơ sở dữ liệu
                    $sqlDelete = "DELETE FROM news WHERE id = ?";
                    $stmtDelete = $conn->prepare($sqlDelete);
                    $stmtDelete->bind_param("i", $news_id); // Tham số kiểu integer

                    // Nếu xóa thành công, chuyển hướng về trang danh sách tin tức
                    if ($stmtDelete->execute()) {
                              echo "News deleted successfully.";
                    } else {
                              echo "Failed to delete news.";
                    }
          } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
          }
} else {
          echo "Invalid request.";
}
