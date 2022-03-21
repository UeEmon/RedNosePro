<?php
/* データベース設定 */
//define('DB_DNS', 'mysql:host=localhost; dbname=cri_sortable; charset=utf8');
define('DB_DNS', 'sqlite:botdb.db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

/* データベースへ接続
======================================================== */
try {
  //$dbh = new PDO(DB_DNS, DB_USER, DB_PASSWORD);
  $pdo = new PDO(DB_DNS);
  // SQL実行時にもエラーの代わりに例外を投げるように設定
  // (毎回if文を書く必要がなくなる)
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // デフォルトのフェッチモードを連想配列形式に設定 
  // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $error){
    echo "接続失敗:".$error->getMessage();
    die();
}