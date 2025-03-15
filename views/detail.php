<?php 
include_once '../includes/header.php'; 
include_once "../includes/db_connect.php"; // Kết nối cơ sở dữ liệu

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Truy vấn sản phẩm từ cơ sở dữ liệu
$sql = "SELECT * FROM product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

// Cập nhật lượt xem mỗi khi sản phẩm được truy cập
$sql_update_views = "UPDATE product SET view_count = view_count + 1 WHERE id = ?";
$stmt_update_views = $conn->prepare($sql_update_views);
$stmt_update_views->bind_param("i", $product_id);
$stmt_update_views->execute();

if (!$product) {
    echo "Sản phẩm không tồn tại!";
    exit;
}

// Truy vấn ảnh phụ của sản phẩm
$sql_images = "SELECT * FROM product_images WHERE product_id = ?";
$stmt_images = $conn->prepare($sql_images);
$stmt_images->bind_param("i", $product_id);
$stmt_images->execute();
$images_result = $stmt_images->get_result();

// Xử lý khi người dùng nhấn nút "Thêm vào giỏ hàng"
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    // Tăng số lượt mua khi nhấn thêm vào giỏ hàng
    $sql_update_purchase = "UPDATE product SET purchase_count = purchase_count + 1 WHERE id = ?";
    $stmt_update_purchase = $conn->prepare($sql_update_purchase);
    $stmt_update_purchase->bind_param("i", $product_id);
    $stmt_update_purchase->execute();
    
    // Logic xử lý thêm sản phẩm vào giỏ hàng (ví dụ: lưu vào session hoặc giỏ hàng)
    // Mã xử lý giỏ hàng sẽ được thêm vào đây
}
?>

<div class="container">
  <!-- Title -->
  <div class="container__title">
    <div class="container__title__content">
      <h1><?php echo htmlspecialchars($product['name']); ?></h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span><?php echo htmlspecialchars($product['name']); ?></span>
    </div>
  </div>
  
  <!-- Detail -->
  <div class="detail">
    <div class="detail__item">
      <img src="/public/images/item/<?php echo htmlspecialchars($product['image']); ?>" alt="detail">
      <div class="detail__item__content">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <div class="detail__item__content__rating">
          <!-- Giả sử bạn có rating trong cơ sở dữ liệu -->
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
          <i class="fa-solid fa-star"></i>
        </div>
        <span><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</span>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>

        <!-- Kiểm tra số lượng -->
        <?php if ($product['quantity'] > 0) { ?>
          <p>Số lượng còn lại: <strong><?php echo $product['quantity']; ?></strong></p>
          
          <!-- Form để thêm sản phẩm vào giỏ hàng -->
          <form action="" method="POST">
              <button type="submit" name="add_to_cart" class="add-to-cart cart-action">Thêm vào giỏ hàng</button>
          </form>

          <?php 
          // Xử lý việc thêm vào giỏ hàng
          if (isset($_POST['add_to_cart'])) {
              // Kiểm tra nếu người dùng đã đăng nhập
              if (isset($_SESSION['user_id'])) {
                  // Lấy user_id từ session
                  $user_id = $_SESSION['user_id'];
                  $product_id = $product['id'];

                  // Kiểm tra nếu sản phẩm đã có trong giỏ hàng của người dùng
                  $query = "SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?";
                  $stmt = $conn->prepare($query);
                  $stmt->bind_param("ii", $user_id, $product_id);
                  $stmt->execute();
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                      // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
                      $query = "UPDATE cart_items SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
                      $stmt = $conn->prepare($query);
                      $stmt->bind_param("ii", $user_id, $product_id);
                      $stmt->execute();
                  } else {
                      // Thêm sản phẩm mới vào giỏ hàng
                      $query = "INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, 1)";
                      $stmt = $conn->prepare($query);
                      $stmt->bind_param("ii", $user_id, $product_id);
                      $stmt->execute();
                  }

                  // Thông báo cho người dùng đã thêm sản phẩm vào giỏ hàng
                  echo "<p style='color: green;'>Sản phẩm đã được thêm vào giỏ hàng.</p>";
              } else {
                  // Nếu chưa đăng nhập, yêu cầu người dùng đăng nhập
                  echo "<p style='color: red;'>Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.</p>";
              }
          }
          ?>

        <?php } else { ?>
          <p style="color: red;"><strong>Hết hàng</strong></p>
        <?php } ?>

        <p>Gọi đặt mua: <span>0589839851</span> để nhanh chóng đặt hàng</p>
      </div>
    </div>
</div>

    
    <!-- Hiển thị ảnh phụ -->
    <div class="detail__item__additional-images">
      <h3>Ảnh phụ</h3>
      <div class="additional-images">
        <?php while ($image = $images_result->fetch_assoc()) { ?>
          <img src="/public/images/item/<?php echo htmlspecialchars($image['image_url']); ?>" alt="additional image" width="100">
        <?php } ?>
      </div>
    </div>

    <div class="detail__banner">
      <img src="/public/images/bg_pro.webp" alt="banner">
    </div>

    <!-- Recommend -->
    <div class="detail__recommend">
      <h1>Sản phẩm liên quan</h1>
      <div class="collection__item">
        <!-- Các sản phẩm liên quan (có thể lấy từ cơ sở dữ liệu) -->
        <?php
        // Truy vấn sản phẩm liên quan (có thể dựa vào danh mục, giá trị,...)
        $sql_related = "SELECT * FROM product LIMIT 4";
        $result_related = $conn->query($sql_related);
        
        while ($related_product = $result_related->fetch_assoc()) {
        ?>  
        <div class="collection__item__detail cart-action">
          <!-- Thêm liên kết đến trang chi tiết của sản phẩm -->
          <a href="../views/detail.php?id=<?php echo $related_product['id']; ?>">
            <i class="fa-solid fa-cart-shopping"></i>
            <img src="/public/images/item/<?php echo htmlspecialchars($related_product['image']); ?>" alt="collection">
            <p><?php echo htmlspecialchars($related_product['name']); ?></p>
            <span><?php echo number_format($related_product['price'], 0, ',', '.'); ?>₫</span>
          </a>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<?php include_once '../includes/footer.php'; ?>
