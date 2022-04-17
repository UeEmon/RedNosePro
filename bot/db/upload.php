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
      
     //DB接続情報
     require_once('./config/config.php');  /* DB接続用のファイルを読み込む */
  
    //prepareによる実行準備
    $sql = 'insert into content (value,cat_1,cat_2,question,answer) VALUES (:value,:cat_1,:cat_2,:question,:answer)';    
    //$sql = 'insert into content (cat_1,cat_2,question,answer) VALUES (:cat_1,:cat_2,:question,:answer)';    

    $stmt=$pdo->prepare($sql);

    //配列をDBにインサート
    foreach($asins as $asin){
         $stmt->execute($asin);
    }
    
    //DB接続終了
    $stmt = null;
    $pdo = null;
    
    //dbcontrolに戻る
    header('Location: ./dbcontrol.php');
      
    } else {
      $err_msg = "ファイルをアップロードできません。";
      //dbcontrolに戻る
      header('Location: ./dbcontrol.php');
    }
  }
} else {
  $err_msg = "ファイルが選択されていません。";
   //dbcontrolに戻る
   header('Location: ./dbcontrol.php');
}