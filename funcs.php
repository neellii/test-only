<?php
function processPostData($fillable = [], $post = true) {
  $load_data = $post ? $_POST : $_GET;
  $data = [];

  foreach($fillable as $name) {

    if(isset($load_data[$name])) {
      $data[$name] = htmlspecialchars(trim($load_data[$name]), ENT_QUOTES);
    } else {
      $data[$name] = "";
    }

  }
  return $data;
}

function old($field): string {
  return isset($_POST[$field]) ? htmlspecialchars($_POST[$field], ENT_QUOTES) : '';
}

function errorDiv($msg) {
  return "<div class='error'>{$msg}</div>";
}

function get_alerts() {
  if(!empty($_SESSION['alert'])) {
    require_once 'alert.php';
    unset($_SESSION['alert']);
  }  
}

function dump($data) {
  echo '<pre>';
  echo var_dump($data);
  echo '</pre>';
}

function checkAuth() {
  return isset($_SESSION['user']);
}