<?php
if (is_uploaded_file($_FILES["csvfile"]["tmp_name"])) {
  $file_tmp_name = $_FILES["csvfile"]["tmp_name"];
  $file_name = $_FILES["csvfile"]["name"];

  //拡張子を判定
  if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv') {
    $err_msg = 'CSVファイルのみ対応しています。';
  } else {
  	
  	
  	
    //ファイルをdataディレクトリに移動
    if (move_uploaded_file($file_tmp_name, "../../tmp/uploaded/" . $file_name)) {
      //後で削除できるように権限を644に
      chmod("../../tmp/uploaded/" . $file_name, 0644);
      $msg = $file_name . "をアップロードしました。";
      $file = '../../tmp/uploaded/'.$file_name;
      $fp   = fopen($file, "r");

      //配列に変換する
      while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
        $asins[] = $data;
      }

      fclose($fp);
      //ファイルの削除
      unlink('../../tmp/uploaded/'.$file_name);
      
      print_r($asins);
      
      //DB接続情報
    $pdo = new PDO('sqlite:./botdb.db');

    // SQL実行時にもエラーの代わりに例外を投げるように設定
    // (毎回if文を書く必要がなくなる)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デフォルトのフェッチモードを連想配列形式に設定 
    // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);    
   
   
    $arrayValues = "";
    foreach ($asins as $asin) {
        $arrayValues[] = "('{$asain}',)";
    }
    
   // print_r($arrayValues);
    
    //prepareによる実行準備
    //$sql="INSERT INTO content (0,1,2,3,4) VALUES ;
    
    //print_r($sql);
    $stmt=$pdo->prepare("insert into content values(:asain)");
    
    //foreach($asins as $asin){
    //    $stmt->excute($asin);
    //}
    
    
      
    } else {
      $err_msg = "ファイルをアップロードできません。";
    }
  }
} else {
  $err_msg = "ファイルが選択されていません。";
}