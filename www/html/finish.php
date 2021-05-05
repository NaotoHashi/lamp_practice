<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'db.php';
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

$carts = get_user_carts($db, $user['user_id']);

foreach($carts as $read){
  $item_id = $read['item_id'];
  $price = $read['price'];
  $amount = $read['amount'];
}

$get_token = get_post('token');

if(is_valid_token($get_token) === true){
  
  try{
    $db -> beginTransaction();
    // 購入履歴の書き込み
    purchase_history($db, $user['user_id']);
    $order_number = $db -> lastInsertId();
    purchase_detail($db, $order_number, $item_id, $price, $amount);
    // 購入が成功したら、cartsを空にする
    purchase_carts($db, $carts);

    $db -> commit();
  }catch (PDOException $e){
    $db -> rollback();
    throw $e;
    set_error('商品が購入できませんでした。');
    redirect_to(CART_URL);
  }
}else{
  set_error('不正なリクエストです。');
  redirect_to(CART_URL);
}

$total_price = sum_carts($carts);

// 購入履歴のテーブルに書き込むコントローラーが必要

include_once '../view/finish_view.php';