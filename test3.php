<?php
//ステータスコードを追記する必要あり
//json形式ファイルのheader
header("Content-Type: application/json; charset=utf-8");

// DBとの連携
try{
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8','root','root');
    echo "接続OK";
    // データベース
$data = "user";
// SQL構文
$table = "SELECT * FROM $data";
// クエリ(問い合わせ)
$sql = $db->query($table);
// 全データ表示
while($table = $sql -> fetch()) {
        print($data."のデータ:".$table['user_id'].$table['name'].$table['pass']);

}

// URLを表示
echo (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if(isset($_GET["num"])) {
    // numをエスケープ(xss対策)
    $param = htmlspecialchars($_GET["num"]);
    //SQL構文
    $table2 = "SELECT user_id, name FROM $data WHERE user_id = $param";
    // メイン処理
    $arr["status"] = "yes";
    $sql2 = $db->query($table2);
    while($table2 = $sql2 -> fetch()) {
    $arr["name"] = $table2['name'];

}

} else {
    // paramの値が不適ならstatusをnoにしてプログラム終了
    $arr["status"] = "no";
}

// 配列をjson形式にデコードして出力, 第二引数は、整形するためのオプション
print json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch(PDOException $e) {
    echo "error".$e->getMessage();
}




?>