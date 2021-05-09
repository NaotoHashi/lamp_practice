<!DOCTYPE html>
<html lang='ja'>
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>

  <title>購入履歴</title>
  <link rel='stylesheet' href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  
  <div class="container">
    <h1>購入履歴</h1>

    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
          <th>注文番号</th>
          <?php if(is_admin($user) === true) { ?>
            <th>注文者</th>
          <?php } ?>
          <th>注文日時</th>
          <th>合計金額</th>
          <th>購入詳細</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($histories as $history){ ?>
        <tr>
          <td><?php print $history['order_number']; ?></td>
          <?php if(is_admin($user) === true) { ?>
            <td><?php print $history['name']; ?></td>
          <?php } ?>
          <td><?php print $history['purchase_date']; ?></td>
          <td><?php print htmlspecialchars(number_format($history['total']), ENT_QUOTES, 'UTF-8'); ?>円</td>
          <td>
            <form method='post' action='purchase_detail.php'>
              <input type='hidden' name='token' value='<?php print $token; ?>'>
              <input type='hidden' name='order_number' value="<?php print $history['order_number']; ?>">
              <input class='btn btn-block btn-primary' type='submit' value='詳細画面'>
            </form>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>


  </div>

</body>
</html>
