<?php

session_start();

// 外部ファイル読み込み
include('functions.php');

//フォームからきたデータをうけとる
$name = $_POST['name'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

//db接続
$pdo = connectToDb();

//ユーザー情報の重複をチェックする lidのみ
$sql = 'SELECT COUNT(*) AS cnt FROM `user_table` WHERE name = :lid';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);    
$status = $stmt->execute();
$res = $stmt->fetch();
$chk = (int)$res['cnt'];
if($chk != 0){
    $_SESSION['errorMsg'] = '※そのlidはすでに使用されています';
    header('Location: signup.php');
    exit();
}
/*
SELECT COUNT(*) AS cnt FROM `user_table` WHERE name = :lid;
*/

// ユーザー情報の登録
$sql = 'INSERT INTO user_table(id, name, lid, lpw, kanri_flg, life_flg)
VALUES(NULL, :a1, :a2, :a3, 0, 0)';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $lid, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合
if ($status == false) {
    showSqlErrorMsg($stmt);
}

//新規登録したユーザーのid を取得
$id = $pdo->lastInsertId();
//vd($pdo->lastInsertId(), true); //最後にインサートしたIdを取得できる


if($id != ''){
    //必要なsession_idやユーザー情報などをここで送る
    $_SESSION = array();
    //session_idを発行
    $_SESSION['session_id'] = session_id();
    //管理者権限があるかどうか
    $_SESSION['kanri_flg'] = 0;
    // ログインユーザーの名前とid
    $_SESSION['user_id'] = $id;
    $_SESSION['user_name'] = $name;

    header('Location: select.php');
    
} else {
    header('Location: signup.php');
} 

?>