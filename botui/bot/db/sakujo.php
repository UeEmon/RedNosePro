<?php
// データベースに接続
require_once('./config/config.php');  /* DB接続用のファイルを読み込む */

// DELETE文を実行
$sql = "DELETE FROM content WHERE value = 1";
$stmt=$pdo->query($sql);

// データベースから切断
$pdo = null;
$stmt = null;
?>