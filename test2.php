
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>WebAPI test</title>
  <style type="text/css">
  /* 見やすいように文字を大きく */
  body,
  input,
  button {
    font-size: 30px;
  }
  </style>
</head>
<body>
  <h2>WebAPI</h2>
  <h3>リクエスト</h3>
  <!-- ajax()を実行するボタン -->
  <form action="test2.php" method="post">
      <textarea name="name" cols="10" rows="1" placeholder="名前"></textarea><br>
      <textarea name="password" cols="10" rows="1" placeholder="パスワード"></textarea><br>
    <button type="submit" name="add">Data add!</button>
    <button type="submit" name="show">Show data</button>
  </form>

  <br><br>
  <h3>結果</h3>
  <!-- 結果表示用のdivタグ -->
  <div data-result="">未取得</div>
  <!-- <script type="text/javascript" src="api2.js"></script> -->
</body>
</html>

<?php
try{
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8','root','root');
    echo "接続OK";
} catch(PDOException $e) {
    echo "error".$e->getMessage();
}
if (isset($_POST['add'])) {
    try{
    $count = $db ->exec('INSERT INTO user_id SET user_id="0004", name="'.$_POST['name'].'", pass="'.$_POST['password']); 
    echo $count."登録しました";
    }catch(PDOException $e){
        echo '接続エラー'.$e->getMessage();
    }
} else if(isset($_POST['show'])) {
    $data = "user";
    $table = "SELECT * FROM $data";
    $sql = $db->query($table);
    while($table2 = $sql -> fetch()) {
        print($data."のデータ：".$table2['user_id'].$table2['name'].$table2['pass']);
    }
}


?>