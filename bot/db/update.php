<?php
//不正対策。idが空であった場合に戻る
$id =$_POST['id'];
if (empty($id)) {
    header("Location: dbcontrol.php");
    exit;
}

// データベースに接続
  require_once('./config/config.php');  /* DB接続用のファイルを読み込む */

// SELECT文を実行
$stmt=$pdo->prepare('UPDATE content SET cat_1 = :cat_1,cat_2 = :cat_2,question = :question, answer = :answer WHERE value= :value ');


// 値をセット
$stmt->bindValue(':value', $_POST['id']);
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
