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

// select文使用(今回は使用しない)
// function purchase_detail($db, $user_id){
//   $sql = "
//     INSERT INTO
//       purchase_details(
//         order_number,
//         item_id,
//         price,
//         purchase_amount)
//     SELECT
//       purchase_histories.order_number,
//       carts.item_id,
//       items.price,
//       carts.amount
//     FROM
//       carts
//     INNER JOIN
//       purchase_histories
//     ON
//       purchase_histories.user_id = carts.user_id
//     INNER JOIN
//       items
//     ON
//       carts.item_id = items.item_id
//     WHERE
//       carts.user_id = ?
//   ";

//   return execute_query($db, $sql, array($user_id));
// }

// 購入履歴の表示用(管理者)
function get_admin_purchase_history($db){
  $sql = "
  SELECT
	  purchase_histories.order_number,
    users.name,
    purchase_date,
    SUM(purchase_details.price * purchase_details.purchase_amount) as total
FROM
	purchase_histories
INNER JOIN
	purchase_details
ON
	purchase_histories.order_number = purchase_details.order_number
INNER JOIN
  users
ON
  purchase_histories.user_id = users.user_id
GROUP BY
	purchase_histories.order_number
ORDER BY
  purchase_date desc
  ";

  return fetch_all_query($db, $sql);
}
// 購入履歴の表示用(一般)
function get_user_purchase_history($db, $user_id){
  $sql = "
  SELECT
	  purchase_histories.order_number,
    purchase_date,
    SUM(purchase_details.price * purchase_details.purchase_amount) as total
FROM
	purchase_histories
INNER JOIN
	purchase_details
ON
	purchase_histories.order_number = purchase_details.order_number
WHERE
	purchase_histories.user_id = ?
GROUP BY
	purchase_histories.order_number
ORDER BY
  purchase_date desc
  ";

  return fetch_all_query($db, $sql, array($user_id));
}

// 購入詳細の上部分
function get_select_purchase_history($db, $order_number){
  $sql = "
  SELECT
	  purchase_histories.order_number,
    purchase_date,
    SUM(purchase_details.price * purchase_details.purchase_amount) as total
  FROM
    purchase_histories
  INNER JOIN
    purchase_details
  ON
    purchase_histories.order_number = purchase_details.order_number
  WHERE
    purchase_histories.order_number = ?
  GROUP BY
    purchase_histories.order_number
    ";

  return fetch_all_query($db, $sql, array($order_number));
}

// 購入詳細の下部分
function get_select_purchase_detail($db, $order_number){
  $sql = "
    SELECT
    items.name,
    purchase_details.price,
    purchase_details.purchase_amount,
    purchase_details.price * purchase_details.purchase_amount as subtotal
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