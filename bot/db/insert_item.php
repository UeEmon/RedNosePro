<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>INSERT ITEM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<script type="text/javascript" language="javascript" src="../../plugin/jquery/jquery-3.6.0.slim.min.js"></script>

    
  </head>


<body>
 
<form action="./insert.php" method="POST">
<input type="hidden" name="id" value="TEST"> 
カテゴリー１:
<input type="text" name="cat_1" id="cat_1" style="width:1000px;height:10px;"  value=  ><br>
カテゴリー２:
<input type="text" name="cat_2" id="cat_2" style="width:1000px;height:10px;" value= ><br>
質問:
<input type="text" name="question" id="question" style="width:1000px;height:200px;" value= ><br>
回答:
<input type="text" name="answer" id="answer" style="width:1000px;height:300px;" value= ><br>
 <input type="submit" value="新規登録">
 <button formaction="./dbcontrol.php">戻　る</button>
 </form>

</body>
</html>