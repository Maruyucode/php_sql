<?php

include('functions.php');
session_start();
checkSessionId();
checkAdmin();

$menu = menu();

// ユーザーidの指定（今回は固定値）
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

/*
SELECT * FROM php02_table WHERE task LIKE '%task%'
*/

//DB接続
$pdo = connectToDb();

//データ表示SQL作成
$sql = 'SELECT * FROM user_table';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();   //SELECTで取得したデータは$stmtが持ってる

//データ表示
$view = '';
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  //HTMLに表示
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<li class="list-group-item">';
    $view .= '<div><span class="task">' . $result['name'] . '</span>' . '<span class="deadline">' . $result['id'] . '</span></div>';
    $view .= '<div>' . $result['lid'] . '</div>';
    $view .= '<div>' . $result['lpw'] . '</div>';
    $view .= '<a href="user_detail.php?id=' . $result['id'] . '" class="badge badge-primary">Edit</a>';
    //$view .= '<a href="user_delete.php?id=' . $result['id'] . '" class="badge badge-danger">Delete</a>';
    $view .= '</li>';
  }
}

/*上記のwhile文について
SELECTしたデータをもってる$stmtをwhile文でまわして狙った値を取得していく
fetch()はテーブルから１行(1record)1ずつ取り出すという関数
fetchで取得した１レコードのデータが$resultに配列として代入される
$resultに配列が代入されるまで、つまりレコードの数だけwhile文がまわる、と
*/

$admin = admin($_SESSION['kanri_flg']);
$header_str = '';
if ($admin) {
  $header_str .= '<li class="nav-item">';
  $header_str .= '<a class="nav-link" href="user_detail.php">user管理</a>';
  $header_str .= '</li>';
}

?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>user管理</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">user管理</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">+ 新しいTodo</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="select.php">Todo一覧</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="like_display.php?id=<?= $user_id ?>">お気に入り</a>
          </li>
          <?= $menu ?>
          <li class="nav-item">
            <a class="nav-link user" href="user_detail.php?id=<?= $user_id ?>">[ 現在のユーザー] <?= $user_id ?> , <?= $user_name ?></a>
          </li>
          <?= $header_str ?>
        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <form action="search_user.php" method="get">
      <!-- 任意の<input>要素＝入力欄などを用意する -->
      <input type="text" name="search">
      <button type="submit" class="btn btn-primary">ユーザー名を検索</button>
    </form>
    <div>
      <ul class="list-group">
        <?= $view ?>
      </ul>
    </div>
  </div>

</body>

</html>