<?php
/*
データベースに新しいユーザを登録する
http通信例
http://localhost:8888/APItest/register.php?name=田中&pass=Password
*/

//セッションの開始
session_start();
//エラーリポート
error_reporting(E_ALL);

#ステータスコードを追記する必要あり
//json形式ファイルのheader
header("Content-Type: application/json; charset=utf-8");

// DBとの連携
try{
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8','root','root');
    echo "接続OK";

    // データベース
    $data = "user";
    // SQL構文(最新のユーザIDを取得)
    $table = "SELECT user_id FROM $data ORDER BY user_id DESC LIMIT 1";
    // クエリ(問い合わせ)
    $sql = $db->query($table);
    $user_id = $sql->fetchAll(PDO::FETCH_ASSOC);
    print($user_id[0]['user_id']);

    // URL後のクエリストリング"user_id"と"pass"をGET
    if(isset($_GET["name"]) && isset($_GET["pass"])) {
    // エスケープ(xss対策)
    $param_name = htmlspecialchars($_GET["name"]);
    $param_pass = htmlspecialchars($_GET["pass"]);
    // table2に検索するSQL構文
    $sql = "INSERT INTO user (user_id, name, pass) VALUES (:user_id, :name, :pass)";
    // dbに登録するsqlを準備
    $stmt = $db->prepare($sql);

    // idを自動追加する
    // 現在の最新IDの番号を取得
    $new_id = (int) $user_id[0]['user_id'];
    echo $new_id;
    echo gettype($new_id);

    // 新しいIDに1プラス
    $new_id += 1;
    echo $new_id;

    // SQL文に値を設定
    $param = array(':user_id' => $new_id, ':name' => $param_name, ':pass' => $param_pass);

    echo $param_name."OK";

    // dbにexecute
    $stmt->execute($param);
        if (!$stmt) {
            die('SELECTクエリーが失敗しました。');
        }
        echo '登録完了しました';

    } else {
    // paramの値が不適ならstatusをnoにしてプログラム終了
    echo "error";
    }
} catch(PDOException $e) {
    echo "error".$e->getMessage();
}
    // データベースを閉じる
    $db = null;


?>