<?php
 //画面からパラメータ取得
 
   try {
    //DB接続情報
    $pdo = new PDO('sqlite:./botdb.db');

    // SQL実行時にもエラーの代わりに例外を投げるように設定
    // (毎回if文を書く必要がなくなる)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デフォルトのフェッチモードを連想配列形式に設定 
    // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);    
     $sql = "SELECT * FROM content";
  	 $result = $pdo->query($sql); 
  
  
       //CSV文字列生成
     $csvstr = "";
     while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
       $csvstr .= $row['value'] . ",";
       $csvstr .= $row['cat_1'] . ",";
       $csvstr .= $row['cat_2'] . ",";
       $csvstr .= $row['question'] . ",";
       $csvstr .= $row['answer'] . "\r\n";
     }

     //CSV出力
     $fileNm = "export.csv";
     header('Content-Type: text/csv');
     header('Content-Disposition: attachment; filename='.$fileNm);
     echo mb_convert_encoding($csvstr, "SJIS", "UTF-8"); //Shift-JISに変換したい場合のみ
     exit();

   }catch(ErrorException $ex){
     print('ErrorException:' . $ex->getMessage());
   }catch(PDOException $ex){
     print('PDOException:' . $ex->getMessage());
   }