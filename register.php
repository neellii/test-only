<?php
if(!isset($_SESSION)) {
  session_start();
}
require_once 'DB.php';
require_once 'funcs.php';

// соединение с БД
$conn = Database::getInstance()->getConnection($dbConfig);

// обработка данных POST (trim, htmlspecialchars)
$data = processPostData(['name', 'telephone', 'email', 'password', 'password_confirm']);

// объявление массива $errors, в который в случае невалидности данных записываем сообщение об ошибке
$errors = [];
$errorMessages = [
  'password' => 'Пароли должны совпадать',
  'unique' => 'Данное поле уже занято',
  'incorrectTel' => 'Введите корректный номер телефона (+7xxxxxxxxxx) либо (8xxxxxxxxxx)',
  'incorrectEmail' => 'Введите корректный email',
  'required' => 'Данное поле обязательно',
];

// ошибка если пароли не совпадают
if($data['password'] !== $data['password_confirm']) {
  $errors['password'] = errorDiv($errorMessages['password']);
}

// проверка на уникальность в БД в случае новых значений от пользователя
$checkUnique = ['name', 'telephone', 'email'];
foreach($checkUnique as $field) {
  if($conn->rowExists($field, 'users', $data[$field])) {
    $errors[$field] = errorDiv($errorMessages['unique']);
  }
}

// порверка на пустые поля в форме
foreach($data as $k => $v) {
  if(empty($k)) {
    $errors[$k . 'Required'] = errorDiv($errorMessages['required']);
  }
}

// проверка на валидность номера телефона и email
if(!preg_match('~^(?:\+7|8)\d{10}$~', $data['telephone'])) {
  $errors['incorrectTel'] = errorDiv($errorMessages['incorrectTel']);
}

if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
  $errors['incorrectEmail'] = errorDiv($errorMessages['incorrectEmail']);
}

// при отсутствии ошибок обновление записи в БД
if(empty($errors)) {
  $conn->query("INSERT INTO users (name, telephone, email, password) VALUES (?, ?, ?, ?)", [$data['name'], $data['telephone'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);
  $_SESSION['alert'] = 'Регистрация успешна';
  header('Location: /login.php');
  die();
}

require_once 'index.php';
