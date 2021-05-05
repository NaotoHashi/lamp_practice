<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function purchase_history($db, $user_id){
  $date = date("Y-m-d H:i:s");
  $sql = "
    INSERT INTO
      purchase_histories(
        purchase_date,
        user_id
      )
    VALUES(?, ?)
  ";

  return execute_query($db, $sql, array($date, $user_id));
}

function purchase_detail($db, $order_number, $item_id, $price, $amount){
  
  $sql = "
    INSERT INTO
      purchase_details(
        order_number,
        item_id,
        price,
        purchase_amount
      )
    VALUES(?, ?, ?, ?)
  ";

  return execute_query($db, $sql, array($order_number, $item_id, $price, $amount));
}

function get_user_purchase_history($db, $user_id){
  $sql = "
    SELECT
      purchase_histories.order_number,
      purchase_histories.purchase_date,
      purchase_histories.user_id,
      purchase_details.price,
      purchase_details.purchase_amount
    FROM
      purchase_histories
    INNER JOIN
      purchase_details
    ON
      purchase_histories.order_number = purchase_details.order_number
    WHERE
      purchase_histories.user_id = ?
  ";

  return fetch_all_query($db, $sql, array($user_id));
}

function get_select_purchase_history($db, $order_number){
  $sql = "
    SELECT
      purchase_histories.order_number,
      purchase_histories.purchase_date,
      purchase_histories.user_id,
      purchase_details.price,
      purchase_details.purchase_amount
    FROM
      purchase_histories
    INNER JOIN
      purchase_details
    ON
      purchase_histories.order_number = purchase_details.order_number
    WHERE
      purchase_histories.order_number = ?
  ";

  return fetch_query($db, $sql, array($order_number));
}

function sum_histories($histories){
  $total_price = 0;
  foreach($histories as $history){
    $total_price += $history['price'] * $history['purchase_amount'];
  }
  return $total_price;
}

function get_user_purchase_detail($db, $order_number){
  $sql = "
    SELECT
      purchase_details.order_number,
      purchase_details.price,
      purchase_details.purchase_amount,
      items.name
    FROM
      purchase_details
    INNER JOIN
      items
    ON
      purchase_details.item_id = items.item_id
    WHERE
      purchase_details.order_number = ?
  ";

  return fetch_all_query($db, $sql, array($order_number));
}

function sum_details($details){
  $subtotal_price = 0;
  foreach($details as $detail){
    $subtotal_price = $detail['price'] * $detail['purchase_amount'];
  }
  return $subtotal_price;
}