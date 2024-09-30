<?php 
require_once 'header.php';
require_once 'config.php';
 ?>
<body>
  <main class="main">
    <h2>Авторизация</h2>

    <form action="/authorize.php" method="post">
      <div class="input">
        <input type="text" name="login" value="<?= old('login') ?>" placeholder="Телефон или email">
        <?= isset($errors['loginRequired']) ? $errors['loginRequired'] : '' ?>
      </div>

      <div class="input">
        <input type="password" name="password" placeholder="Пароль">
        <?= isset($errors['passwordRequired']) ? $errors['passwordRequired'] : '' ?>
      </div>
      <?= isset($errors['incorrect']) ? $errors['incorrect'] : '' ?>

      <div id="captcha" style="height: 100px; margin-top: 20px"></div>

      <?= isset($errors['captcha']) ? $errors['captcha'] : '' ?>

      <div class="input">
        <input class="submit-btn" type="submit" value="войти">
      </div>
    </form>

    <div class="text">
      <h4> не зарегистрированы? <a href="#">регистрация</a></h4>
    </div>

  </main>

  <?php get_alerts() ?>
</body>
<script
    src="https://smartcaptcha.yandexcloud.net/captcha.js?render=onload&onload=onloadFunction"
    defer
></script>
<script>
    function onloadFunction() {
    if (window.smartCaptcha) {
      const container = document.getElementById('captcha');

      const widgetId = window.smartCaptcha.render(container, {
          sitekey: <?= SMARTCAPTCHA_SITE_KEY ?>,
          hl: 'ru',
      });
    }
    }
</script>
</html>
