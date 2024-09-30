<?php
if(!isset($_SESSION)) {
  session_start();
}

require_once 'DB.php';
require_once 'funcs.php';
require_once 'checkCaptcha.php';

// соединение с БД
$conn = Database::getInstance()->getConnection($dbConfig);

// токен, сгенерированный SmartCaptcha
$token = $_POST['smart-token'];

// обработка данных POST (trim, htmlspecialchars)
$data = processPostData(['login', 'password']);

// объявление массива $errors, в который в случае невалидности данных записываем сообщение об ошибке
$errors = [];
$errorMessages = [
  'incorrect' => 'Неверный логин или пароль',
  'required' => 'Данное поле обязательно',
  'captcha' => 'Пройдите антиспам проверку',
];

// проверка captcha
if (!check_captcha($token)) {
  $errors['captcha'] = errorDiv($errorMessages['captcha']);
}

// порверка на пустые поля в форме
foreach($data as $k => $v) {
  if(empty($k)) {
    $errors[$k . 'Required'] = errorDiv($errorMessages['required']);
  }
}

// определение типа введенного пользователем значения 
$login = preg_match('~^(?:\+7|8)\d{10}$~', $data['login']) ? 'telephone' : 'email';

// проверка логина и пароля на соответствие с БД
if($login === 'telephone' && !$user = $conn->rowExists('telephone', 'users', $data['login'])) {
  $errors['incorrect'] = errorDiv($errorMessages['incorrect']);
} elseif($login === 'email' && !$user = $conn->rowExists('email', 'users', $data['login'])) {
  $errors['incorrect'] = errorDiv($errorMessages['incorrect']);
}

if(!password_verify($data['password'], $user['password'])) {
  $errors['incorrect'] = errorDiv($errorMessages['incorrect']);
}

// при отсутствии ошибок записываем в сессию данные пользователя
if(empty($errors)) {
  $_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'telephone' => $user['telephone'],
    'email' => $user['email']
  ];

  header('Location: /dashboard.php');
}

require_once 'login.php';