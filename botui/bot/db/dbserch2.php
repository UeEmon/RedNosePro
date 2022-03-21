<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>DB検索</title>
  </head>
  <body>
	<table id="example" class="display">

<?php
   require_once('../../head.php');  /* HEAD */
   require_once('./config/config.php');  /* DB接続用のファイルを読み込む */
   
   
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
?>
</table>

      </body>
<script>
$(document).ready(function(){
   $('#example').DataTable();
});
</script>
</html>