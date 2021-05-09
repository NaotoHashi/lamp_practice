<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'purchase.php';

session_start();
$token = get_csrf_token();
header('X-FRAME-OPTIONS: DENY');

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

if(is_admin($user) === true){
  $histories = get_admin_purchase_history($db);
}else{
  $histories = get_user_purchase_history($db, $user['user_id']);
}

include_once VIEW_PATH . '/purchase_history_view.php';