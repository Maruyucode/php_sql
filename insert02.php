<?php

include('functions.php');

//入力データのチェック
if(
    !isset($_POST['task']) || $_POST['task'] == '' ||
    !isset($_POST['deadline']) || $_POST['deadline'] == ''
){
    exit();
}

// POSTデータの取得
$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];

// DBに接続 pdoがreturnされる
$pdo = connectToDb();

// データの登録 SQL作成
$sql = 'INSERT INTO '



//データ登録が終わった後の処理

?>