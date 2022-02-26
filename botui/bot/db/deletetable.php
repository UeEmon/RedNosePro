<?php
//テーブル削除
  	 // 接続
    $pdo = new PDO('sqlite:botdb.db');

    // SQL実行時にもエラーの代わりに例外を投げるように設定
    // (毎回if文を書く必要がなくなる)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デフォルトのフェッチモードを連想配列形式に設定 
    // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

	//DELETE TABLE
	$sql = "drop table content";
    $result = $pdo->query($sql); 
    
       // テーブルが存在しない場合はテーブル作成
    $pdo->exec("CREATE TABLE IF NOT EXISTS content(
        value INTEGER PRIMARY KEY AUTOINCREMENT,
        cat_1 VARCHAR(100),
        cat_2 VARCHAR(100),
        question TEXT,
        answer TEXT
    )");

