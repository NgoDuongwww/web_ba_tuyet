<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login & Register</title>
  <link rel="icon" href="/public/images/logo.webp">
  <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
  <div class="login">
    <div class="login__container">
      <h1 class="login__title">Admin Login</h1>
      <form class="login__form" action="login.php" method="POST">
        <div class="login__form-group">
          <input type="text" name="username" class="login__input" placeholder="Username" required>
        </div>
        <div class="login__form-group">
          <input type="password" name="password" class="login__input" placeholder="Password" required>
        </div>
        <button type="submit" class="login__button">Login</button>
      </form>
    </div>
  </div>
</body>

</html>