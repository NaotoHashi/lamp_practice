<!DOCTYPE html>
<html lang='ja'>
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>

  <title>購入詳細</title>
  <link rel='stylesheet' href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  
  <div class="container">
    <h1>購入詳細</h1>

    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>注文日時</th>
          <th>合計金額</th>
        </tr>
      </thead>
      <tbody>
       
        <tr>
          <td><?php print $select_history['purchase_date']; ?></td>
          <td><?php print htmlspecialchars(number_format($total_price), ENT_QUOTES, 'UTF-8'); ?>円</td>
        </tr>
        
      </tbody>
    </table>

    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>商品名</th>
          <th>価格</th>
          <th>数量</th>
          <th>小計</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($details as $detail){ ?>
        <tr>
          <td><?php print htmlspecialchars($detail['name'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?php print htmlspecialchars(number_format($detail['price']), ENT_QUOTES, 'UTF-8'); ?>円</td>
          <td><?php print htmlspecialchars(number_format($detail['purchase_amount']), ENT_QUOTES, 'UTF-8'); ?>個</td>
          <td><?php print htmlspecialchars(number_format($subtotal_price), ENT_QUOTES, 'UTF-8'); ?>円</td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <a class='btn btn-primary' href="purchase.php">一覧に戻る</a>

  </div>

</body>
</html>
