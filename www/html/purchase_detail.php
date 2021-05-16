<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'purchase.php';

session_start();
header('X-FRAME-OPTIONS: DENY');

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);
$order_number = get_post('order_number');

if($user['user_id'] !== 4){
  if($user['user_id'] !== get_session('user_id')){
    redirect_to(PURCHASE_URL);
  }
}

$histories = get_select_purchase_history($db, $order_number);
$details = get_select_purchase_detail($db, $order_number);

include_once VIEW_PATH . '/purchase_details_view.php';