<?php
include_once "../../includes/db_connect.php";

// Kiểm tra xem có ID của bài viết cần chỉnh sửa hay không
if (isset($_GET['id'])) {
          $news_id = $_GET['id'];

          // Lấy thông tin bài viết từ cơ sở dữ liệu
          $sql = "SELECT * FROM news WHERE id = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $news_id); // Giới thiệu tham số và kiểu dữ liệu
          $stmt->execute();
          $result = $stmt->get_result();
          $news = $result->fetch_assoc();

          // Kiểm tra nếu bài viết không tồn tại
          if (!$news) {
                    echo "Bài viết không tồn tại!";
                    exit;
          }
}

// Xử lý cập nhật bài viết
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $title = $_POST['news_title'];
          $content = $_POST['news_content'];
          $author = $_POST['news_author'];
          $status = $_POST['news_status']; // Lấy giá trị của status
          $image = $_FILES['news_image']['name'];

          // Nếu có ảnh mới, thực hiện upload
          if ($image) {
                    // Upload ảnh mới
                    $target = '../../public/images/news/' . basename($image);
                    move_uploaded_file($_FILES['news_image']['tmp_name'], $target);
          } else {
                    // Nếu không có ảnh mới, giữ ảnh cũ
                    $image = $news['image'];
          }

          // Cập nhật dữ liệu vào bảng news
          $sql = "UPDATE news SET title = ?, content = ?, author = ?, image = ?, status = ? WHERE id = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ssssii", $title, $content, $author, $image, $status, $news_id); // Cập nhật $news_id

          if ($stmt->execute()) {
                    echo "Bài viết đã được cập nhật!";
                    exit;
          } else {
                    echo "Lỗi cập nhật bài viết.";
          }
}
?>

<link rel="stylesheet" href="../../admin/assets/product.css">
<h2>Edit News</h2>

<!-- Form chỉnh sửa bài viết -->
<form action="news_edit.php?id=<?php echo $news['id']; ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
                    <label for="news_title">Title</label>
                    <input type="text" name="news_title" id="news_title" value="<?php echo htmlspecialchars($news['title']); ?>" required>
          </div>

          <div class="form-group">
                    <label for="news_content">Content</label>
                    <textarea name="news_content" id="news_content" required><?php echo htmlspecialchars($news['content']); ?></textarea>
          </div>

          <div class="form-group">
                    <label for="news_author">Author</label>
                    <input type="text" name="news_author" id="news_author" value="<?php echo htmlspecialchars($news['author']); ?>" required>
          </div>

          <div class="form-group">
                    <label for="news_image">Main Image</label>
                    <input type="file" name="news_image" id="news_image" accept="image/*">
                    <p>Current image: <img src="../../public/images/news/<?php echo htmlspecialchars($news['image']); ?>" width="50"></p>
          </div>

          <div class="form-group">
                    <label for="news_status">Status</label>
                    <select name="news_status" id="news_status" required>
                              <option value="1" <?php echo $news['status'] == 1 ? 'selected' : ''; ?>>Published</option>
                              <option value="0" <?php echo $news['status'] == 0 ? 'selected' : ''; ?>>Unpublished</option>
                    </select>
          </div>

          <button type="submit" class="btn">Update News</button>
</form>