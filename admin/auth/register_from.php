<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Register</title>
  <link rel="icon" href="/public/images/logo.webp">
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
  <div class="login">
    <div class="register__container">
      <h1 class="register__title">Register Admin</h1>
      <form class="register__form" action="register.php" method="POST">
        <div class="register__form-group">
          <input type="text" name="username" class="register__input" placeholder="Username" required>
        </div>
        <div class="register__form-group">
          <input type="password" name="password" class="register__input" placeholder="Password" required>
        </div>
        <div class="register__form-group">
          <label for="role" class="register__label">Select Role:</label>
          <select name="role" id="role" class="register__select" required>
            <option value="admin">Admin</option>
            <option value="adminOrder">Admin Order</option>
            <option value="adminNews">Admin News</option>
            <option value="adminProduct">Admin Product</option>
          </select>
        </div>
        <button type="submit" class="register__button">Create Account</button>
      </form>
    </div>
  </div>
</body>

</html>
<style scoped>
  .register__container {
    font-family: "Inter", sans-serif;
    background: var(--background-color);
    padding: 40px;
    border-radius: 4px;
    width: 100%;
    max-width: 400px;
  }

  .register__title {
    text-align: center;
    margin-bottom: 30px;
    color: #1a1a1a;
    font-size: 24px;
    font-weight: 500;
  }

  .register__form {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .register__form-group {
    position: relative;
  }

  .register__input,
  .register__select {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e4e6eb;
    border-radius: 4px;
    font-size: 1.4rem;
    transition: all 0.2s ease;
    box-sizing: border-box;
    background-color: #f8f9fa;
  }

  .register__input:focus,
  .register__select:focus {
    border-color: var(--orange-color);
    background-color: #ffffff;
    outline: none;
  }

  .register__button {
    width: 100%;
    padding: 12px 15px;
    background-color: var(--orange-color);
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1.4rem;
    transition: background-color 0.2s ease;
    box-sizing: border-box;
  }

  .register__button:hover {
    background-color: var(--orange-color);
  }
</style>