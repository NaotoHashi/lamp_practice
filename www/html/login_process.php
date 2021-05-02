<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();
header('X-FRAME-OPTIONS: DENY');

if(is_logined() === true){
  redirect_to(HOME_URL);
}

$name = get_post('name');
$password = get_post('password');

$db = get_db_connect();
$get_token = get_post('token');

$user = login_as($db, $name, $password);

if(is_valid_token($get_token) === true){
  if($user === false){
    set_error('ログインに失敗しました。');
    redirect_to(LOGIN_URL);
  }

  set_message('ログインしました。');
  if ($user['type'] === USER_TYPE_ADMIN){
    redirect_to(ADMIN_URL);
  }
}else{
  set_error('不正なリクエストです。');
}

redirect_to(HOME_URL);