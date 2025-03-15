<?php include_once '../includes/header.php'; ?>
<div class="container">
  <div class="container__title">
    <div class="container__title__content">
      <h1>Liên hệ</h1>
      <a href="/index.php">Trang chủ</a>
      <i class="fa-solid fa-chevron-right"></i>
      <span>Liên hệ</span>
    </div>
  </div>

  <div class="contact">
    <div class="contact__content">
      <div class="contact__info">
        <h1>Thông tin liên hệ</h1>
        <div class="contact__info__detail">
          <div class="contact__info__item">
            <i class="fa-solid fa-location-dot"></i>
            <div class="contact__info__text">
              <h3>Địa chỉ</h3>
              <p>Xóm Hồ 2, Xã Minh Đức, Thị xã Phổ Yên, Thái Nguyên</p>
            </div>
          </div>

          <div class="contact__info__item">
            <i class="fa-solid fa-phone"></i>
            <div class="contact__info__text">
              <h3>Điện thoại</h3>
              <p>0909 090 090</p>
            </div>
          </div>

          <div class="contact__info__item">
            <i class="fa-solid fa-envelope"></i>
            <div class="contact__info__text">
              <h3>Email</h3>
              <p>info@ancungbatuyet.com</p>
            </div>
          </div>

          <div class="contact__info__item">
            <i class="fa-solid fa-clock"></i>
            <div class="contact__info__text">
              <h3>Giờ làm việc</h3>
              <p>Thứ 2 - Chủ nhật: 8:00 - 22:00</p>
            </div>
          </div>
        </div>
      </div>

      <div class="contact__form">
        <h1>Gửi thông tin</h1>
        <form>
          <div class="contact__form__group">
            <input type="text" placeholder="Họ và tên">
            <input type="email" placeholder="Email">
          </div>
          <div class="contact__form__group">
            <input type="tel" placeholder="Số điện thoại">
            <input type="text" placeholder="Chủ đề">
          </div>
          <textarea placeholder="Nội dung"></textarea>
          <button type="submit">Gửi tin nhắn</button>
        </form>
      </div>

      <div class="contact__map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.4241674197956!2d106.65842187481827!3d10.77772088927147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ec3c161a3fb%3A0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!5e0!3m2!1svi!2s!4v1709654774631!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
</div>
<?php include_once '../includes/footer.php'; ?>