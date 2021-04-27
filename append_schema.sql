-- 購入履歴画面
-- テーブル名 purchase_history
--   カートで注文を確定したら、insertする
-- カラム名
--   注文番号
--   購入日時
--   合計金額 $total_priceを取得
--   ログインユーザーの判別も必要（sessionで判断）

create table purchase_history(
  注文番号 int auto_increment,
  購入日時 datetime,
  use_id int
  );
)

-- -- 購入明細画面
-- テーブル名 purchase_details
--   カートで注文を確定したら、insertする
-- カラム名
--   注文番号 purchase_historyと紐づけ
--   商品名 cartsテーブルのitem_idからitemsテーブルのnameを取得
--   購入時の商品価格 cartsテーブルのitem_idからitemsテーブルのpriceを取得
--   購入数 cartsテーブルのamountを取得
--   小計 $cart['price'] * $cart['amount']で計算
--   ※画面上部には該当の注文番号、購入日時、合計金額を表示

create table purchase_details(
  注文番号 int,
  item_id int,
  price int,
  購入数 int
);