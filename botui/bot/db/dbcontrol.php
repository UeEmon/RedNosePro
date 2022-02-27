<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>チャットボット</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link rel="stylesheet" href="../css/botui-theme-default.css" / -->
    <!-- link rel="stylesheet" href="../css/botui.min.css" / -->
    <!--link rel="stylesheet" href="https://unpkg.com/botui/build/botui.min.css" / -->
    <!--link rel="stylesheet" href="https://unpkg.com/botui/build/botui-theme-default.css" / -->
  </head>
  <body>
  <p>
CSV出力をおこないます。<br />
  <form id="form1" class="form_wrap" action="./download.php" method="POST">
            <div class="csv_export_textarea">
                <input type="hidden" name="key" value="runrunrun">
                <input type="submit" value="csv export">
            <div>
</form>

<p>
CSVファイルを選択して下さい<br />
<form action="./upload.php" method="post" enctype="multipart/form-data">
  CSVファイル：<br />
  <input type="file" name="csvfile" size="30" /><br />
  <input type="submit" value="アップロード" />
</form>
</p>
		</form>
		
		<p>
TABLE削除<br />
 <form id="form2" class="form_wrap" action="./deletetable.php" method="POST">
            <div class="delete_textarea">
                <input type="hidden" name="key" value="delete">
                <input type="submit" value="delete table">
            <div>
            
     	<p>
TABLE一覧<br />
       
<?php
    // 接続
    try{
    $pdo = new PDO('sqlite:botdb.db');
    }catch( PDOException $error ){
    echo "接続失敗:".$error->getMessage();
    die();
    }
    // SQL実行時にもエラーの代わりに例外を投げるように設定
    // (毎回if文を書く必要がなくなる)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デフォルトのフェッチモードを連想配列形式に設定 
    // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


$sql = "SELECT * FROM content";
$stmt = $pdo->query( $sql );

echo "<table>\n";
echo "\t<tr><th>id</th><th>カテゴリー１</th><th>カテゴリー２</th><th>質問</th><th>回答</th></tr>\n";
while( $result = $stmt->fetch( PDO::FETCH_ASSOC ) ){
    echo "\t<tr>\n";
    echo "\t\t<td>{$result['value']}</td>\n";
    echo "\t\t<td>{$result['cat_1']}</td>\n";
    echo "\t\t<td>{$result['cat_2']}</td>\n";
    echo "\t\t<td>{$result['question']}</td>\n";
    echo "\t\t<td>{$result['answer']}</td>\n";
    echo "\t</tr>\n";
}
echo "</table>\n";

?>



      </body>
</html>