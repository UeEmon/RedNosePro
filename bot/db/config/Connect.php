<?php
/* データベースに接続するクラス */
class Connect
{
  /* プロパティ(定数)の宣言 */
  const DB_NAME ='botdb.db';
  const HOST    ='localhost';
  const UTF     ='utf8';
  const USER    ='root';
  const PASS    ='root';

  /* データベースに接続する メソッド(関数) */
  public function pdo(){
  	$dsn  = "sqlite:dbname=" .self::DB_NAME;
    //$dsn  = "mysql:dbname=" .self::DB_NAME. "; host=" .self::HOST. "; charset=" .self::UTF;
    //$user = self::USER;
    //$pass = self::PASS;
    try{
      $pdo = new PDO($dsn);
      //$pdo = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.SELF::UTF));
    }catch(Exception $e){
      echo 'エラー '.$e->getMessage;
      die();
    }
    return $pdo;
  }
}

/* SELECT文のときに使用するクラス */
class SelectData extends Connect
{
  /* プロパティ(変数)の宣言 */
  private $sql;

  /* データベースに接続しテーブルデータを取得する メソッド(関数) */
  public function select($sql){
    $items = $this->pdo()->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }
}