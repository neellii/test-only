<?php require_once 'header.php'; ?>
  <main class="main">
    <h2>регистрация</h2>

    <form method="post" action="/register.php">
      <div class="input">
        <input type="name" name="name" value="<?= old('name') ?>" placeholder="Имя">
        <?= isset($errors['name']) ? $errors['name'] : '' ?>
        <?= isset($errors['nameRequired']) ? $errors['nameRequired'] : '' ?>
      </div>

      <div class="input">
        <input type="tel" name="telephone" value="<?= old('telephone') ?>" placeholder="Номер телефона">
        <?= isset($errors['telephone']) ? $errors['telephone'] : '' ?>
        <?= isset($errors['incorrectTel']) ? $errors['incorrectTel'] : '' ?>
        <?= isset($errors['telephoneRequired']) ? $errors['telephoneRequired'] : '' ?>
      </div>
      
      <div class="input">
        <input type="email" name="email" value="<?= old('email') ?>" placeholder="Почта">
        <?= isset($errors['email']) ? $errors['email'] : '' ?>
        <?= isset($errors['incorrectEmail']) ? $errors['incorrectEmail'] : '' ?>
        <?= isset($errors['emailRequired']) ? $errors['emailRequired'] : '' ?>
      </div>
      
      <div class="input">
        <input type="password" id="password" name="password" placeholder="Пароль">
        <?= isset($errors['password']) ? $errors['password'] : '' ?>
        <?= isset($errors['passwordRequired']) ? $errors['passwordRequired'] : '' ?>
      </div>

      <div class="input">
        <input type="password" id="password_confirm" name="password_confirm" placeholder="Повторите пароль">
        <?= isset($errors['password']) ? $errors['password'] : '' ?>
        <?= isset($errors['password_confirmRequired']) ? $errors['password_confirmRequired'] : '' ?>
      </div>
      
      <div class="input">
        <input class="submit-btn" type="submit" value="зарегистрироваться">
      </div>
    </form>

    <div class="text">
      <h4>зарегистрированы? <a href="#">Войти</a></h4>
    </div>
  </main>
  <?php get_alerts() ?>
</body>
</html>