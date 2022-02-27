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

      //DB接続情報
      $pdo = new PDO('sqlite:./botdb.db');
      // SQL実行時にもエラーの代わりに例外を投げるように設定
         
     $sql ="SELECT * FROM content";
     $stmt = $pdo->query( $sql );
 
    
     
      $edit = "";
      
      
      while( $data = $stmt->fetch( PDO::FETCH_ASSOC ) ) {
            $edit .= "{$data['']},{$data['']},{$data['']},{$data['']},{$data['']}\n";
        }
        
		print_r($edit);
       // fwrite($fp, $edit);

/*




      //配列に変換する
      while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
        $asins[] = $data;
      }
*/
      fclose($fp);
      //ファイルの削除
      //unlink('../../tmp/uploaded/'.$file_name);
      
  //    print_r($asins);
      
      /*
    $arrayValues = "";
    foreach ($asins as $asin) {
        $arrayValues[] = "('{$asain}',)";
    }
    */
   // print_r($arrayValues);
    
    //prepareによる実行準備
//    $sql="INSERT INTO content (value,cat_1,cat_2,question,answer) VALUES " .join(",",$asins );
    
    //print_r($sql);
    //$stmt=$pdo->prepare($sql);
    
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