<?php
if(!isset($_SESSION)) {
  session_start();
}
require_once 'DB.php';
require_once 'funcs.php';

// соединение с БД
$conn = Database::getInstance()->getConnection($dbConfig);

// обработка данных POST (trim, htmlspecialchars)
$data = processPostData(['name', 'telephone', 'email', 'old_password','password', 'password_confirm']);

// объявление массива $errors, в который в случае невалидности данных записываем сообщение об ошибке
$errors = [];
$errorMessages = [
  'password' => 'Пароли должны совпадать',
  'unique' => 'Данное поле уже занято',
  'incorrectTel' => 'Введите корректный номер телефона (+7xxxxxxxxxx) либо (8xxxxxxxxxx)',
  'incorrectEmail' => 'Введите корректный email',
  'incorrectPassword' => 'Неверный старый пароль',
  'passwordEmpty' => 'Введите данное поле',
];

// проверка на уникальность в БД в случае новых значений от пользователя
$checkUnique = ['name', 'telephone', 'email'];

foreach($checkUnique as $field) {
  if(empty($data[$field])) {
    $data[$field] = $_SESSION['user'][$field];
  }
  
  if($_SESSION['user'][$field] !== $data[$field] && $conn->rowExists($field, 'users', $data[$field])) {
    $errors[$field] = errorDiv($errorMessages['unique']);
  }
}

// если введено значение password, то проверка и валидация нового password
$passwordFields = ['password', 'old_password', 'password_confirm'];
if(!empty($data['password'])) {
  foreach($passwordFields as $field) {
    if (empty($field)) {
      $errors['passwordEmpty'] = errorDiv($errorMessages['passwordEmpty']);
    }
  }

  if(!$conn->rowExists('password', 'users', $data['old_password'])) {
    $errors['incorrectPassword'] = errorDiv($errorMessages['incorrectPassword']);
  };
  
  if($data['password'] !== $data['password_confirm']) {
    $errors['password'] = errorDiv($errorMessages['password']);
  }
}

// проверка на валидность номера телефона и email
if($_SESSION['user']['telephone'] !== $data['telephone'] && !preg_match('~^(?:\+7|8)\d{10}$~', $data['telephone'])) {
  $errors['incorrectTel'] = errorDiv($errorMessages['incorrectTel']);
}

if($_SESSION['user']['email'] !== $data['email'] && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
  $errors['incorrectEmail'] = errorDiv($errorMessages['incorrectEmail']);
}

// при отсутствии ошибок обновление записи в БД и в массиве $_SESSION
if(empty($errors)) {
  if(!empty($data['password'])) {
    $conn->query("INSERT INTO users (name, telephone, email, password) VALUES (?, ?, ?, ?)", [$data['name'], $data['telephone'], $data['email'], password_hash($data['password'], PASSWORD_DEFAULT)]);
  } else {
    $conn->query("INSERT INTO users (name, telephone, email) VALUES (?, ?, ?)", [$data['name'], $data['telephone'], $data['email']]);
  }
  
  $_SESSION['alert'] = 'Данные успешно изменены';
  $_SESSION['user'] = [
    'name' => $data['name'],
    'telephone' => $data['telephone'],
    'email' => $data['email']
  ];
  header('Location: /dashboard.php');
  die();
}

require_once 'dashboard.php';