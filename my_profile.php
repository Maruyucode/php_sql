<?php
include('functions.php');
session_start();
checkSessionId();
checkEditUser();

// getで送信されたidを取得
$target_user_id = $_GET['id'];
$_SESSION['target_user_id'] = $_GET['id'];

//DB接続します
$pdo = connectToDb();

//データ登録SQL作成，指定したidのみ表示する
$sql = 'SELECT * FROM user_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $target_user_id, PDO::PARAM_INT);
$status = $stmt->execute();

//データ表示
if ($status == false) {
    // エラーのとき
    showSqlErrorMsg($stmt);
} else {
    // エラーでないとき
    $rs = $stmt->fetch();
    //my_profile_updateに渡すためのid
    $_SESSION['target_user_id'] = $target_user_id;
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>todo更新ページ</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">プロフィール更新</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">todo登録</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="select.php">todo一覧</a>
                    </li>
                    <li class="nav-item">
                        <p>id: <?= $_SESSION['user_id'] ?></p>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container">
        <form method="post" action="my_profile_update.php">
            <div class="form-group">
                <div for="name">id: <?= $rs['id'] ?></div>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <!-- 受け取った値をvaluesに埋め込もう -->
                <input type="text" class="form-control" id="name" name="name" value="<?= $rs['name'] ?>" required>
            </div>
            <div class="form-group">
                <label for="lid">lid</label>
                <!-- 受け取った値をvaluesに埋め込もう -->
                <input type="text" class="form-control" id="lid" name="lid" value="<?= $rs['lid'] ?>" required>
            </div>
            <div class="form-group">
                <label for="lpw">lpw</label>
                <!-- 受け取った値をvaluesに埋め込もう -->
                <input type="text" class="form-control" id="lpw" name="lpw" value="<?= $rs['lpw'] ?>" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">変更する</button>
            </div>
        </form>
        <div>
            <a href="unsubscribe.php" class="badge badge-danger">退会する</a>
        </div>
    </div>

</body>

</html>