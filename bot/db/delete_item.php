<html>
<body>
<?php
// データベースに接続
  require_once('./config/config.php');  /* DB接続用のファイルを読み込む */

// DELETE文を実行
$sql = "delete from content where value=".$_POST['id'];
$stmt=$pdo->query($sql);

//データベースから切断
$pdo = null;
$stmt = null;

// 登録完了メッセージの表示
echo "削除完了";
   //dbcontrolに戻る
   header('Location: ./dbcontrol.php');
?>
</body>
</html>