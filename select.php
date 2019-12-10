<?php
include('functions.php');

// ユーザーidの指定（今回は固定値）
$user_id = userID();
// $user_id = 2;
// $user_id = 3;

/*
SELECT * FROM php02_table WHERE task LIKE '%task%'
*/

//DB接続
$pdo = connectToDb();

// // taskごとのいいね数カウント確認
// $sql = 'SELECT task_id, COUNT(id) AS cnt FROM like_table GROUP BY task_id';
// $stmt = $pdo->prepare($sql);
// $status = $stmt->execute();
// if ($status == false) {
//   showSqlErrorMsg($stmt);
// } else {
//   $result = $stmt->fetchAll();
//   var_dump(($result));
// }

//データ表示SQL作成
// $sql = 'SELECT * FROM php02_table';
$sql = 'SELECT * FROM php02_table 
        LEFT OUTER JOIN (SELECT task_id, COUNT(id) AS cnt 
        FROM like_table GROUP BY task_id) AS likes
        ON php02_table.id = likes.task_id';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();   //SELECTで取得したデータは$stmtが持ってる

//データ表示
$view = '';
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<li class="list-group-item">';
    $view .= '<div><span class="task">' . $result['task'] . '</span>' . '<span class="deadline">' . $result['deadline'] . '</span></div>';
    $view .= '<div>' . $result['comment'] . '</div>';
    // いいねボタン
    $view .= '<a href="like_insert.php?task_id=' . $result['id'] . '&user_id=' . $user_id . '" class="badge badge-primary">LIKE' . $result['cnt'] . '</a>';
    $view .= '<a href="detail.php?id=' . $result['id'] . '" class="badge badge-primary">Edit</a>';
    $view .= '<a href="delete.php?id=' . $result['id'] . '" class="badge badge-danger">Delete</a>';
    $view .= '</li>';
  }
}

/*上記のwhile文について
SELECTしたデータをもってる$stmtをwhile文でまわして狙った値を取得していく
fetch()はテーブルから１行(1record)1ずつ取り出すという関数
fetchで取得した１レコードのデータが$resultに配列として代入される
$resultに配列が代入されるまで、つまりレコードの数だけwhile文がまわる、と
*/
?>



<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>todoリスト表示</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="select.css">
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Todo一覧</a>
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
          <li class="nav-item">
            <a class="nav-link user" href="select.php">現在のユーザー：<?= $user_id ?></a>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <div class="container">
    <form action="search.php" method="get">
      <!-- 任意の<input>要素＝入力欄などを用意する -->
      <input type="text" name="search">
      <button type="submit" class="btn btn-primary">タスクを検索</button>
    </form>
    <div>
      <ul class="list-group">
        <?= $view ?>
      </ul>
    </div>
  </div>

</body>

</html>