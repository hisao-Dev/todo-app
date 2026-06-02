<?php
$host = 'localhost';
$db   = 'todo_app';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// dsn（Data Source Name）
// どのデータベースにどう接続するかをまとめた文字列
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";


// PDO（PHP Data Objects）クラスを使ってMySQLに接続する
// new PDO() → PDOクラスのインスタンス（オブジェクト）を作る
// $pdoに接続オブジェクトが入る(データベースとの接続を保持し、操作を行うためのオブジェクト)
// setAttribute() PDOの設定を変更するメソッド
// PDO::ATTR_ERRMODE エラーに関する属性（設定項目）の扱い方 attribute（アトリビュート）属性
// PDO::ERRMODE_EXCEPTION エラーが起きたら例外を投げる exception（エクセプション）例外
// PDOExecption $e PDOExceptionという種類の例外が起きたら、その情報を $e という変数に入れて処理する
// $eはPDOExceptionのオブジェクト。中にメッセージ、コード、発生場所、スタックトレースが含まれている
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "データベース接続成功";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage();
}
?>