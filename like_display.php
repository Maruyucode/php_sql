<?php
include('functions.php');

$user_id = $_GET['id'];

$swt = 'default';
if(isset($_GET['s'])){
    $swt = $_GET['s'];
}

//DB接続
$pdo = connectToDb();

//データ表示SQL作成
/*
SELECT * FROM php02_table 
INNER JOIN (SELECT task_id, COUNT(id) AS cnt 
FROM like_table GROUP BY task_id) AS likes
ON php02_table.id = likes.task_id 
INNER JOIN (SELECT task_id FROM like_table WHERE user_id = 1)  AS userSelected
ON php02_table.id = userSelected.task_id
ORDER BY cnt DESC;
*/

switch($swt){
    case 'likes_num':
        $sql =  'SELECT * FROM php02_table 
                INNER JOIN (SELECT task_id, COUNT(*) AS cnt 
                FROM like_table GROUP BY task_id) AS likes
                ON php02_table.id = likes.task_id 
                INNER JOIN (SELECT task_id FROM like_table WHERE user_id = :a1)  AS userSelected
                ON php02_table.id = userSelected.task_id
                ORDER BY cnt DESC';
        break;

    default:
        $sql =  'SELECT * FROM php02_table 
                INNER JOIN (SELECT task_id, COUNT(*) AS cnt 
                FROM like_table GROUP BY task_id) AS likes
                ON php02_table.id = likes.task_id 
                INNER JOIN (SELECT task_id FROM like_table WHERE user_id = :a1)  AS userSelected
                ON php02_table.id = userSelected.task_id';
        break;
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $user_id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
$view = '';
if ($status == false) {
    showSqlErrorMsg($stmt);
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //$view .= '<P>' . $result['id'] . $result['task'] . '</p>';
        $view .= '<li class="list-group-item">';
        $view .= '<div><span class="task">' . $result['task'] . '</span>' . '<span class="deadline">' . $result['deadline'] . '</span></div>';
        $view .= '<div>' . $result['comment'] . '</div>';
        // いいねボタンを押しているのは現在のユーザー
        $view .= '<a href="like_insert.php?task_id=' . $result['id'] . '&user_id=' . $user_id . '" class="badge badge-primary">LIKE' . $result['cnt'] . '</a>';
        $view .= '<a href="detail.php?id=' . $result['id'] . '" class="badge badge-primary">Edit</a>';
        $view .= '<a href="delete.php?id=' . $result['id'] . '" class="badge badge-danger">Delete</a>';
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
        <div class="menu">
            <ul class="navbar-nav">
                <li><a href="like_display.php?id=<?= $user_id ?>&s=likes_num">LIKE数で並べ替え</a></li>
            </ul>
        </div>
        <div><?= $view ?></div>
    </div>

</body>

</html>