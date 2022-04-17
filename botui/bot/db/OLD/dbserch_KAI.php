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
  require_once  ("./dbconnect.php");
  
  //クラスの生成
  $obj=new connect();
  
  $obj->pdo();
  
  $sqls = "SELECT * FROM content";
  
  $stm=$obj->select($sqls);
  
?>
<thead>
<tr><th>id</th><th>カテゴリー１</th><th>カテゴリー２</th><th>質問</th><th>回答</th></tr>
</thead>
<?php
while( $result = $stm->fetch( PDO::FETCH_ASSOC ) ){
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