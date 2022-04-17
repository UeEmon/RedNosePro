<?php

// データベースに接続
  require_once('./config/config.php');  /* DB接続用のファイルを読み込む */

    //prepareによる実行準備
    $sql = 'insert into content (cat_1,cat_2,question,answer) VALUES (:cat_1,:cat_2,:question,:answer)';    
    $stmt=$pdo->prepare($sql);

// 値をセット
$stmt->bindValue(':cat_1', $_POST['cat_1']);
$stmt->bindValue(':cat_2', $_POST['cat_2']);
$stmt->bindValue(':question', $_POST['question']);
$stmt->bindValue(':answer', $_POST['answer']);

    // SQL実行
$stmt->execute();
 
$pdo = null;
$stmt = null;
    
    // 登録完了メッセージの表示
echo "更新完了";
   //dbcontrolに戻る
   header('Location: ./dbcontrol.php');
?>