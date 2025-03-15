<?php
include_once '../includes/header.php';
include_once "../includes/db_connect.php"; // Kết nối cơ sở dữ liệu

// Lấy ID bài viết từ URL
$news_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Kiểm tra nếu ID hợp lệ
if ($news_id == 0) {
          echo "Bài viết không tồn tại.";
          exit;
}

// Truy vấn thông tin bài viết từ cơ sở dữ liệu
$sql = "SELECT * FROM news WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $news_id); // Sử dụng news_id thay vì product_id
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_assoc();

// Nếu bài viết không tồn tại
if (!$news) {
          echo "Bài viết không tồn tại.";
          exit;
}
?>

<div class="container">
          <!-- Title -->
          <div class="container__title">
                    <div class="container__title__content">
                              <h1><?php echo htmlspecialchars($news['title']); ?></h1>
                              <a href="/index.php">Trang chủ</a>
                              <i class="fa-solid fa-chevron-right"></i>
                              <span><?php echo htmlspecialchars($news['title']); ?></span>
                    </div>
          </div>

          <!-- News -->
          <div class="newS">
                    <div class="newS__item">
                              <!-- Hiển thị ảnh bài viết -->
                              <div class="newS__item__image">
                                        <img src="/public/images/news/<?php echo htmlspecialchars($news['image']); ?>" alt="detail">
                              </div>

                              <div class="newS__item__content">
                                        <!-- Tiêu đề bài viết -->
                                        <h1><?php echo htmlspecialchars($news['title']); ?></h1>

                                        <!-- Nội dung bài viết -->
                                        <p><?php echo nl2br(htmlspecialchars($news['content'])); ?></p>

                                        <!-- Ngày đăng -->
                                        <p><strong>Ngày đăng: </strong><?php echo date("d/m/Y", strtotime($news['created_at'])); ?></p>

                                        <!-- Tác giả -->
                                        <p><strong>Tác giả: </strong><?php echo htmlspecialchars($news['author']); ?></p>
                              </div>
                    </div>
          </div>

          <!-- Recommend -->
          <div class="detail__recommend">
                    <h1>Bài viết liên quan</h1>
                    <div class="collection__item">
                              <?php
                              try {
                                        // Truy vấn các bài viết liên quan (giới hạn 4 bài viết)
                                        $sql_related = "SELECT * FROM news ORDER BY created_at DESC LIMIT 4";
                                        $stmt_related = $conn->prepare($sql_related);
                                        $stmt_related->execute();
                                        $related_news = $stmt_related->get_result();

                                        while ($related_article = $related_news->fetch_assoc()) {
                              ?>
                                                  <div class="collection__item__detail cart-action">
                                                            <a href="../views/news_detail.php?id=<?php echo $related_article['id']; ?>">
                                                                      <img src="/public/images/news/<?php echo htmlspecialchars($related_article['image']); ?>"
                                                                                alt="collection">
                                                                      <p><?php echo htmlspecialchars($related_article['title']); ?></p>
                                                                      <span><?php echo date("d/m/Y", strtotime($related_article['created_at'])); ?></span>
                                                            </a>
                                                  </div>
                              <?php
                                        }
                              } catch (PDOException $e) {
                                        die('Error: ' . $e->getMessage());
                              }
                              ?>
                    </div>
          </div>
</div>

<?php include_once '../includes/footer.php'; ?>