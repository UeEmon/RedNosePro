<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>DB検索</title>
    <link rel="stylesheet" type="text/css" href="../../plugin/DataTables/datatables.min.css"/>
	<script type="text/javascript" language="javascript" src="../../plugin/jquery/jquery-3.6.0.slim.min.js"></script>
	<script type="text/javascript" language="javascript" src="../../plugin/DataTables/datatables.min.js"></script>
  </head>
  <body>
	<table id="example" class="display">

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
?>
<thead>
<tr><th>id</th><th>カテゴリー１</th><th>カテゴリー２</th><th>質問</th><th>回答</th></tr>
</thead>
<?php
while( $result = $stmt->fetch( PDO::FETCH_ASSOC ) ){
?>
    <tr>
    <td><?= $result['value'] ?></td>
    <td><?= $result['cat_1'] ?></td>
    <td><?= $result['cat_2'] ?></td>
    <td><?= $result['question'] ?></td>
    <td><?= $result['answer']?></td>
    </tr>
<?php
}



/*
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
*/
?>
</table>

      </body>
<script>
$(document).ready(function(){
   $('#example').DataTable();
});
</script>
</html>