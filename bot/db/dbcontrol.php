<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>DBコントロール</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link rel="stylesheet" href="../css/botui-theme-default.css" / -->
    <!-- link rel="stylesheet" href="../css/botui.min.css" / -->
    <!--link rel="stylesheet" href="https://unpkg.com/botui/build/botui.min.css" / -->
    <!--link rel="stylesheet" href="https://unpkg.com/botui/build/botui-theme-default.css" / -->
    
    <link rel="stylesheet" type="text/css" href="../../plugin/DataTables/datatables.min.css"/>
	<script type="text/javascript" language="javascript" src="../../plugin/jquery/jquery-3.6.0.slim.min.js"></script>
	<script type="text/javascript" language="javascript" src="../../plugin/DataTables/datatables.min.js"></script>
    
    
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
<hr>
<p>
CSVファイルを選択して下さい<br />
<form action="./upload.php" method="post" enctype="multipart/form-data">
  CSVファイル：
  <input type="file" name="csvfile" size="30" /><br />
  <input type="submit" value="アップロード" />
</form>
</p>
		</form>
<hr>
		<p>
TABLE削除<br />
 <form id="form2" class="form_wrap" action="./deletetable.php" method="POST">
            <div class="delete_table_textarea">
                <input type="hidden" name="key" value="delete">
                <input type="submit" value="delete table">
            <div>
</form>
     	<p>
<hr>
TABLE一覧<br />
 <button formaction="./insert_item.php">新規登録</button>

     	<table id="example" class="display">
<?php
   require_once('./config/config.php');  /* DB接続用のファイルを読み込む */
   $sql = "SELECT * FROM content";
   $stmt = $pdo->query( $sql );
?>
<thead>
<tr><th>id</th><th>カテゴリー１</th><th>カテゴリー２</th><th>質問</th><th>回答</th><th>更新</th><th>削除</th></tr>
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
    

    <td>
   <form action="update_item.php" class="form_wrap" method="POST"  id="form3">
            <div class="edit_item_textarea">
                <input type="hidden" name="id" value="<?= $result['value'] ?> ">
                <input type="submit" value="更　新">
            <div>
    </form>

    </td>
            
            <td>
    <form action="delete_item.php" class="form_wrap" method="POST"  id="form4">
            <div class="delete_item_textarea">
                <input type="hidden" name="id" value="<?= $result['value'] ?> ">
                <input type="submit" value="削　除">
            <div>
    </form>
            </td>

    </tr>
<?php
}
    //DB接続終了
    $stmt = null;
    $pdo = null;
    ?>
</table>

      </body>
<script>
$(document).ready(function(){
   $('#example').DataTable();
});
</script>
</html>