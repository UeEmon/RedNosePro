<?php
//  =====
//  MySQLデータベース操作クラス  [cPDOSQLite.php]
//  =====
 
//  デフォルトのDB指定値
define('SQLite_DBNAME',  'hoge.db');
define('SQLite_CHARSET', 'UTF8');
 
class cPDOMySQL {
    private $pdo;       //  PDOクラスインスタンス
    private $dbname;    //  データベース名
    private $charset;   //  キャラクタセット名
 
    //  最終実行SQL
    private $sql;
 
    //  最終発生エラー情報(配列データ)
    //      配列[0]:SQLSTATE エラーコード (これは、ANSI SQL 標準で定義された英数 5 文字の ID)
    //      配列[1]:ドライバ固有のエラーコード
    //      配列[2]:ドライバ固有のエラーメッセージ
    private $error;
 
    //  =====
    //  最終発生エラー情報の取得
    //  =====
    //  [返り値]
    //   array      PDO::errorInfo() または PDOStatement::errorInfo()
    public function getLastError() {
        return $this->error;
    }
 
    //  =====
    //  コンストラクタ(データベースへの接続)
    //  =====
    //  [引数]
    //   $dbname     string     データベース名    (デフォルト：SQLite_DBNAME)
    //   $charset    string     キャラクタセット名(デフォルト：SQLite_CHARSET)
        public function __construct($dbname = SQLite_DBNAME, $charset = SQLite_CHARSET) {
        //  データベース指定値退避
        $this->dbname   = trim($dbname);
        $this->charset  = trim($charset);
        //  初期化
        $this->sql = "";
        $this->clearError();
        //  データベース接続
        try {
            $dsn = "sqlite:dbname={$this->dbname}";
            $this->pdo = new PDO($dsn);
            // SQL実行時にもエラーの代わりに例外を投げるように設定
            // (毎回if文を書く必要がなくなる)
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // デフォルトのフェッチモードを連想配列形式に設定 
            // (毎回PDO::FETCH_ASSOCを指定する必要が無くなる)
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'データベース接続エラー:'.$e->getMessage();
        }
        if ($this->pdo == false) {
            die("データベースへの接続に失敗しました。");
        }
    }
 
    //  =====
    //  エラー情報クリア
    //  =====
    protected function clearError() {
        $this->error = array(0 => null, 1 => null, 2 => null);
    }
 
    //  =====
    //  データベース接続を閉じる
    //  =====
    public function close() {
        $this->pdo = null;
    }
 
    //  =====
    //  トランザクション開始
    //  =====
    public function begin() {
        return $this->pdo->beginTransaction();
    }
 
    //  =====
    //  トランザクション・コミット
    //  =====
    public function commit() {
        return $this->pdo->commit();
    }
 
    //  =====
    //  トランザクション・ロールバック
    //  =====
    public function rollback() {
        return $this->pdo->rollBack();
    }
 
    //  =====
    //  [prepare]メソッドのラッパ関数
    //  =====
    //  [引数]
    //   $sql        string     SQLステートメント
    //  [返り値]
    //   mixed       正常終了:[PDOStatement]オブジェクト,エラー:false
    public function prepare($sql) {
        //  エラークリア
        $this->clearError();
        //  SQL文の準備
        $pdostmt = $this->pdo->prepare($sql);
        if ($pdostmt === false) {
            //  エラーの場合
            $this->error = $pdostmt->errorInfo();
            return false;
        }
        //  [PDOStatement]オブジェクトを返す
        return $pdostmt;
    }
 
    //  =====
    //  最後のAUTOINCREMENTの取得
    //  =====
    //  [返り値]
    //   mixed       正常終了:最後に挿入された行の[ID]値の文字列
    //               エラー  :false (getLastError()でエラー情報が取得できる)
    public function lastInsertId() {
        //  エラークリア
        $this->clearError();
 
        try {
            $ret = $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            $this->error = $e->errorInfo;
            $ret = false;
        }
        return $ret;
    }
 
    //  =====
    //  SQLステートメント実行
    //  =====
    //  [引数]
    //   $sql        string     SQLステートメント
    //   $arrBind    array      SQL内のプレースホルダの値の配列 array(':name' => value, ...)
    //  [返り値]
    //   mixed       正常終了:SELECT文の場合[PDOStatement]オブジェクト,
    //                        SELECT文以外の場合 true,
    //               エラー  :false
    public function execute($sql, $arrBind = array()) {
        //  SQL準備
        $pdostmt = $this->prepare($sql);
        if ($pdostmt === false) {
            return false;
        }
        //  バインド
        foreach ($arrBind as $key => $val) {
            $ret = $pdostmt->bindValue($key, $val);
            if ($ret === false) {
                $this->error = $pdostmt->errorInfo();
                return false;
            }
        }
        //  実行
        $ret = $pdostmt->execute();
        if ($ret === false) {
            $this->error = $pdostmt->errorInfo();
            return false;
        }
        //  SELECTステートメントの場合??
        if (preg_match('/^select/i', trim($sql))) {
            //  [PDOStatement]オブジェクト
            return $pdostmt;
        }
        else {
            //  selectステートメント以外の場合
            return true;
        }
    }
 
    //  =====
    //  SQLステートメント実行し1個のカラム値を取得
    //  =====
    //  [引数]
    //   $sql        string     SQLステートメント
    //   $arrBind    array      SQL内のプレースホルダの値の配列 array(':name' => value, ...)
    //   $columnName string     カラム名、またはカラムIndex値
    //  [返り値]
    //   mixed       正常終了:カラムの値
    //               エラー  :false
    public function getColumnData($sql, $arrBind = array(), $columnName = 0) {
        //  SQLステートメント実行
        $pdostmt = $this->execute($sql, $arrBind);
        if ($pdostmt === false) {
            return false;
        }
        //  1行取得
        $row = $pdostmt->fetch();
        if ($row === false) {
            //  エラー
            $this->error = $pdostmt->errorInfo();
            $ret = false;
        } else {
            //  カラムデータ
            $ret = $row[$columnName];
        }
        //  接続を閉じる
        $pdostmt = null;
        //  カラムデータを返す
        return $ret;
    }
 
    //  =====
    //  SQLステートメント実行行数の取得
    //  =====
    //  [引数]
    //   $sql        string     SQLステートメント
    //   $arrBind    array      SQL内のプレースホルダの値の配列 array(':name' => value, ...)
    //  [返り値]
    //   mixed       正常終了:件数
    //               エラー  :false
    public function getSelectCount($sql, $arrBind = array()) {
        //  SELECT文を SELECT count(*) でラップ
        $sql = "select count(*) from ({$sql}) as tx";
        //  件数を取得して返します。
        return $this->getColumnData($sql, $arrBind);
    }
}
?>
