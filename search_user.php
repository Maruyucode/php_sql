<?php
include('functions.php');
session_start();
checkSessionId();
$menu = menu();

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$word = htmlspecialchars($_GET['search']);

//DB接続
$pdo = connectToDb();

//データ表示SQL作成
/*
SELECT * FROM php02_table WHERE task LIKE '%task%'
*/

$sql = "SELECT * FROM user_table WHERE name LIKE '%$word%'";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//データ表示
$view = '';
if ($status == false) {
    showSqlErrorMsg($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //$view .= '<P>' . $result['id'] . $result['task'] . '</p>';
        $view .= '<li class="list-group-item">';
        $view .= '<div><span class="task">' . $result['name'] . '</span>' . '<span class="deadline">' . $result['id'] . '</span></div>';
        $view .= '<div>' . $result['lid'] . '</div>';
        $view .= '<div>' . $result['lpw'] . '</div>';
        $view .= '<a href="user_detail.php?id=' . $result['id'] . '" class="badge badge-primary">Edit</a>';
        //$view .= '<a href="user_delete.php?id=' . $result['id'] . '" class="badge badge-danger">Delete</a>';
        $view .= '</li>';
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>todoリスト表示</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
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
                        <a class="nav-link user" href="select.php">[ 現在のユーザー] <?= $user_id ?> , <?= $user_name ?></a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
    <div class="container">
        <div>「<?= $word ?>」の検索結果</div>
        <div><?= $view ?></div>
    </div>

</body>

</html>