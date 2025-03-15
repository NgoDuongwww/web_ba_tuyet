<?php include_once '../includes/header.php';
include_once '../includes/db_connect.php';
$news = "SELECT * FROM news";
$stmt = $conn->prepare($news);
$stmt->execute();
$news = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<div class="container">
  <!-- Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1>Tin tức</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Tin tức</span>
    </div>
  </div>
  <div class="news">
    <div class="index__news">
      <h1>TIN TỨC MỚI NHẤT</h1>
      <div class="news__block">
        <?php foreach ($news as $new): ?>
          <a href="news_detail.php?id=<?php echo $new['id']; ?>">
            <div class="news__content">
              <img src="/public/images/news/<?php echo $new['image']; ?>" width="100%" height="50%" alt="news">
              <div class="news__content-date">
                <i class="fa-regular fa-calendar-days"></i> <span><?php echo $new['created_at']; ?></span>
                <p>Đăng bởi:</p><span><?php echo $new['author']; ?></span>
              </div>
              <div class="news__content-text">
                <h3><?php echo $new['title']; ?></h3>
                <p><?php echo $new['content']; ?></p>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<?php include_once '../includes/footer.php'; ?>