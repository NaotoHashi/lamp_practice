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

$histories = get_user_purchase_history($db, $user['user_id']);
$select_history = get_select_purchase_history($db, $order_number);
$total_price = sum_histories($histories);

$details = get_user_purchase_detail($db, $order_number);
$subtotal_price = sum_details($details);

include_once VIEW_PATH . '/purchase_details_view.php';