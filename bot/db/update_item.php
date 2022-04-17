<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ITEM EDIT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<script type="text/javascript" language="javascript" src="../../plugin/jquery/jquery-3.6.0.slim.min.js"></script>

    
  </head>


<body>


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
$sql = "SELECT * FROM content where value=".$_POST['id'];
//$sql = "SELECT * FROM content";
$stmt=$pdo->query($sql);

	

?>
 
<?php
while( $result = $stmt->fetch( PDO::FETCH_ASSOC ) ){
?>

<form action="./update.php" method="POST">
<input type="hidden" name="id" value=<?= $result['value'] ?>> 
カテゴリー１:
<input type="text" name="cat_1" id="cat_1" style="width:1000px;height:10px;" value=<?= $result['cat_1'] ?>><br>
カテゴリー２:
<input type="text" name="cat_2" id="cat_2" style="width:1000px;height:10px;" value=<?= $result['cat_2'] ?>><br>
質問:
<input type="text" name="question" id="question" style="width:1000px;height:200px;" value=<?= $result['question'] ?>><br>
回答:
<input type="text" name="answer" id="answer" style="width:1000px;height:300px;" value=<?= $result['answer'] ?>><br>
 <input type="submit" value="更　新">
 <button formaction="./dbcontrol.php">戻　る</button>
 </form>



<?php
};
//データベースから切断
$pdo = null;
$stmt = null;
?>

</body>
</html>