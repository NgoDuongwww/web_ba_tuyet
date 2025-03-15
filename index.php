<?php
include_once './includes/header.php';  // Include the header
include_once './includes/db_connect.php';  // Include the DB connection

// Ensure the connection is successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to get the 4 products with the highest views
$sql_newest = "SELECT * FROM product ORDER BY view_count DESC LIMIT 4";
$result_newest = $conn->query($sql_newest);

// Check if the query was successful
if ($result_newest === false) {
  die('Error executing query: ' . $conn->error);
}

$newest_products = $result_newest->fetch_all(MYSQLI_ASSOC);  // Fetch all newest products as an associative array

// Query to get all products for recommendations
$sql_recommended = "SELECT * FROM product";
$result_recommended = $conn->query($sql_recommended);

// Check if the query was successful
if ($result_recommended === false) {
  die('Error executing query: ' . $conn->error);
}

$recommended_products = $result_recommended->fetch_all(MYSQLI_ASSOC);  // Fetch all recommended products as an associative array
?>
<div class="container">
  <div class="banner">
    <div class="banner__slider">
      <div class="banner__slider-wrapper">
        <img class="banner__slider-item" src="/public/images/banner/slider_1.webp" alt="banner">
        <img class="banner__slider-item" src="/public/images/banner/slider_2.webp" alt="banner">
        <img class="banner__slider-item" src="/public/images/banner/slider_3.webp" alt="banner">
        <img class="banner__slider-item" src="/public/images/banner/slider_4.webp" alt="banner">
        <img class="banner__slider-item" src="/public/images/banner/slider_5.webp" alt="banner">
      </div>
    </div>
  </div>
  <div class="index__about">
    <div class="index__recommend">
      <?php
      $count = 0;  // Khởi tạo biến đếm số lượng sản phẩm
      foreach ($recommended_products as $product):
        if ($count >= 4)
          break;  // Dừng vòng lặp khi đã hiển thị 4 sản phẩm
        $count++;
      ?>
        <div class="recommend__item">
          <img src="/public/images/item/<?php echo htmlspecialchars($product['image']); ?>" alt="recommend">
          <a href="../../views/detail.php?id=<?php echo $product['id']; ?>">
            <button>Xem ngay</button>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
    <h1>VỀ CHÚNG TÔI</h1>
    <p>Tự hào là một trong những nhà phân phối và bán lẻ đồ ăn vặt lớn nhất cả nước.</p>
    <div class="index__about__content">
      <div class="index__about__content__item">
        <img src="/public/images/about/1.webp" alt="about">
        <h3>Chất lượng tin cậy</h3>
      </div>
      <div class="index__about__content__item">
        <img src="/public/images/about/2.webp" alt="about">
        <h3>Hướng đến khách hàng</h3>
      </div>
      <div class="index__about__content__item">
        <img src="/public/images/about/3.webp" alt="about">
        <h3>Chính sách đổi trả</h3>
      </div>
      <div class="index__about__content__item">
        <img src="/public/images/about/4.webp" alt="about">
        <h3>Quà tặng hấp dẫn</h3>
      </div>
    </div>
    <h1 class="collection__index"><a href="/views/collection.php">DANH MỤC SẢN PHẨM</a></h1>
    <div class="collection__item">
      <?php foreach ($newest_products as $product): ?>
        <div class="collection__item__detail">
          <a href="../../views/detail.php?id=<?php echo $product['id']; ?>">
            <i class="fa-solid fa-cart-shopping"></i>
            <img src="/public/images/item/<?php echo htmlspecialchars($product['image']); ?>" alt="collection">
            <p><?php echo htmlspecialchars($product['name']); ?></p>
            <span><?php echo number_format($product['price'], 0, ',', '.') . 'đ'; ?></span>
          </a>
        </div>
      <?php endforeach; ?>
    </div>


    <a class="collection__item__all" href="/views/collection.php">Xem tất cả</a>
  </div>
  <div class="index__hotline">
    <h2>HOTLINE</h2>
    <p>0909 090 090</p>
    <span>Chúng tôi cam kết 100% các sản phẩm có nguồn gốc xuất xứ rõ ràng,<br>
      sạch, an toàn và đảm bảo chất lượng ngon nhất.</span>
  </div>

  <?php
  $sql = "SELECT * FROM news";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  ?>

  <div class="index__news">
    <h1>TIN TỨC MỚI NHẤT</h1>
    <div class="news__block">
      <?php foreach ($result as $new): ?>
        <div class="news__content">
          <img src="/public/images/news/<?php echo $new['image']; ?>" alt="news">
          <div class="news__content-date">
            <i class="fa-regular fa-calendar-days"></i> <span><?php echo $new['created_at']; ?></span>
            <p>Đăng bởi:</p><span>
              <?php echo $new['author']; ?>
            </span>
          </div>
          <div class="news__content-text">
            <h3><?php echo $new['title']; ?></h3>
            <p><?php echo $new['content']; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="top__brand">
    <h1>TOP THƯƠNG HIỆU</h1>
    <div class="top__brand__content">
      <img src="/public/images/about/brand_1.webp" alt="brand">
      <img src="/public/images/about/brand_2.webp" alt="brand">
      <img src="/public/images/about/brand_3.webp" alt="brand">
      <img src="/public/images/about/brand_4.webp" alt="brand">
      <img src="/public/images/about/brand_5.webp" alt="brand">
      <img src="/public/images/about/brand_6.webp" alt="brand">
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>