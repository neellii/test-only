<?php 
if(!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['user'])) {
  header('Location: login.php');
}
require_once 'header.php'; ?>

<main class="main">
  <h2>Редактировать профиль</h2>
  <form method="post" action="/editProfile.php">
    <div class="input">
      <input type="name" name="name" value="<?= $_SESSION['user']['name'] ?>" placeholder="Имя">
      <?= isset($errors['name']) ? $errors['name'] : '' ?>
    </div>

    <div class="input">
      <input type="tel" name="telephone" value="<?= $_SESSION['user']['telephone'] ?>" placeholder="Номер телефона">
      <?= isset($errors['telephone']) ? $errors['telephone'] : '' ?>
      <?= isset($errors['incorrectTel']) ? $errors['incorrectTel'] : '' ?>
    </div>
    
    <div class="input">
      <input type="email" name="email" value="<?= $_SESSION['user']['email'] ?>" placeholder="Почта">
      <?= isset($errors['email']) ? $errors['email'] : '' ?>
      <?= isset($errors['incorrectEmail']) ? $errors['incorrectEmail'] : '' ?>
    </div>

    <div class="input">
      <input type="password" name="old_password" placeholder="Старый пароль">
      <?= isset($errors['old_password']) ? $errors['old_password'] : '' ?>
      <?= isset($errors['passwordEmpty']) ? $errors['passwordEmpty'] : '' ?>
    </div>
    
    <div class="input">
      <input type="password" name="password" placeholder="Новый пароль">
      <?= isset($errors['password']) ? $errors['password'] : '' ?>
      <?= isset($errors['passwordEmpty']) ? $errors['passwordEmpty'] : '' ?>
    </div>

    <div class="input">
      <input type="password" name="password_confirm" placeholder="Повторите пароль">
      <?= isset($errors['password']) ? $errors['password'] : '' ?>
      <?= isset($errors['passwordEmpty']) ? $errors['passwordEmpty'] : '' ?>
    </div>
    <?= isset($errors['incorrectPassword']) ? $errors['incorrectPassword'] : '' ?>
    
    <div class="input">
      <input class="submit-btn" type="submit" value="сохранить">
    </div>
  </form>
</main>
<?php get_alerts() ?>
</body>
</html>