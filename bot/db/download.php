<?php
 //画面からパラメータ取得
 try {
   require_once('./config/config.php');  /* DB接続用のファイルを読み込む */
   $sql = "SELECT * FROM content";
   $stmt = $pdo->query( $sql );

       //CSV文字列生成
     $csvstr = "";
     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
     echo $csvstr;
     //echo mb_convert_encoding($csvstr, "SJIS", "UTF-8"); //Shift-JISに変換したい場合のみ
     exit();

   }catch(ErrorException $ex){
     print('ErrorException:' . $ex->getMessage());
   }catch(PDOException $ex){
     print('PDOException:' . $ex->getMessage());
   }
   
   //dbcontrolに戻る
    header('Location: ./dbcontrol.php');