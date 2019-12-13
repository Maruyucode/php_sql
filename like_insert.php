<?php

// 関数ファイルの読み込み
include('functions.php');
session_start();
checkSessionId();

// GETデータ取得
// select.phpにあるlikeボタンのhrefにuser_idとtask_idを記述し、こちらの$_GETでとる
$user_id = $_GET['user_id'];
$task_id = $_GET['task_id'];

//DB接続
$pdo = connectToDb();

// いいね状態のチェック(COUNTで件数を取得できる!)
// 押したLIKEボタンのuser_idとtask_idを取得し、その両方と合致するテーブルがあるか探す
$sql = 'SELECT COUNT(*) FROM like_table WHERE user_id=:a1 AND task_id=:a2'; // COUNTで件数を取得
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':a2', $task_id, PDO::PARAM_INT);
$status = $stmt->execute();
if ($status == false) {
    showSqlErrorMsg($stmt);
} else {
    // エラーでない場合，取得した件数を変数に入れる
    $like_count = $stmt->fetch();
}

// いいねしていれば削除，していなければ追加のSQLを作成 
if ($like_count[0] != 0) {
    // いいねがすでにある
    $sql = 'DELETE FROM like_table WHERE user_id=:a1 AND task_id=:a2';
} else {
    // いいねがまだない
    $sql = 'INSERT INTO like_table(id, user_id, task_id, created_at) VALUES(NULL, :a1, :a2, sysdate())'; // 1行で記述!
}

// SQL実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':a2', $task_id, PDO::PARAM_INT);
$status = $stmt->execute();
//データ登録処理後
if ($status == false) {
    showSqlErrorMsg($stmt);
} else {
    header('Location: select.php');
}