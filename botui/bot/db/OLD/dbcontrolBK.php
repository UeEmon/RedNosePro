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
  CSVファイル：<br />
  <input type="file" name="csvfile" size="30" /><br />
  <input type="submit" value="アップロード" />
</form>
</p>
		</form>
<hr>
		<p>
TABLE削除<br />
 <form id="form2" class="form_wrap" action="./deletetable.php" method="POST">
            <div class="delete_textarea">
                <input type="hidden" name="key" value="delete">
                <input type="submit" value="delete table">
            <div>
            
     	<p>
<hr>
TABLE一覧<br />
     	<table id="example" class="display">
<?php
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

    //DB接続終了
    $stmt = null;
    $pdo = null;
    

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