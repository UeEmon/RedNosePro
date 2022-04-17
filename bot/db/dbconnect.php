<?php
class connect {
  //定数の宣言
  //const DB_NAME='botdb.db';
  //const HOST='localhost';
  //const UTF='utf8';
  //const USER='user';
  //const PASS='pass';
  //データベースに接続する関数
  function pdo(){
    /*phpのバージョンが5.3.6よりも古い場合はcharset=".self::UTFが必要無くなり、array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF')が必要になり、5.3.6以上の場合は必要ないがcharset=".self::UTFは必要になる。*/
   // $dsn="mysql:dbname=".self::DB_NAME.";host=".self::HOST.";charset=".self::UTF;
    //$user=self::USER;
    //$pass=self::PASS;
    $dsn="sqlite:botdb.db"; 
    try{
      //$pdo=new PDO($dsn,$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF));
      $pdo=new PDO('sqlite:botdb.db');

    }catch( PDOException $error ){
    echo "接続失敗:".$error->getMessage();
    die();
    }
    // SQL実行時にもエラーの代わりに例外を投げるように設定
    // (毎回if文を書く必要がなくなる)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デフォルトのフェッチモードを連想配列形式に設定 
    // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    
    //エラーを表示してくれる。
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    return $pdo;
  }
  //SELECT文のときに使用する関数。
  function select($sql){
    $stmt=$pdo->query($sql);
    return $stmt;
  }
  //SELECT,INSERT,UPDATE,DELETE文の時に使用する関数。
  function plural($sql,$item){
    $hoge=$this->pdo();
    $stmt=$hoge->prepare($sql);
    $stmt->execute(array(':id'=>$item));//sql文のVALUES等の値が?の場合は$itemでもいい。
    return $stmt;
  }
}
?>