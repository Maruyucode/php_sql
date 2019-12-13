<?php
session_start();
$msg = '';

//login_actででたエラーをここで取得してhtmlに挿入
if (isset($_SESSION['errorMsg'])) {
    $msg = $_SESSION['errorMsg'];
    session_destroy();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <header></header>
    <div class="login">
        <div class="errorMsg"><?= $msg ?></div>
        <form action="login_act.php" method="post">
            <div class="form-group">
                <label for="lid">LoginID</label>
                <input type="text" class="form-control" id="lid" name="lid">
            </div>
            <div class="form-group">
                <label for="lpw">Pass</label>
                <input type="password" class="form-control" id="lpw" name="lpw">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">ログイン</button>
            </div>
        </form>
        <div>
            <a href="signup.php">新規登録する</a>
        </div>
    </div>

</body>

</html>