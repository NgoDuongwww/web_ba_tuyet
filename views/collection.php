<?php
include_once '../includes/header.php';
include_once '../includes/db_connect.php';  // Kết nối cơ sở dữ liệu

// Cấu hình phân trang
$limit = 12;  // Số sản phẩm mỗi trang
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Lấy thông tin sắp xếp từ form
$sort_query = "ORDER BY created_at DESC";  // Mặc định là "Hàng mới về"
if (isset($_GET['sort'])) {
  switch ($_GET['sort']) {
    case 'newest':
      $sort_query = "ORDER BY created_at DESC";  // Hàng mới về
      break;
    case 'oldest':
      $sort_query = "ORDER BY created_at ASC";  // Hàng cũ nhất
      break;
    case 'price-asc':
      $sort_query = "ORDER BY price ASC";  // Giá tăng dần  
      break;
    case 'price-desc':
      $sort_query = "ORDER BY price DESC";  // Giá giảm dần
      break;
  }
}


// Truy vấn lấy danh sách sản phẩm với sắp xếp và phân trang
$sql = "SELECT * FROM product $sort_query LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);  // Thực hiện truy vấn
$products = $result->fetch_all(MYSQLI_ASSOC);  // Lấy tất cả sản phẩm dưới dạng mảng

// Lấy tổng số sản phẩm để tính số trang
$sql_total = "SELECT COUNT(*) FROM product";
$total_result = $conn->query($sql_total);
$total_products = $total_result->fetch_row()[0];
$total_pages = ceil($total_products / $limit);
?>

<div class="container">
  <!-- Collection Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1>Tất cả sản phẩm</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Tất cả sản phẩm</span>
    </div>
  </div>

  <!-- Form sắp xếp -->
  <div class="collection">
    <div class="collection__sort space--between">
      <div class="collection__sort__item">
        <span>Tất cả sản phẩm</span>
      </div>
      <div class="collection__sort__item center">
        <p>Sắp xếp theo: </p>
        <div class="collection__sort__item__radio center">
          <input type="radio" name="sort" id="newest" value="newest" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'newest' ? 'checked' : ''; ?> onchange="handleSortChange(this)">
          <label for="newest">Hàng mới về</label>
        </div>
        <div class="collection__sort__item__radio center">
          <input type="radio" name="sort" id="oldest" value="oldest" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'oldest' ? 'checked' : ''; ?> onchange="handleSortChange(this)">
          <label for="oldest">Hàng cũ nhất</label>
        </div>
        <div class="collection__sort__item__radio center">
          <input type="radio" name="sort" id="price-asc" value="price-asc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'price-asc' ? 'checked' : ''; ?> onchange="handleSortChange(this)">
          <label for="price-asc">Giá tăng dần</label>
        </div>
        <div class="collection__sort__item__radio center">
          <input type="radio" name="sort" id="price-desc" value="price-desc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'price-desc' ? 'checked' : ''; ?> onchange="handleSortChange(this)">
          <label for="price-desc">Giá giảm dần</label>
        </div>
      </div>
    </div>
  </div>

  <!-- Collection -->
  <div class="collection">
    <!-- Collection Item -->
    <div class="collection__item">
      <?php foreach ($products as $product): ?>
        <div class="collection__item__detail">
          <!-- Link to product detail page -->
          <a href="detail.php?id=<?php echo $product['id']; ?>">
            <i class="fa-solid fa-cart-shopping"></i>
            <img src="../public/images/item/<?php echo htmlspecialchars($product['image']); ?>" alt="collection">
            <p><?php echo htmlspecialchars($product['name']); ?></p>
          </a>
          <span>
            <?php echo $product['price'] ? number_format($product['price'], 0, ',', '.') . '₫' : 'Liên hệ'; ?>
          </span>


        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Phân trang -->
  <div class="pagination">
    <div class="pagination__item">
      <!-- Lấy giá trị sort từ URL -->
      <?php $current_sort = isset($_GET['sort']) ? '&sort=' . htmlspecialchars($_GET['sort']) : ''; ?>

      <!-- Liên kết đến trang trước -->
      <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1 . $current_sort; ?>">«</a>
      <?php endif; ?>

      <!-- Hiển thị các liên kết trang -->
      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i . $current_sort; ?>"
          class="<?php echo ($i == $page) ? 'pagination__active' : ''; ?>">
          <?php echo $i; ?>
        </a>
      <?php endfor; ?>

      <!-- Liên kết đến trang tiếp theo -->
      <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1 . $current_sort; ?>">»</a>
      <?php endif; ?>
    </div>
  </div>

</div>
</div>

<?php include_once '../includes/footer.php'; ?>