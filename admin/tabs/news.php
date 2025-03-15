<?php
include_once "../includes/db_connect.php";

// Đưa dữ liệu vào bảng News
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_news'])) {
  // Lấy dữ liệu từ form
  $title = $_POST['title'] ?? '';
  $content = $_POST['content'] ?? '';
  $author = $_POST['author'] ?? '';
  $created_at = $_POST['created_at'] ?? date('Y-m-d H:i:s');

  // Kiểm tra xem ảnh đã được tải lên chưa
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Xử lý ảnh đại diện
    $imageName = basename($_FILES['image']['name']);
    $imageTmpName = $_FILES['image']['tmp_name'];
    $uploadDir = '../../uploads/news/';
    $imagePath = $uploadDir . $imageName;

    // Tạo thư mục nếu chưa tồn tại
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0755, true);
    }

    // Di chuyển file ảnh
    if (move_uploaded_file($imageTmpName, $imagePath)) {
      // Chèn dữ liệu vào bảng `news` với status mặc định là 'on'
      $sql = "INSERT INTO news (title, content, image, author, created_at, status) 
                  VALUES (?, ?, ?, ?, ?, 'on')";

      // Chuẩn bị câu lệnh
      $stmt = $conn->prepare($sql);

      // Kiểm tra nếu câu lệnh chuẩn bị không thành công
      if ($stmt === false) {
        die('MySQL prepare failed: ' . $conn->error);
      }

      // Bind các tham số
      $stmt->bind_param("sssss", $title, $content, $imageName, $author, $created_at);

      // Thực thi câu lệnh
      if ($stmt->execute()) {
        // Chuyển hướng sau khi thêm bài viết thành công
        echo "News added successfully.";
      } else {
        echo "Failed to add news.";
      }
      $stmt->close();
    } else {
      echo "Failed to upload image.";
    }
  } else {
    echo "Please upload a valid image.";
  }
}
?>

<?php
// Lấy thông tin hiện tại từ bảng News
$sql = "SELECT * FROM news ";
$result = $conn->query($sql);
?>

<h2>News</h2>
<link rel="stylesheet" href="../../admin/assets/product.css">
<form action="" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="add_news" value="1">

  <!-- Tiêu đề bài viết -->
  <div class="form-group">
    <label for="news_title">Title</label>
    <input type="text" name="title" id="news_title" required>
  </div>

  <!-- Nội dung bài viết -->
  <div class="form-group">
    <label for="news_content">Content</label>
    <textarea name="content" id="news_content" required></textarea>
  </div>

  <!-- Ảnh đại diện -->
  <div class="form-group">
    <label for="news_image">Featured Image</label>
    <input type="file" name="image" id="news_image" accept="image/*" required>
  </div>

  <!-- Ngày đăng bài -->
  <div class="form-group">
    <label for="news_created_at">Created At</label>
    <input type="datetime-local" name="created_at" id="news_created_at" required>
  </div>

  <!-- Tác giả bài viết -->
  <div class="form-group">
    <label for="news_author">Author</label>
    <input type="text" name="author" id="news_author" required>
  </div>

  <!-- Nút gửi form -->
  <button type="submit" class="btn">Add News</button>
</form>

<!-- Hiển thị danh sách tin tức -->
<h2>News List</h2>
<table>
  <tr>
    <th>Title</th>
    <th>Content</th>
    <th>Image</th>
    <th>Author</th>
    <th>Created At</th>
    <th>Status</th>
    <th>Actions</th>
  </tr>
  <?php while ($item = $result->fetch_assoc()): ?>
    <tr>
      <!-- Hiển thị tiêu đề -->
      <td><?php echo htmlspecialchars($item['title']); ?></td>

      <!-- Hiển thị nội dung (cắt ngắn nếu quá dài) -->
      <td><?php echo htmlspecialchars(mb_strimwidth($item['content'], 0, 100, '...')); ?></td>

      <!-- Hiển thị ảnh đại diện -->
      <td>
        <img src="../../public/images/news/<?php echo htmlspecialchars($item['image']); ?>" width="50">
      </td>

      <!-- Hiển thị tên tác giả -->
      <td><?php echo htmlspecialchars($item['author']); ?></td>

      <!-- Hiển thị ngày tạo -->
      <td><?php echo htmlspecialchars($item['created_at']); ?></td>

      <!-- Hiển thị trạng thái -->
      <td><?php echo $item['status'] === 'on' ? 'Active' : 'Inactive'; ?></td>

      <!-- Hành động -->
      <td>
        <a href="../../admin/tabs/news_edit.php?id=<?php echo $item['id']; ?>">Edit</a> |
        <a href="../../admin/tabs/news_delete.php?id=<?php echo $item['id']; ?>"
          onclick="return confirm('Are you sure?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>
</table>