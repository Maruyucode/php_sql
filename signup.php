<?php
session_start();
include('functions.php');
$msg = '';
//vd(isset($_SESSION['errorMsg']), true);
if(isset($_SESSION['errorMsg'])){
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
    <title>新規登録</title>
</head>

<body>
    <header>新規登録</header>
        <div class="login">
            <div class="errorMsg"><?= $msg ?></div>
            <form method="post" action="signup_act.php">
                <div class="form-group">
                    <label for="name">Name</label>
                    <!-- 受け取った値をvaluesに埋め込もう -->
                    <input type="text" class="form-control" id="name" name="name" value="" required>
                </div>
                <div class="form-group">
                    <label for="lid">lid</label>
                    <!-- 受け取った値をvaluesに埋め込もう -->
                    <input type="text" class="form-control" id="lid" name="lid" value="" required>
                </div>
                <div class="form-group">
                    <label for="lpw">lpw</label>
                    <!-- 受け取った値をvaluesに埋め込もう -->
                    <input type="text" class="form-control" id="lpw" name="lpw" value="" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">登録する</button>
                </div>
            </form>
        </div>

</body>

</html>