<?php 
if(!isset($_SESSION)) {
  session_start();
}
require_once 'funcs.php' ?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Форма регистрации</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body> 
<header class="header">
  <a href="#" class="logo">Тестовое Only</a>
  <ul>
    <?php if(!checkAuth()): ?>
    <li><a href="index.php">Регистрация</a></li>
    <li><a href="login.php">Войти</a></li>
    <li><a href="dashboard.php">Профиль</a></li>
    <?php else: ?>
    <li><a href="dashboard.php"><?= $_SESSION['user']['name'] ?></a></li>
    <li><a href="logout.php">Выйти</a></li>
    <?php endif; ?>
  </ul>
</header>